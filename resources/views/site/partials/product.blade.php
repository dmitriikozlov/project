<div class="product-wrap">
	<div class="product type_{{ $product->mark }}">
		<div class="image" style="background-image: url('/uploads/products/thumb_{{ $product->image }}');">
			@if($product->mark)
				<div class="mark">
					<i class="{{ config('marks')[$product->mark]['icon'] }}"></i>
					<div class="title">{{ config("marks")[$product->mark]['title'] }}</div>
				</div>
			@endif
			<a href="{{ url('catalog/'.$product->catUrl.'/'.$product->url) }}"></a>
		</div>
		<div class="quantity">
			<p>Вес:<span> {{ round($product->weight) }} г</span></p>
			<p>Количество:<span> {{ $product->amount }} шт.</span></p>
		</div>
		<div class="name">
                <span class="s-name">
                        {{ mb_substr($product->name,0,15).(mb_strlen($product->name)>15?'...':'') }}
                </span>
				<?php echo mb_strlen($product->name)>15?'<span class="f-name">'.$product->name.'</span>':'' ?>
                <div class="price">
	                {{ round($product->price) }}.<sup>{{ substr(sprintf("%.2f", $product->price - round($product->price)), 2) }}</sup>
                </div>
			<a href="{{ url('catalog/'.$product->catUrl.'/'.$product->url) }}"></a>
		</div>
		<div class="consist">
			<span>Состав:</span>
			<?php
				$pi = \App\Models\ProductIngredient::where('product_id', $product->id)->pluck('ingredient_id')->toArray();
				$in = \App\Models\Ingredient::whereIn('id', $pi)->distinct()->pluck('name')->toArray();
                $cons = '';
                foreach($in as $i){
                    $cons .= $i.', ';
                }
                echo mb_substr(mb_substr($cons,0,80),0,-2) . ( mb_strlen($cons)>80 ? '...' : '.');
			?>
		</div>
		<div class="buy" data-id="product-order">
			<input data-id="product-id" type="hidden" value="{{ $product->id }}">
			<a href="javascript:void(0)" class="btn-{{ $product->mark }}">В тарелку</a>
		</div>
	</div>
</div>