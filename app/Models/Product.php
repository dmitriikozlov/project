<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getMark()
    {
        foreach(ProductMark::all() as $pm)
        {
            foreach(Mark::all() as $m)
            {
                if($pm->product_id == $this->id && $pm->mark_id == $m->id)
                {
                    return $m;
                }
            }
        }
        return Mark::all()[0];
    }

    public function getPrice()
    {
        return round($this->getSum());
    }
    
    public function getCent()
    {
        $cent = $this->getSum() - round($this->getSum());
        if($cent == 0)
            return '00';
        if($cent < 9)
            return '0' . $cent;
        return $cent;
    }
    
    public function getSum()
    {
        return $this->price_amount * $this->price;
    }
	
	public function getIngredients() {
		return [];
	}
}
