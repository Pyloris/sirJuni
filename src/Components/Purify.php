<?php
namespace sirJuni\Framework\Components;



// This component contains static methods
// which purify:sanitize text before rendering it in html
class Purify  {

    // sanitize basic text and escape any html tags it might contain.
    public static function html($data) {
        // escape the html tags <>
        $data = htmlentities($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }


    // sanitize urls for any dangerous characters.
    public static function link($data) {
        // urlencode any special characters in the link
        // url should be along with scheme
        // replace all unsafe characters with urlencoded versions
        $unsafe = ['\'', '\s', '<', '>', '\"', '%', '\{', '\}', '\[', '\]', '\|', '\^', '~', '\`', '\*'];

        foreach ($unsafe as $target) {
            $data = preg_replace("/$target/", urlencode(ltrim($target, '\\')), $data);
        }

        return $data;
    }
    
}


?>