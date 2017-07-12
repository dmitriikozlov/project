<div class="product clearfix">
    <input data-id="product-id-value" type="hidden" name="product[{{ $product->id }}][id]" value="{{ $product->id }}">
    <input data-id="product-count-value" type="hidden" name="product[{{ $product->id }}][count]" value="{{ $product->count }}">
    <input data-id="product-price-value" type="hidden" name="product[{{ $product->id }}][price]" value="{{ $product->price }}">
    <div class="image" style="background-image:url('{{ url('/') . '/uploads/products/' . $product->image }}');"></div>
    <div class="name">
        <p>{{ $product->name }}</p>
        <div class="consist">
            <?php
            $pi = \App\Models\ProductIngredient::where('product_id', $product->id)->pluck('ingredient_id')->toArray();
            $in = \App\Models\Ingredient::whereIn('id', $pi)->distinct()->pluck('name')->toArray();
            $len = count($in);
            for ($i = 0; $i < $len; $i++) {
                echo $in[$i];
                if ($i == $len - 1) {
                    echo ". ";
                } else {
                    echo ", ";
                }
            }
            ?>
        </div>
    </div>

    <div class="remove">
        <a data-id="product-remove" href="javascript:void(0)"></a>
    </div>
    <div class="qty">
        <div>
            <button data-id="product-minus" type="button" class="minus">-</button>
            <input data-id="product-count" readonly="readonly" type="text" value="{{ $product->count }}">
            <button data-id="product-plus" type="button" class="plus">+</button>
        </div>
    </div>
    <div class="price">
        <span><span data-id="product-price-left">{{ \App\Modules\Price::getPrice($product->price)->left }}</span>.<sup data-id="product-price-right">{{ \App\Modules\Price::getPrice($product->price)->right }}</sup></span>
    </div>
</div>