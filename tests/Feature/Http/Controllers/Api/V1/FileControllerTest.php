<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Http\Middleware\Authenticate;
use App\Models\File;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class FileControllerTest.
 *
 * @covers \App\Http\Controllers\Api\V1\FileController
 */
class FileControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(Authenticate::class);
    }

    public function test_store(): void
    {
        Storage::fake();
        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->postJson(route('file.upload'), [
            'file' => $file,
        ]);
        Storage::assertExists('pet-shop/'.$file->hashName());
        $response->assertStatus(201);
    }

    public function test_store_validation(): void
    {
        Storage::fake();
        $file = UploadedFile::fake()->image('avatar.pdf');

        $response = $this->postJson(route('file.upload'), [
            'file'=>null,
        ]);

        Storage::assertMissing('pet-shop/'.$file->hashName());
        $response->assertStatus(422)
            ->assertJsonValidationErrors('file');

        $response = $this->postJson(route('file.upload'), [
            'file'=>$file,
        ]);

        Storage::assertMissing('pet-shop/'.$file->hashName());
        $response->assertStatus(422)
            ->assertJsonValidationErrors('file');
    }

    public function test_show(): void
    {
        $file = File::factory()->create();
        $path = UploadedFile::fake()->image('avatar.png')->storeAs('pet-shop', basename($file->path));
        $this->getJson(route('file.show', ['file' => $file->uuid]))
            ->assertStatus(200);
    }

    public function test_show_not_found(): void
    {
        $this->getJson(route('file.show', ['file' => 'test']))
            ->assertStatus(200);
    }
}
