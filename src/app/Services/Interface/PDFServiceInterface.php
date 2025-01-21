<?php

namespace App\Services\Interface;

interface PDFServiceInterface
{
    public function addSignature(string $documentPath, string $signaturePath, string $outputPath): void;
    public function setPosition(int $positionX, int $positionY, int $positionW): void;
}
