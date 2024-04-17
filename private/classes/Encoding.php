<?php

class Encoding {
    public static function encode($string) {
        return bin2hex(gzdeflate(base64_encode($string), 9));
    }

    public static function decode($string) {
        $decoded = @gzinflate(pack("H*", $string));
        if ($decoded !== false) {
            return base64_decode($decoded, true);
        }
        return "";
    }
}

?>