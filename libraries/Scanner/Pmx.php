<?php
    final class PMXScanner{
        public static function isPmx($file){
            if(!file_exists($file)){
                return false;
            }

            $stream = fopen($file, "rb");
            $magic = fread($stream, 4);
            fclose($stream);
            return $magic === "PMX" . chr(0x20);
        }

        public static function Version($file){
            if(!file_exists($file)) return -1;
            $stream = fopen($file, "rb");
            $version = unpack('f', fread($stream, 4));
            fclose($stream);
            
            return $version;
        }
    }