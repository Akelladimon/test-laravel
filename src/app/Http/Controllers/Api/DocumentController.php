<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\DocumentUploadRequest;
use App\Http\Requests\Document\SignDocumentRequest;
use App\Services\Document\DocumentService;
use Illuminate\Http\JsonResponse;


/**
 * @group Document management
 * @authenticated
 * APIs for Document management
 */

class DocumentController extends Controller
{

    /**
     * Constructor to inject the service.
     */
    public function __construct(protected DocumentService $documentService)
    {
    }

    /**
     * Upload a document.
     * @bodyParam document file required PDF document.
     *
     * @param DocumentUploadRequest $request
     * @return JsonResponse
     */
    public function upload(DocumentUploadRequest $request): JsonResponse
    {
        // Use the service to upload the document
        $document = $this->documentService->uploadDocument($request->file('document'));

        // Respond with the file info
        return response()->json([
            'message' => 'Document uploaded successfully',
            'document' => $document,
        ], 201);
    }


    /**
     * Sign Document a document.
     * @bodyParam document_id string required document id .
     * @bodyParam receiver_id string required receiver id .
     * @bodyParam signature file required image.
     * @bodyParam positionX number  position X.
     * @bodyParam positionY number  position Y.
     * @bodyParam positionW number  position W.
     * @param SignDocumentRequest $request
     * @return JsonResponse
     */
    public function signDocument(SignDocumentRequest $request): JsonResponse
    {
        // Delegate the document signing to the DocumentService
        $signedDocumentPath = $this->documentService->signDocument($request);

        return response()->json(['message' => 'Document signed successfully', 'signed_document_path' => $signedDocumentPath]);
    }
}
