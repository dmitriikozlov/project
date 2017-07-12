<?php $productMarks = config('productMarks') ?>
@foreach($products as $product)
    @include('site.partials.product')
@endforeach