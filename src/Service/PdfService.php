<?php

namespace App\Service;

use Mpdf\Mpdf;

class PdfService
{
    private Mpdf $mpdf;

    public function __construct()
    {
        $this->mpdf = new Mpdf();
    }

    public function generatePdf($name, $output = 'I'): string
    {
        return $this->mpdf->Output($name . '.pdf', $output);
    }

    public function generateTemplate(string $template): void
    {
        // Ajouter une nouvelle page
        $this->mpdf->AddPage();

        // Écrivez le HTML combiné dans mPDF
        $this->mpdf->WriteHTML($template);
    }

}