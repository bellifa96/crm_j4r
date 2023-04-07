<?php

namespace App\Service;

use Mpdf\Mpdf;

class PdfService
{
    private $pdf;

    public function __construct(Mpdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function generatePdf(string $template, $name, $output = 'D'): string
    {
        $this->pdf->WriteHTML($template);
        return $this->pdf->Output($name . '.pdf', $output);
    }
}