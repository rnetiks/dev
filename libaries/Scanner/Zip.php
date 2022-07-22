<?php
namespace Fox\Scanner;

use ZipArchive;

class ZipScanner{
    public static function isZip($file){
        if(!file_exists($file)){
            return false;
        }

        $stream = fopen($file, "rb");
        $magic = fread($stream, 4);
        fclose($stream);

        return $magic === "PL\3\4";
    }

    public static function Open($file){
        $zip = new ZipArchive();
        $result = $zip->open($file, ZipArchive::CREATE);

        if($result !== true){
            $errorMap = [
                ZipArchive::ER_EXISTS => 'File already exists',
                ZipArchive::ER_INCONS => 'Inconsistent',
                ZipArchive::ER_INVAL => 'Invalid argument',
                ZipArchive::ER_MEMORY => 'Malloc failure',
                ZipArchive::ER_NOENT => 'No such file',
                ZipArchive::ER_NOZIP => 'Not a zip archive',
                ZipArchive::ER_OPEN => 'Can\'t open file',
                ZipArchive::ER_READ => 'Read error',
                ZipArchive::ER_SEEK => 'Seek error'
            ];

            $errorReason = $errorMap[$result] ?? 'Unknown error';

            return $errorReason;
        }

        return $zip;
    }
}