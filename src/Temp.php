<?php

declare(strict_types=1);

namespace Keboola\Temp;

use Symfony\Component\Filesystem\Filesystem;

class Temp
{
    /**
     * @var String
     */
    private $prefix;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $tmpFolder;

    public function __construct(string $prefix = '')
    {
        $this->prefix = $prefix;
        $this->id = uniqid("run-", true);
        $this->fileSystem = new Filesystem();
    }

    private function initRunFolder(): void
    {
        clearstatcache();
        $path = $this->getTmpPath();
        if (!file_exists($path) && !is_dir($path)) {
            $this->fileSystem->mkdir($path, 0777);
        }
        $this->tmpFolder = $path;
    }

    /**
     * Get path to the temporary folder.
     *
     * @return string
     */
    private function getTmpPath(): string
    {
        $tmpDir = sys_get_temp_dir();
        if (!empty($this->prefix)) {
            $tmpDir .= "/" . $this->prefix;
        }
        $tmpDir .= "/" . $this->id;
        return $tmpDir;
    }

    /**
     * Returns path to the temporary folder.
     *
     * @return string
     */
    public function getTmpFolder(): string
    {
        if (!$this->tmpFolder) {
            $this->initRunFolder();
        }
        return $this->tmpFolder;
    }

    /**
     * Create a randomly named temporary file.
     *
     * @param string $suffix filename suffix
     * @throws \Exception
     * @return \SplFileInfo
     */
    public function createTmpFile(string $suffix = ''): \SplFileInfo
    {
        $file = uniqid();
        if ($suffix) {
            $file .= '-' . $suffix;
        }
        return $this->createFile($file);
    }

    /**
     * Creates a named temporary file.
     *
     * @param string $fileName
     * @return \SplFileInfo
     * @throws \Exception
     */
    public function createFile(string $fileName): \SplFileInfo
    {
        $fileInfo = new \SplFileInfo($this->getTmpFolder() . '/' . $fileName);
        $pathName = $fileInfo->getPathname();
        if (!file_exists(dirname($pathName))) {
            $this->fileSystem->mkdir(dirname($pathName), 0777);
        }
        $this->fileSystem->touch($pathName);
        $this->fileSystem->chmod($pathName, 0600);
        return $fileInfo;
    }

    /**
     * Delete the whole temporary folder including all files.
     */
    public function remove(): void
    {
        $this->fileSystem->remove($this->getTmpFolder());
    }
}
