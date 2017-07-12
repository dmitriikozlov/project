<?php

namespace App\Modules;

class Price {

    public static function getPrice($value) {
        $array = preg_split('/\./s', $value);
        $array = array_map('intval', $array);
        if(!isset($array[1])) {
            $array[1] = 0;
        }
        if($array[1] <= 9)
            $array[1] = $array[1] . '0';
        $result = new \stdClass();
        $result->left = $array[0];
        $result->right = $array[1];
        $result->origin = $value;

        return $result;
    }

}

?>