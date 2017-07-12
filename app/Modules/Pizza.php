<?php

namespace App\Modules;

use DB;
use Session;

class Pizza {

    public static function getPizza() {
        $pizza = DB::select("
            SELECT * 
            FROM `pizza`
            WHERE `id` = 1
        ");

        if($pizza)
            $pizza = $pizza[0];
        else
            throw new \Exception(__FILE__ . '\n' . __LINE__, 500);

        $result = [];

        $items = Session::get('pizza');
        if(!$items)
            $items = [];
        foreach($items as $item) {
            $value = clone $pizza;

            $value->count = $item['count'];
            $value->order_id = $item['order_id'];
            $value->order_timestamp = $item['order_timestamp'];

            $value->size = static::getSize($item);
            $value->ingredients = static::getIngredients($item);
            $value->price = $value->size->price;
            $value->weight = $value->size->weight;

            foreach($value->ingredients as $i) {
                $value->price += $i->price * $i->count;
                $value->weight += $i->weight * $i->count;
            }

            $result[] = $value;
        }

        return $result;
    }

    private static function getSize($item) {
        $size = DB::select("
            SELECT *
            FROM `pizza_sizes` 
            WHERE `id` = {$item['size']}
        ");

        if($size)
            $size = $size[0];
        else
            throw new \Exception(__FILE__ . '\n' . __LINE__, 500);

        return $size;
    }

    private static function getIngredients($item) {
        $ingredients = DB::select("
            SELECT * 
            FROM `pizza_ingredients`
            WHERE `published` = 1
        ");
        $result = [];
        foreach($item['ingredients'] as $value) {
            foreach($ingredients as $ing) {
                if($ing->id == $value['id']) {
                    $ing->count = $value['count'];
                    $result[] = $ing;
                }
            }
        }

        return $result;
    }
}

?>