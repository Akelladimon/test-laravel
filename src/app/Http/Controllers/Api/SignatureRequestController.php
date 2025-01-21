<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Signature\SignatureRequestStoreRequest;
use App\Http\Requests\Signature\SignatureRequestUpdateStatusRequest;
use App\Models\SignatureRequest;
use App\Services\SignatureRequest\SignatureRequestService;
use Illuminate\Http\JsonResponse;

/**
 * @group Signature Request management
 * @authenticated
 * APIs for Signature Request
 */
class SignatureRequestController extends Controller
{


    public function __construct(protected SignatureRequestService $signatureRequestService)
    {
    }

    /**
     * @authenticated
     * Send a signature request.
     * @param SignatureRequestStoreRequest $request
     * @return JsonResponse
     */
    public function send(SignatureRequestStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $signatureRequest = $this->signatureRequestService->sendSignatureRequest(
            $validated[SignatureRequest::RECEIVER_ID_ATTRIBUTE],
            $validated[SignatureRequest::DOCUMENT_ID_ATTRIBUTE]
        );

        return response()->json([
            'message' => 'Signature request sent successfully.',
            'data' => $signatureRequest,
        ], 201);
    }

    /**
     * @authenticated
     * List all signature requests for the logged-in user.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $requests = SignatureRequest::where(SignatureRequest::RECEIVER_ID_ATTRIBUTE, auth()->id())
            ->with(['sender', 'document'])
            ->get();

        return response()->json($requests);
    }

    /**
     * @authenticated
     * Update the status of a signature request.
     * @param SignatureRequestUpdateStatusRequest $request
     * @param SignatureRequest $signatureRequest
     *
     * @return JsonResponse
     */
    public function updateStatus(SignatureRequestUpdateStatusRequest $request,
                                 SignatureRequest $signatureRequest): JsonResponse
    {
        $validated = $request->validated();

        // Check if the current user is authorized to update the status
        if ($signatureRequest->{SignatureRequest::RECEIVER_ID_ATTRIBUTE} !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $signatureRequest = $this->signatureRequestService->updateSignatureRequestStatus(
            $signatureRequest,
            $validated['status']
        );

        return response()->json([
            'message' => 'Signature request status updated successfully.',
            'data' => $signatureRequest,
        ]);
    }
}
