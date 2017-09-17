<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Liquidation;
use Illuminate\Http\Request;
use FPDF;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        return view('settings');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function rules()
    {
        return view('rules');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function incompletes()
    {
        return view('incompletes');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function liquidated()
    {
        return view('liquidated');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadLiquidated(Liquidation $liquidation)
    {
        $agency = Agency::find($liquidation->agency_id);
        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Image('http://www.turismoisabel.com.ar/img/logo.png', 15, 15, 75, 0, 'PNG');
        $pdf->Cell(190, 20, ' Tel.: 4642 1145', 0, 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(1, 30, 'turismoisabel@hotmail.com', 0, 0, 'R');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(100, 10, 'Agencia: ' . $agency->name);
        $pdf->SetFont('Arial', null, 14);
        $pdf->Cell(50, 10, 'Desde: ' . $liquidation->date_init);
        $pdf->Cell(40, 10, 'Hasta: ' . $liquidation->date_end);
        $pdf->Ln();

        // Cabecera
        $pdf->SetFont('Arial', 'B', 14);
        foreach (['Fecha', 'Servicio', 'Guia', 'Chofer', 'Vehiculo', 'Peaje', 'Importe'] as $col) {
            $pdf->Cell(28, 10, $col, 1, 0, 'C');
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', null, 10);
        // Datos
        foreach ($liquidation->services as $row) {
            foreach ([
                         date('d-m-Y', strtotime($row['date'])),
                         $row['route'],
                         $row['courier'],
                         $row['chauffeur'],
                         $row['vehicle'],
                     ] as $col) {
                $pdf->Cell(28, 5, $col, 1, 0, 'C');
            }
            foreach ([
                         $row['tax'],
                         $row['paying'],
                     ] as $col) {
                $pdf->Cell(28, 5, $col, 1, 0, 'R');
            }
            $pdf->Ln();
        }

        // Footer
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(140, 5, 'Peaje:', 1, 0, 'R');
        $pdf->Cell(28, 5, $liquidation->tax, 1, 0, 'R');
        $pdf->Cell(28, 5, '', 1);
        $pdf->Ln();
        $pdf->Cell(140, 5, 'Servicios:', 1, 0, 'R');
        $pdf->Cell(28, 5, '', 1);
        $pdf->Cell(28, 5, $liquidation->total, 1, 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(140, 10, '', 1);
        $pdf->Cell(28, 10, 'Total:', 1, 0, 'R');
        $pdf->Cell(28, 10, ($liquidation->total + $liquidation->tax), 1, 0, 'R');
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadCSVLiquidated(Liquidation $liquidation)
    {
        $agency = Agency::find($liquidation->agency_id);
        $rows = [];
        $rows [] = implode(',', [
            'Agencia:',
            $agency->name,
            '',
            '',
            'Desde: ', $liquidation->date_init,
            'Hasta: ', $liquidation->date_end,
        ]);
        $rows [] = implode(',', [
            'Fecha',
            'Servicio',
            'Guia',
            'Chofer',
            'Vehiculo',
            'Peaje',
            'Importe',
        ]);
        // Datos
        foreach ($liquidation->services as $row) {
            $rows [] = implode(',', [
                date('d-m-Y', strtotime($row['date'])),
                $row['route'],
                $row['courier'],
                $row['chauffeur'],
                $row['vehicle'],
                $row['tax'],
                $row['paying'],

            ]);
        }

        $rows [] = implode(',', [
            '',
            '',
            '',
            '',
            'Peaje:',
            $liquidation->tax,
            '',
        ]);

        $rows [] = implode(',', [
            '',
            '',
            '',
            '',
            'Servicios:',
            '',
            $liquidation->total,
        ]);

        $rows [] = implode(',', [
            '',
            '',
            '',
            '',
            'Total:',
            '',
            ($liquidation->total + $liquidation->tax),
        ]);

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=liquidacion_" . $liquidation->id . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        return Response::make(implode(PHP_EOL,$rows),200  , $headers);

    }
}
