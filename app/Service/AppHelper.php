<?php 

namespace App\Service;

class AppHelper {

    /**
     * This function handles deleting existing file
     * 
     * @param String $file_path
     * @return void
     */
    public function removeExistingFile($file_path) {
        if (checkFile($file_path))
            unlink(public_path($file_path));
    }
}