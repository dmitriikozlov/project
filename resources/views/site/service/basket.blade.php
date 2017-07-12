<div class="product clearfix">
    <input name="type[{{ $product->id }}]">
    <div class="image" style="background-image:url('{{ url('/') . '/uploads/products/' . $product->image }}');"></div>
    <div class="name">
        <p>{{ $product->name }}</p>
        <div class="consist">
            <?php
            $pi = \App\Models\ProductIngredient::where('product_id', $product->id)->pluck('ingredient_id')->toArray();
            $in = \App\Models\Ingredient::whereIn('id', $pi)->distinct()->pluck('name')->toArray();
            $len = count($in);
            for($i = 0; $i < $len; $i++) {
                echo $in[$i];
                if($i == $len - 1) {
                    echo ". ";
                } else {
                    echo ", ";
                }
            }
            ?>
        </div>
    </div>
    <div class="remove">
        <a href="#" onclick="basketremove_click('{{ url('/service/basket/remove/') . '/' . $product->id }}'); return false;"></a>
    </div>
    <div class="qty">
        <div>
            <button type="button" class="minus" onclick="basketminus_click('{{ url('/service/basket/minus/') . '/' . $product->id }}')">-</button><input type="text" value="{{ $product->price_amount }}" name="qty[{{ $product->id }}]"><button type="button" class="plus" onclick="basketplus_click('{{ url('/service/basket/plus/') . '/' . $product->id }}')">+</button>
        </div>
    </div>
    <div class="price"><span>{{ $product->getSum() }}.<sup>{{ $product->getCent() }}</sup></span></div>

</div>