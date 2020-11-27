<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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

    }

    /**
     * @test
     */
    public function it_rejects_empty_csv_file()
    {

    }

    /**
     * @test
     */
    public function it_reads_csv_file_correctly()
    {

    }

    /**
     * @test
     */
    public function it_checks_csv_file_is_not_empty()
    {

    }
}
