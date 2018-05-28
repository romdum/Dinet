<?php

namespace Dinet;

class Crypt
{
    const CRYPT_KEY = '###CRYPT_KEY###';

    public static function generateKey()
    {
        $filePath = UtilPath::getMainPath( 'Crypt' );

        if( self::CRYPT_KEY === '###CRYPT_KEY###' && file_exists( $filePath ) && is_writable( $filePath ) )
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $key = '';
            for ($i = 0; $i < 32; $i++) {
                $key .= $characters[rand(0, $charactersLength - 1)];
            }
            $key = hash('sha256', $key );

            $dinetFile = file_get_contents( $filePath );
            $dinetFile = str_replace( 'const CRYPT_KEY = \'###CRYPT_KEY###\';', "const CRYPT_KEY = '$key';", $dinetFile);
            file_put_contents( $filePath, $dinetFile );
        }
    }

    public static function encrypt($string) {
        $result = '';
        for($i=0, $k= strlen($string); $i<$k; $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr(self::CRYPT_KEY, ($i % strlen(self::CRYPT_KEY))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    public static function decrypt($string) {
        $result = '';
        $string = base64_decode($string);
        for($i=0,$k=strlen($string); $i< $k ; $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr(self::CRYPT_KEY, ($i % strlen(self::CRYPT_KEY))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }
        return $result;
    }
}