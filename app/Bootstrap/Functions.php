<?php

/**
 * Checks if a file exist.
 * @param string $file
 * @return bool
 */
function checkFile($file='') : bool
{
    $file       = "/".ltrim($file, "/");
    $filePath   = public_path($file);
    return (!empty($filePath) && is_file($filePath) && file_exists($filePath)) ? TRUE : FALSE;
}