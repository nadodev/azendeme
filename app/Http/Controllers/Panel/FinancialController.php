<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\FinancialTransaction;
use App\Models\CashRegister;
use App\Models\CashPeriod;
use App\Models\PaymentMethod;
use App\Models\TransactionCategory;
use App\Models\Professional;
use App\Services\ReceiptService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    protected $professionalId = 1; // Temporário

    public function dashboard()
    {

        $professional = Professional::findOrFail($this->professionalId);
        
        // Estatísticas do mês atual
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $monthlyIncome = FinancialTransaction::where('professional_id', $this->professionalId)
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->where('type', 'income')
            ->where('status', 'completed')
            ->sum('amount');
            
        $monthlyExpense = FinancialTransaction::where('professional_id', $this->professionalId)
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->where('type', 'expense')
            ->where('status', 'completed')
            ->sum('amount');
            
        $monthlyProfit = $monthlyIncome - $monthlyExpense;
        
        // Transações recentes
        $recentTransactions = FinancialTransaction::where('professional_id', $this->professionalId)
            ->with(['category', 'paymentMethod', 'customer'])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Caixa de hoje
        $todayCashRegister = CashRegister::where('professional_id', $this->professionalId)
            ->today()
            ->first();

        return view('panel.financial.dashboard', compact(
            'monthlyIncome',
            'monthlyExpense',
            'monthlyProfit',
            'recentTransactions',
            'todayCashRegister'
        ));
    }

    public function transactions(Request $request)
    {
        $query = FinancialTransaction::where('professional_id', $this->professionalId)
            ->with(['category', 'paymentMethod', 'customer', 'service']);
            
        // Filtros
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }
        
        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        $categories = TransactionCategory::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->orderBy('name')
            ->get();
            
        $paymentMethods = PaymentMethod::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('panel.financial.transactions', compact('transactions', 'categories', 'paymentMethods'));
    }

    public function createTransaction()
    {
        $categories = TransactionCategory::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->orderBy('name')
            ->get();
            
        $paymentMethods = PaymentMethod::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return view('panel.financial.create-transaction', compact('categories', 'paymentMethods'));
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:transaction_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['professional_id'] = $this->professionalId;
        $validated['status'] = 'completed';
        $validated['paid_at'] = now();
        $validated['created_by'] = auth()->id();

        // Vincular ao caixa aberto do dia, se existir
        $cashRegister = CashRegister::where('professional_id', $this->professionalId)
            ->where('date', $validated['transaction_date'])
            ->where('status', 'open')
            ->first();

        if ($cashRegister) {
            $validated['cash_register_id'] = $cashRegister->id;
            
            // Atualizar totais do caixa
            if ($validated['type'] === 'income') {
                $cashRegister->total_income += $validated['amount'];
            } else {
                $cashRegister->total_expense += $validated['amount'];
            }
            $cashRegister->closing_balance = $cashRegister->opening_balance + $cashRegister->total_income - $cashRegister->total_expense;
            $cashRegister->save();
        }

        FinancialTransaction::create($validated);

        return redirect()->route('panel.financeiro.transacoes')
            ->with('success', 'Transação registrada com sucesso!');
    }

    public function cashRegister()
    {
        $todayRegister = CashRegister::where('professional_id', $this->professionalId)
            ->today()
            ->first();
            
        $recentRegisters = CashRegister::where('professional_id', $this->professionalId)
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return view('panel.financial.cash-register', compact('todayRegister', 'recentRegisters'));
    }

    public function openCashRegister(Request $request)
    {
        $validated = $request->validate([
            'opening_balance' => 'required|numeric|min:0',
        ]);

        $existingRegister = CashRegister::where('professional_id', $this->professionalId)
            ->today()
            ->first();

        if ($existingRegister) {
            return back()->with('error', 'Já existe um caixa aberto para hoje!');
        }

        CashRegister::create([
            'professional_id' => $this->professionalId,
            'date' => Carbon::today(),
            'opening_balance' => $validated['opening_balance'],
            'status' => 'open',
            'opened_at' => now(),
            'opened_by' => auth()->id(),
        ]);

        return back()->with('success', 'Caixa aberto com sucesso!');
    }

    public function closeCashRegister($id)
    {
        $cashRegister = CashRegister::where('professional_id', $this->professionalId)
            ->findOrFail($id);

        if ($cashRegister->status === 'closed') {
            return back()->with('error', 'Este caixa já está fechado!');
        }

        $cashRegister->update([
            'status' => 'closed',
            'closed_at' => now(),
            'closed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Caixa fechado com sucesso!');
    }

    /**
     * Gera recibo para uma transação
     */
    public function generateReceipt($transactionId, ReceiptService $receiptService)
    {
        $transaction = FinancialTransaction::where('professional_id', $this->professionalId)
            ->findOrFail($transactionId);

        if ($transaction->type !== 'income') {
            return back()->with('error', 'Recibos só podem ser gerados para receitas!');
        }

        $receiptService->generateReceipt($transaction);

        return back()->with('success', 'Recibo gerado com sucesso!');
    }

    /**
     * Visualiza recibo de uma transação
     */
    public function viewReceipt($transactionId, ReceiptService $receiptService)
    {
        $transaction = FinancialTransaction::where('professional_id', $this->professionalId)
            ->findOrFail($transactionId);

        return $receiptService->viewReceipt($transaction);
    }

    /**
     * Lista períodos de caixa (diário, semanal, mensal)
     */
    public function cashPeriods(Request $request)
    {
        $periodType = $request->get('type', 'daily');

        $periods = CashPeriod::where('professional_id', $this->professionalId)
            ->where('period_type', $periodType)
            ->orderBy('period_start', 'desc')
            ->paginate(20);

        return view('panel.financial.cash-periods', compact('periods', 'periodType'));
    }

    /**
     * Cria/Abre um novo período de caixa
     */
    public function openCashPeriod(Request $request)
    {
        $validated = $request->validate([
            'period_type' => 'required|in:daily,weekly,monthly',
            'period_start' => 'required|date',
            'opening_balance' => 'required|numeric|min:0',
        ]);

        // Calcula data final baseado no tipo
        $start = Carbon::parse($validated['period_start']);
        switch ($validated['period_type']) {
            case 'daily':
                $end = $start->copy()->endOfDay();
                break;
            case 'weekly':
                $end = $start->copy()->endOfWeek();
                break;
            case 'monthly':
                $end = $start->copy()->endOfMonth();
                break;
        }

        $period = CashPeriod::create([
            'professional_id' => $this->professionalId,
            'period_type' => $validated['period_type'],
            'period_start' => $start,
            'period_end' => $end,
            'opening_balance' => $validated['opening_balance'],
            'status' => 'open',
        ]);

        return back()->with('success', 'Período de caixa aberto com sucesso!');
    }

    /**
     * Fecha um período de caixa e gera relatório
     */
    public function closeCashPeriod($id, ReceiptService $receiptService)
    {
        $period = CashPeriod::where('professional_id', $this->professionalId)
            ->findOrFail($id);

        if ($period->status === 'closed') {
            return back()->with('error', 'Este período já está fechado!');
        }

        // Calcula totais baseado nas transações do período
        $transactions = FinancialTransaction::where('professional_id', $this->professionalId)
            ->whereBetween('transaction_date', [$period->period_start, $period->period_end])
            ->where('status', 'completed')
            ->get();

        $period->total_income = $transactions->where('type', 'income')->sum('amount');
        $period->total_expense = $transactions->where('type', 'expense')->sum('amount');
        $period->total_transactions = $transactions->count();
        
        // Conta agendamentos no período
        $period->total_appointments = \App\Models\Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$period->period_start, $period->period_end])
            ->count();

        $period->close(auth()->id());

        // Gera relatório PDF
        $receiptService->generateCashClosureReport($period);

        return back()->with('success', 'Período fechado e relatório gerado com sucesso!');
    }

    /**
     * Visualiza relatório de fechamento
     */
    public function viewCashPeriodReport($id, ReceiptService $receiptService)
    {
        $period = CashPeriod::where('professional_id', $this->professionalId)
            ->with(['professional', 'closedBy'])
            ->findOrFail($id);

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('receipts.cash-closure', ['period' => $period])
            ->stream('fechamento-' . $period->period_start->format('Y-m-d') . '.pdf');
    }
}
