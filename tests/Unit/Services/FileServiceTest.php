<?php

namespace Tests\Unit\Services;

use App\Services\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileServiceTest extends TestCase
{

    protected FileServiceContract $fileService;
    const FILE_NAME = 'image.png';
    public function setUp(): void
    {
        // to initiate the parent method
        parent::setUp();

        $this->fileService = app(FileServiceContract::class);
        Storage::fake('public');
    }

    // all test methods should be public
    public function test_success_with_the_valid_file()
    {
        $uploadedFile = $this->uploadedFile();
        $this->assertTrue(Storage::has($uploadedFile));
        // test of correct visibility
        $this->assertEquals(Storage::getVisibility($uploadedFile), 'public');
    }

    public function test_it_returns_the_same_path_for_string_file()
    {
        $fileName = 'test/image.png';
        $uploadedFile = $this->fileService->upload($fileName);
        $this->assertEquals($uploadedFile, $fileName);
    }

    public function test_it_returns_path_without_storage_name()
    {
        $fileName = 'public/storage/test/image.png';
        $uploadedFile = $this->fileService->upload($fileName);
        $this->assertEquals($uploadedFile, '/test/image.png');
    }
    //acceptable to have such a long name of method
    public function test_success_with_the_valid_file_and_additional_path()
    {
        $folder = 'test';

        $this->assertFalse(Storage::directoryExists($folder));

        $uploadedFile = $this->uploadedFile(additionalPath: $folder);

        $this->assertTrue(Storage::directoryExists($folder));
        $this->assertTrue(Storage::has($uploadedFile));
        // test of correct visibility
        $this->assertEquals(Storage::getVisibility($uploadedFile), 'public');
    }

    public function test_remove_file()
    {
        $uploadedFile = $this->uploadedFile();
        $this->assertTrue(Storage::has($uploadedFile));

        $this->fileService->remove($uploadedFile);
        $this->assertFalse(Storage::has($uploadedFile));
    }
    protected function uploadedFile(string $fileName = null, string $additionalPath = ''): string
    {
        $file = UploadedFile::fake()->image($fileName ?? self::FILE_NAME);
        return $this->fileService->upload($file, $additionalPath);
    }
}
