<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class NewCategoryController extends Controller
{
    public function category($url) {

        // CATEGORY

        $category = DB::select("
            SELECT c.*
            FROM `categories` AS c
            WHERE c.url = :category_url
        ", [
            "category_url" => $url,
        ]);
        if(!$category)
            abort(404);
        $category = $category[0];

        // PRODUCTS

        $products = DB::select("
            SELECT p.*, :catalog_url AS `catUrl`
            FROM `products` AS p
            INNER JOIN `category_products` AS cp
              ON cp.product_id = p.id
            INNER JOIN `categories` AS c
              ON cp.category_id = c.id
            WHERE c.id = :category_id
              AND p.show = 1
            ORDER BY p.name
        ", [
            "category_id" => $category->id,
            "catalog_url" => $category->url,
        ]);

        $product_ids = array_map(function($item) {
            return $item->id;
        }, $products);
        array_unique($product_ids);

        // INGREDIENTS

        $ingredients = DB::select("
            SELECT DISTINCT i.*
            FROM `ingredients` AS i
            INNER JOIN `product_ingredients` AS pi
              ON pi.ingredient_id = i.id
            INNER JOIN `products` AS p
              ON pi.product_id = p.id
            WHERE p.id IN (" . implode(',', $product_ids) . ")
            ORDER BY i.name
        ", []);

        // MARKS

        $mark_ids = array_map(function ($item) {
            return $item->mark;
        }, $products);
        $mark_ids = array_unique($mark_ids);
        $mark_ids = array_reverse($mark_ids);

        $marks = [];

        foreach($mark_ids as $id) {
            $marks[] = config('marks')[$id];
        }

        return view('site.category.index', [
            'category'    => $category,
            'products'    => $products,
            'ingredients' => $ingredients,
            'marks'       => $marks,
        ]);
    }

    public function products() {

        $this->validate(request(), [
            'category'    => 'integer',
            'select'      => 'integer',
            'ingredients' => 'array',
            'marks'       => 'array',
        ]);

        $category       = Category::findOrFail(request()->input('category', 0));
        $select         = request()->input('select', 0);
        $ingredient_ids = request()->input('ingredients', []);
        $mark_ids       = request()->input('marks', []);
        $order_column = '';
        $order_value = '';
        switch($select) {
            case '1':
                $order_column = 'p.weight';
                $order_value = 'desc';
                break;
            case '2':
                $order_column = 'p.weight';
                $order_value = 'asc';
                break;
            case '3':
                $order_column = 'p.price';
                $order_value = 'desc';
                break;
            case '4':
                $order_column = 'p.price';
                $order_value = 'asc';
                break;
            case '5':
                $order_column = 'p.visite';
                $order_value = 'asc';
                break;
            case '6':
            default:
                $order_column = 'p.visite';
                $order_value = 'desc';
                break;
        }

        if(count($ingredient_ids) == 0 && count($mark_ids) == 0) {
            $products = DB::select("
                SELECT p.*, :catalog_url AS `catUrl`
                FROM `products` AS p
                INNER JOIN `category_products` AS cp
                  ON cp.product_id = p.id
                INNER JOIN `categories` AS c
                  ON cp.category_id = c.id
                WHERE c.id = :category_id
                ORDER BY $order_column $order_value
            ", [
                "category_id" => $category->id,
                "catalog_url" => $category->url,
            ]);
        }
        else {

            $where = "";

            if($mark_ids) {
                foreach($mark_ids as $id) {
                    $where .= " AND p.mark = $id ";
                }
            }

            if($ingredient_ids) {
                $where .= " AND pi.ingredient_id IN (" . implode(',', $ingredient_ids) . ") ";
            }

            $products = DB::select("
                SELECT
                       p.*, :category_url AS `catUrl`, COUNT(pi.ingredient_id) AS `count`
                FROM `products` AS p
                INNER JOIN `product_ingredients` AS pi
                  ON pi.product_id = p.id
                INNER JOIN `ingredients` AS i
                  ON pi.ingredient_id = i.id
                INNER JOIN `category_products` AS cp
                  ON p.id = cp.product_id
                INNER JOIN `categories` AS c
                  ON c.id = cp.category_id
                WHERE c.id = :category_id
                          $where
                GROUP BY p.name
                ORDER BY $order_column $order_value
            ", [
                'category_id'  => $category->id,
                'category_url' => $category->url,
            ]);

            if($ingredient_ids) {
                $tproducts = $products;
                $products = [];
                $count = count($ingredient_ids);
                foreach($tproducts as $p) {
                    if($count == $p->count) {
                        $products[] = $p;
                    }
                }
            }
        }

        return response()->json([
            'product_view'  => view('site.category.service.products', [
                'products' => $products,
            ])->render(),
        ]);
    }
}
