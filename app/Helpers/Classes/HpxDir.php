<?php
namespace App\Helpers\Classes;
/**
 * Delete dir and its all files
 */
class HpxDir
{
	public static function delete($dirPath) {
	    if (! is_dir($dirPath)) {
	        return false;
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}

	public static function make($dir_names=[]){
        $retn = false;
        $path = '';
        $i = 1;
        foreach($dir_names as $dir_path){
            $path .= $i == 1 ? $dir_path : '/'.$dir_path;
            $i++; 
            if(empty($dir_path)){  $path = 'dir_name_error'; break; }
            if(is_dir(base_path($path)) == false){
                mkdir(base_path($path));
            }
        }
        if(is_dir($path)){ $retn = $path; }
        return $retn;
    }
}

?>