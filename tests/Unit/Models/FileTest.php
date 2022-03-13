<?php

namespace Tests\Unit\Models;

use App\Models\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Class FileTest.
 *
 * @covers \App\Models\File
 */
class FileTest extends TestCase
{
    /**
     * @var File
     */
    protected $file;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->file = new File();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->file);
    }

    public function test_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('files', [
                'id',
                'uuid',
                'name',
                'path',
                'size',
                'type',
                'created_at',
                'updated_at',
            ]));
    }

    public function test_set_size_attribute(): void
    {
        $this->file->size = 1024;
        $this->assertEquals("1.00 KB", $this->file->size);

        $this->file->size = 2048;
        $this->assertEquals("2.00 KB", $this->file->size);

        $this->file->size = 1024 * 1024;
        $this->assertEquals("1.00 MB", $this->file->size);

        $this->file->size = 1024 * 1024 * 1024;
        $this->assertEquals("1.00 GB", $this->file->size);

        $this->file->size = 1024 * 1024 * 1024 * 25;
        $this->assertEquals("25.00 GB", $this->file->size);

        $this->file->size = 1024 * 1024 * 1024 * 1024;
        $this->assertEquals("1.00 TB", $this->file->size);

        $this->file->size = 1024 * 1024 * 1024 * 1024 * 1024;
        $this->assertEquals("1.00 PB", $this->file->size);

        $this->file->size = 1024 * 1024 * 1024 * 1024 * 1024 * 1024;
        $this->assertEquals("1.00 EB", $this->file->size);

        $this->file->size = 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024;
        $this->assertEquals("1.00 ZB", $this->file->size);

        $this->file->size = 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024;
        $this->assertEquals("1.00 YB", $this->file->size);
    }
}
