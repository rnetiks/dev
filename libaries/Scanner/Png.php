<?php
final class PNGBombScanner{

    static function isPng($file): bool{
        if(file_exists($file)){
            $stream = fopen($file, "rb");
            return fread($stream, 4) === chr(0x89) . 'PNG';
        }
        return false;
    }

    static function Validate($file): bool{
        if(!file_exists($file)){
            return false;
        }

        if(!PNGBombScanner::isPng($file)){
            return false;
        }

        $stream = fopen($file, "rb");
        fseek($stream, 12);
        $idr = fread($stream, 4);

        if($idr !== 'IHDR'){
            return false;
        }

        $w = unpack('N', fread($stream, 4));
        $h = unpack('N', fread($stream, 4));

        if($w > 10000 || $h > 10000){
            return false;
        }

        return true;
    }

}