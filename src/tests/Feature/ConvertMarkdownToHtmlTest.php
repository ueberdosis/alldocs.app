<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ConvertMarkdownToHtmlTest extends TestCase
{
    /** @test */
    public function convert_markdown_to_html()
    {
        $file = UploadedFile::fake()->create('example.md');

        $response = $this->json('POST', route('convert'), [
            'file' => $file,
            'from' => 'gfm',
            'to' => 'html',
        ]);

        $response->assertJson([
            'success' => true,
        ]);

        $response->assertStatus(200);
    }
}
