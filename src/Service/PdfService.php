<?php

namespace App\Service;

use Mpdf\Mpdf;

class PdfService
{
    private $mpdf;

    public function __construct()
    {
        $this->mpdf = new Mpdf();
    }

    public function generatePdf(string $template, $name, $output = 'I'): string
    {
        $this->generateTemplate($template);
        return $this->mpdf->Output($name . '.pdf', $output);
    }

    public function generateTemplate(string $template): void
    {
        $this->mpdf->WriteHTML($template);
    }
}