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

    /**
     * This function handles uploading a file
     * 
     * @param Object $file
     * @param String $file_path
     * @return String
     */
    public function handleFileUpload($file, $file_path) {
        $newFileName  = uniqid()."-".uniqid();
        $extension    = $file->getClientOriginalExtension();
        $newLogoName  = $newFileName.'.'.$extension;
        $path         = $file->storeAs($file_path, $newLogoName);

        return $newLogoName;
    }
}