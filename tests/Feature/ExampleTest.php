<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // storage
    public function testStorage()
    {
        $filesystem = Storage::disk("local");
        $filesystem->put("file.txt", "Put Your Content Here");

        self::assertEquals("Put Your Content Here", $filesystem->get('file.txt'));
    }

    // upload
    public function testUpload()
    {
        $image = UploadedFile::fake()->image("ariiq.png");
        $this->post('/file/upload', [
            'picture' => $image
        ])->assertSeeText("OK : ariiq.png");
    }
}
