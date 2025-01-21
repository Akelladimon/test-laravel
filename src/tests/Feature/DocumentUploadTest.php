<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentUploadTest extends TestCase
{
    /**
     * Test the document upload API endpoint.
     */
    public function test_document_upload()
    {
        // Fake the local storage
        Storage::fake('local');

        // Create a fake PDF file
        $file = UploadedFile::fake()->create('example.pdf', 500, 'application/pdf');

        // Send a POST request to the upload endpoint
        $response = $this->postJson('/api/documents/upload', [
            'document' => $file,
        ]);

        // Assert the response is successful
        $response->assertStatus(201);

        // Assert the file is stored in the correct location
        Storage::disk('local')->assertExists('documents/' . $file->hashName());
    }

    /**
     * Test validation errors for invalid file upload.
     */
    public function test_invalid_document_upload()
    {
        // Send a POST request with an invalid file type
        $response = $this->postJson('/api/documents/upload', [
            'document' => UploadedFile::fake()->create('example.txt', 500, 'text/plain'),
        ]);

        // Assert validation error
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['document']);
    }
}
