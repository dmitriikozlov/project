@extends('site.layout.index')

@section('meta')
	<?php
			$meta = DB::select("
				SELECT *
				FROM `metas`
				WHERE `id` = 666
			")[0];
	?>
	<title>{{ $meta->title }}</title>
	<meta name="description" content="{{ $meta->description }}">
	<meta name="keywords" content="{{ $meta->keywords }}">
	<meta name="robots" content="{{ $meta->robots }}">
@stop

@section('content')

	@if(count($products) > 0)
	<section class="hot-offers">
		<div class="wrap">
            <style>
                .page-title{
                    position: relative;
                    margin-bottom: 30px;
                    line-height: 1;
                    color: #faf655;
                    font-size: 26px;
                    text-transform: uppercase;

            </style>
			<div class="page-title text-center">Предложение дня</div>

			<div class="product-list clearfix" id="else">
				<?php $productMarks = config('marks'); ?>
				@for($p=0;$p<3;$p++)
                    @include('site.partials.product',['product'=>$products[$p]])
				@endfor
			</div>

			@if(count($products) > 3)
			<div class="load-all" id='else_separator'>
				<a href="#" onclick="return else_onclick('{{ url('service/else') }}')">Ещё</a>
			</div>
			@endif
		</div>
	</section>
	@endif

	<section id="bottom">
	    <div class="wrap clearfix">
            <div class="bnr">
                @if($page->image)
                    <img src="{{ asset('uploads/pages/'.$page->image) }}">
                @endif
            </div>
	        <div class="seo-text">
	                <h2>{{ $page->title }}</h2>
                    {!! $page->content !!}
	        </div>
	    </div>
	</section>
@endsection