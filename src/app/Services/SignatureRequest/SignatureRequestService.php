<?php

namespace App\Services\SignatureRequest;

use App\Models\SignatureRequest;
use Illuminate\Support\Facades\Auth;

class SignatureRequestService
{
    /**
     * Send a signature request.
     *
     * @param  int  $receiverId
     * @param  int  $documentId
     * @return \App\Models\SignatureRequest
     */
    public function sendSignatureRequest(int $receiverId, int $documentId)
    {
        return SignatureRequest::create([
            SignatureRequest::COLUMN_SENDER_ID => Auth::id(),
            SignatureRequest::COLUMN_RECEIVER_ID => $receiverId,
            SignatureRequest::COLUMN_DOCUMENT_ID => $documentId,
            SignatureRequest::COLUMN_STATUS => SignatureRequest::STATUS_PENDING,
        ]);
    }

    /**
     * Update the status of a signature request.
     *
     * @param  \App\Models\SignatureRequest  $signatureRequest
     * @param  string  $status
     * @return \App\Models\SignatureRequest
     */
    public function updateSignatureRequestStatus(SignatureRequest $signatureRequest, string $status)
    {
        $signatureRequest->update([
            SignatureRequest::COLUMN_STATUS => $status,
            SignatureRequest::COLUMN_SIGNED_AT => $status === SignatureRequest::STATUS_SIGNED ? now() : null,
        ]);

        return $signatureRequest;
    }
}
