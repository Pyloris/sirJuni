<?php
namespace sirJuni\Framework\View;


class VIEW {
    public static function init($page, $data=NULL) {
        if ($data != NULL)
            extract($data);
        include __DIR__ . "\\..\\templates\\$page";
    }
}

?>