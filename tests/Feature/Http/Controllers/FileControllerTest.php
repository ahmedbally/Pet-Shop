<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\FileController;
use App\Http\Middleware\Authenticate;
use App\Models\File;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class FileControllerTest.
 *
 * @covers \App\Http\Controllers\FileController
 */
class FileControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var FileController
     */
    protected $fileController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(Authenticate::class);
        $this->fileController = new FileController();
        $this->app->instance(FileController::class, $this->fileController);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->fileController);
    }

    public function test_store(): void
    {
        Storage::fake();
        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->postJson(route('file.upload'), [
            'file'=>$file
        ]);

        Storage::assertExists('pet-shop/'.$file->hashName());
        $response->assertStatus(201);
    }

    public function test_store_validation(): void
    {
        Storage::fake();
        $file = UploadedFile::fake()->image('avatar.pdf');

        $response = $this->postJson(route('file.upload'), [
            'file'=>null
        ]);

        Storage::assertMissing('pet-shop/'.$file->hashName());
        $response->assertStatus(422);

        $response = $this->postJson(route('file.upload'), [
            'file'=>$file
        ]);

        Storage::assertMissing('pet-shop/'.$file->hashName());
        $response->assertStatus(422);
    }

    public function test_show(): void
    {
        $file = File::factory()->create();
        $this->getJson(route('file.show',['file' => $file->uuid]))
            ->assertStatus(200);
    }

    public function test_show_not_found(): void
    {
        $this->getJson(route('file.show',['file' => 'test']))
            ->assertStatus(404);
    }
}
