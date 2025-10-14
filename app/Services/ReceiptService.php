<?php

namespace App\Services;

use App\Models\FinancialTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ReceiptService
{
    /**
     * Gera um recibo em PDF para uma transação
     */
    public function generateReceipt(FinancialTransaction $transaction)
    {
        // Gera o número do recibo se ainda não tiver
        if (!$transaction->receipt_number) {
            $transaction->generateReceiptNumber();
        }

        // Carrega os dados necessários
        $transaction->load(['professional', 'customer', 'paymentMethod', 'appointment.service']);

        // Gera o PDF
        $pdf = Pdf::loadView('receipts.simple', ['transaction' => $transaction]);

        // Define o nome do arquivo
        $fileName = 'recibos/' . $transaction->receipt_number . '.pdf';

        // Salva o arquivo
        Storage::disk('public')->put($fileName, $pdf->output());

        // Atualiza o caminho no banco
        $transaction->update([
            'receipt_pdf_path' => $fileName,
        ]);

        return $transaction;
    }

    /**
     * Gera um recibo em PDF para visualização direta
     */
    public function viewReceipt(FinancialTransaction $transaction)
    {
        $transaction->load(['professional', 'customer', 'paymentMethod', 'appointment.service']);

        return Pdf::loadView('receipts.simple', ['transaction' => $transaction])
            ->stream($transaction->receipt_number . '.pdf');
    }

    /**
     * Gera um relatório de fechamento de caixa
     */
    public function generateCashClosureReport($cashPeriod)
    {
        $pdf = Pdf::loadView('receipts.cash-closure', ['period' => $cashPeriod]);

        $fileName = 'relatorios/fechamento-' . $cashPeriod->period_type . '-' . $cashPeriod->period_start->format('Y-m-d') . '.pdf';

        Storage::disk('public')->put($fileName, $pdf->output());

        $cashPeriod->update(['report_pdf_path' => $fileName]);

        return $cashPeriod;
    }
}

