<?php 
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

// stylos
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

//background
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;

//AUTOSIZE
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithMapping;

class ReportUtilityExport implements FromView, WithColumnFormatting, WithStyles, WithBackgroundColor, ShouldAutoSize
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
     
        return view('exports.reports.utility',[
            'data' => $this->data
        ]);
      
    }

    public function columnFormats(): array
    {
        return [
            // 'A' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
            // 'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // // Style the first row as bold text.
            5 => ['font' => ['bold' => true]],
            7 => ['font' => ['bold' => true]],
            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],
            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function backgroundColor()
    {
        // Return RGB color code.
        // return '000000';
    
        // Return a Color instance. The fill type will automatically be set to "solid"
        // return new Color(Color::COLOR_BLUE);
    
        // Or return the styles array
        // return [
        //      1   => Fill::FILL_GRADIENT_LINEAR,
        //      'startColor' => ['argb' => Color::COLOR_RED],
        // ];
    }
}