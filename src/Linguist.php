<?php

namespace Yigit;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Yigit\Exception\PathNotFoundException;
use Yigit\Utils\File;

class Linguist
{
    /**
     * Path to find dominant language
     *
     * @var string
     */
    public string $path;

    /**
     * Extensions map
     *
     * @var array
     */
    public array $extensions = [];

    /**
     * Exclude
     *
     * @var array
     */
    public array $excludedWords = [];

    /**
     * Constructor
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->checkPathExists($path);
    }

    /**
     * Check given path is exists
     *
     * @param string $path
     * @throws PathNotFoundException
     * @return void
     */
    public function checkPathExists(string $path): void
    {
        if (!file_exists($path)) {
            throw new PathNotFoundException('Given path is invalid!');
        }
        $this->path = $path;
    }

    /**
     * Set excluded words
     *
     * @param array $words
     * @return void
     */
    public function excludeContains(array $words)
    {
        $this->excludedWords = $words;
    }

    /**
     * Check given path has excluded words
     *
     * @param string $path
     * @return boolean
     */
    public function checkIsExcluded(string $path): bool
    {
        $isContain = false;
        foreach ($this->excludedWords as $word) {
            if (strpos($path, $word) !== false) {
                $isContain = true;
                break;
            }
        }

        return $isContain;
    }

    /**
     * Returns extensions
     *
     * @return array
     */
    public function find(): array
    {

        $recursiveDirectoryIterator = new RecursiveDirectoryIterator($this->path);
        $recursiveIteratorIterator = new RecursiveIteratorIterator($recursiveDirectoryIterator);

        foreach ($recursiveIteratorIterator as $info) {
            if (
                $info->isFile()
                && !$this->checkIsExcluded($info->getPathName())
                && strpos($info->getPathName(), '.') !== false
            ) {
                $extension = File::getExtension($info->getPathName());
                if (!isset($this->extensions[$extension])) {
                    $this->extensions[$extension] = 1;
                } else {
                    $this->extensions[$extension]++;
                }
            }
        }

        return $this->extensions;
    }
}
