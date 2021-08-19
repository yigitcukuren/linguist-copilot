<?php

namespace Yigit\Utils;

class File
{
    /**
     * Gets extension of given file
     *
     * @param string $path
     * @return string
     */
    public static function getExtension(string $path): string
    {
        $explodedName = explode('.', $path);
        return end($explodedName);
    }
}
