<?php

namespace App\Services\Document;

use App\Services\Interface\PDFServiceInterface;
use setasign\Fpdi\Fpdi;

class PDFService implements PDFServiceInterface
{
    public int $positionX = 10;
    public int $positionY = 10;
    public int $positionW = 10;

    /**
     * @param string $documentPath
     * @param string $signaturePath
     * @param string $outputPath
     * @return void
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\Filter\FilterException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function addSignature(string $documentPath, string $signaturePath, string $outputPath): void
    {
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile(storage_path('app/private/' . $documentPath));
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template);
        $pdf->Image(storage_path('app/private/' . $signaturePath), $this->positionX, $this->positionY, $this->positionW);
        $pdf->Output(storage_path('app/' . $outputPath), 'F');
    }


    /**
     * @param int $positionX
     * @param int $positionY
     * @param int $positionW
     * @return void
     */
    public function setPosition(int $positionX = 10, int $positionY = 10, int $positionW = 30): void
    {
        $this->positionX = $positionX;
        $this->positionY = $positionY;
        $this->positionW = $positionW;
    }
}
