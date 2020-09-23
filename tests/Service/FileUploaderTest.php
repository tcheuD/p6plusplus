<?php

namespace App\Tests\Service;

use App\Service\FileUploader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderTest extends TestCase
{
    public function testGetTargetDirectory(): void
    {
        $targetDirectory = '/target/directory';
        $fileUploader = new FileUploader($targetDirectory);

        self::assertSame($fileUploader->getTargetDirectory(), $targetDirectory);
    }

    public function testUploadDoesNotAllowStringTypeArg(): void
    {
        $targetDirectory = '/target/directory';
        $fileUploader = new FileUploader($targetDirectory);

        $file = $this->createMock(UploadedFile::class);
        $file->method('guessExtension')
            ->willReturn('.jpg');

        self::assertContains('.jpg', $fileUploader->upload($file));
    }
}
