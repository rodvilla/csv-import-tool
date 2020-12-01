<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ApplicationTest extends TestCase
{
    /**
     * @test
     */
    public function it_renders_the_app()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function it_rejects_incorrect_file_format()
    {
        $this->post('/api/process-file', [
            'file' => UploadedFile::fake()->image('photo.jpg')
        ])->assertSessionHasErrors('file');
    }

    /**
     * @test
     */
    public function it_accepts_correct_file_format()
    {
        $this->post('/api/process-file', [
            'file' => UploadedFile::fake()->create('test.csv', 128, 'text/csv')
        ])->assertSessionDoesntHaveErrors('file');
    }

    /**
     * @test
     */
    public function it_rejects_empty_csv_file()
    {
        $this->post('/api/process-file', [
            'file' => UploadedFile::fake()->createWithContent('test.csv', '')
        ])->assertJson([
            'valid' => false,
        ]);
    }

    /**
     * @test
     */
    public function it_reads_csv_file_correctly()
    {
        $file = UploadedFile::fake()->createWithContent(
            'test.csv',
            'First Name,Telephone,Email,Phone ID
            Rodrigo,555-12345-665,rodrigo@gmail.com,1'
        );

        $this->post('/api/process-file', [
            'file' => $file
        ])->assertJson([
            'valid' => true,
            'headers' => ['First Name', 'Telephone', 'Email', 'Phone ID'],
            'count' => 1,
        ]);
    }

    /**
     * @test
     */
    public function it_saves_the_csv_correctly()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->createWithContent(
            'test.csv',
            'First Name,Telephone,Email,Phone ID
            Rodrigo,555-12345-665,rodrigo@gmail.com,1'
        );

        $response = $this->json('POST', '/api/process-file', [
            'file' => $file
        ]);

        Storage::assertExists($response['path']);
    }
}
