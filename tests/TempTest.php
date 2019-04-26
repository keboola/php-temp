<?php

declare(strict_types=1);

namespace Keboola\Temp\Tests;

use Keboola\Temp\Temp;
use PHPUnit\Framework\TestCase;

class TempTest extends TestCase
{
    public function testCreateTmpFile(): void
    {
        $temp = new Temp('test');
        $tempFolder = $temp->getTmpFolder();
        $file = $temp->createTmpFile('filename_suffix');

        self::assertFileExists($file->getPathname());
        self::assertStringContainsString($tempFolder, $file->getPathname());
        self::assertStringEndsWith('-filename_suffix', $file->getFilename());
        self::assertNotEquals('-filename_suffix', $file->getFilename());
        $dirParts = explode('/', $file->getPath());
        $tempDirName = (string) end($dirParts);
        self::assertStringStartsWith('run-', $tempDirName);
        self::assertGreaterThan(20, strlen($tempDirName));
    }

    public function testCreateFile(): void
    {
        $temp = new Temp();
        $file = $temp->createFile('test');

        self::assertInstanceOf('SplFileInfo', $file);
        self::assertEquals($temp->getTmpFolder() . '/' . $file->getFilename(), $file->getPathname());
        self::assertEquals('0777', substr(sprintf('%o', $file->getPerms()), -4));
    }

    public function testCreateFileNested(): void
    {
        $temp = new Temp();
        $temp->createFile('dir/file');

        self::assertFileExists($temp->getTmpFolder() . '/dir/file');
    }

    public function testGetTmpFolder(): void
    {
        $temp = new Temp('test');
        $tempFolder = $temp->getTmpFolder();

        self::assertNotEmpty($tempFolder);
        self::assertStringContainsString(sys_get_temp_dir() . '/test', $temp->getTmpFolder());
    }

    public function testCleanup(): void
    {
        $temp = new Temp();
        $temp->createFile('file');
        $temp->createFile('dir/file2');
        $dir = $temp->getTmpFolder();

        self::assertFileExists($dir . '/file');
        self::assertFileExists($dir . '/dir/file2');

        $temp->remove();
        self::assertFileNotExists($dir);
    }

    public function testCleanupForeignFile(): void
    {
        $temp = new Temp();
        $dir = $temp->getTmpFolder();

        touch($dir . '/file');
        self::assertFileExists($dir . '/file');

        $temp->remove();
        self::assertFileNotExists($dir);
    }
}
