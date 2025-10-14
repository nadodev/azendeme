<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    protected $professionalId = 1;
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Dashboard de Analytics
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $metrics = $this->analyticsService->getDashboardMetrics(
            $this->professionalId,
            $startDate,
            $endDate
        );

        return view('panel.analytics.dashboard', compact('metrics', 'startDate', 'endDate'));
    }

    /**
     * Exportar relatório
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'general');
        $format = $request->get('format', 'pdf');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $data = $this->analyticsService->getDashboardMetrics(
            $this->professionalId,
            $startDate,
            $endDate
        );

        if ($format === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.analytics-pdf', compact('data', 'startDate', 'endDate'));
            return $pdf->download('relatorio-analytics-' . date('Y-m-d') . '.pdf');
        }

        // Para Excel, retorna JSON (pode ser implementado com maatwebsite/excel)
        return response()->json($data);
    }
}
