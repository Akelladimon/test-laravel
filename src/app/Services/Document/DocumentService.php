<?php

namespace App\Services\Document;

use App\Http\Requests\Document\SignDocumentRequest;
use App\Models\Document;
use App\Models\SignatureRequest;
use App\Services\Interface\PDFServiceInterface;
use Illuminate\Http\UploadedFile;

class DocumentService
{

    public function __construct(protected PDFServiceInterface $pdfService)
    {
    }

    /**
     * Upload a document and save its metadata.
     *
     * @param UploadedFile $file
     * @return Document
     */
    public function uploadDocument(UploadedFile $file): Document
    {
        // Store the file securely
        $path = $file->store('documents', 'local');
        return Document::create([
            Document::NAME_ATTRIBUTE => $file->getClientOriginalName(),
            Document::PATH_ATTRIBUTE => $path,
            Document::SIZE_ATTRIBUTE => $file->getSize(),
        ]);
    }

    /**
     * @param SignDocumentRequest $request
     * @return string
     */
    public function signDocument(SignDocumentRequest $request): string
    {
        $validated = $request->validated();
        $document = $this->getDocumentById($validated['document_id']);
        $signaturePath = $this->storeSignature($request);
        $signedDocumentPath = $this->generateSignedDocumentPath($document->id);
        $this->configurePdfService($request);
        $this->pdfService->addSignature($document->path, $signaturePath, $signedDocumentPath);
        $document->update([Document::PATH_ATTRIBUTE => $signedDocumentPath]);
        $this->updateSignatureRequest($document->id, $validated['receiver_id']);

        return $signedDocumentPath;
    }

    private function getDocumentById(int $documentId): Document
    {
        return Document::findOrFail($documentId);
    }

    private function storeSignature(SignDocumentRequest $request): string
    {
        return $request->file('signature')->store('signatures');
    }

    private function generateSignedDocumentPath(int $documentId): string
    {
        return 'signed_documents/' . $documentId . '.pdf';
    }

    private function configurePdfService(SignDocumentRequest $request): void
    {
        $this->pdfService->setPosition(
            $request->get('positionX', config('services.signature.position.x')),
            $request->get('positionY', config('services.signature.position.y')),
            $request->get('positionW', config('services.signature.position.w'))
        );
    }

    private function updateSignatureRequest(int $documentId, int $receiverId): void
    {
        $signatureRequest = SignatureRequest::where(
            SignatureRequest::DOCUMENT_ID_ATTRIBUTE, $documentId
        )->where(
            SignatureRequest::RECEIVER_ID_ATTRIBUTE, $receiverId
        )->firstOrFail();

        $signatureRequest->update([
            SignatureRequest::STATUS_ATTRIBUTE => SignatureRequest::STATUS_SIGNED,
        ]);
    }
}
