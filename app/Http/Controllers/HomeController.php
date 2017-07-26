<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Liquidation;
use Illuminate\Http\Request;
use FPDF;

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
        $agency = Agency::find($liquidation)->first();
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(100, 10, 'Agencia:' . $agency->name);
        $pdf->SetFont('Arial', null, 16);
        $pdf->Cell(50, 10, 'desde:' . $liquidation->date_init);
        $pdf->Cell(40, 10, 'hasta:' . $liquidation->date_end);
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(1, 20, 'Detalle:');
        $pdf->Ln();


        // Cabecera
        foreach (['Fecha', 'Turno', 'Vehiculo', 'Chofer', 'Guia','Tipo', 'Pax', 'Importe'] as $col) {
            $pdf->Cell(25, 10, $col, 1);
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', null, 10);
        // Datos
        foreach ($liquidation->services as $row) {
            foreach ([
                         $row['date'],
                         $row['turn'],
                         $row['vehicle_id'],
                         $row['chauffeur_id'],
                         $row['courier'],
                         $row['type_trip_id'],
                         $row['passengers'],
                         $row['paying']
                     ] as $col) {
                $pdf->Cell(25, 5, $col, 1);
            }
            $pdf->Ln();
        }

        // Footer
        $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(150, 10, '', 1);
            $pdf->Cell(25, 10, 'Total', 1);
            $pdf->Cell(25, 10, $liquidation->total, 1);
        $pdf->Ln();
        $pdf->Output();
        exit;
    }
}
