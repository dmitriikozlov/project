@extends('site.layout.index')

@section('content')

	<section id="search_page">
		<div class="wrap">
			<div class="search-top">
				<form id="search_form" action="{{ url('search') }}" method="post">
					{{ csrf_field() }}
					<input name="text" type="text" value="{{ old('text',$text) }}" placeholder="Что ищем?"><button id="button_search" type="submit"><i class="icon-search" onclick="ga('send', 'event', 'SEARCH', 'SEARCH'); yaCounter37864800.reachGoal('SEARCH');"></i> Найти</button>
				</form>
				<div id="search_help" class="search-help"></div>
			</div>
			<div id="search_result" class="search-result">
				@if(isset($products))
					@if(count($products))
						<div class="product-list clearfix" id="products">
							<?php $productMarks = config('marks') ?>
							@foreach($products as $product)
								@include('site.partials.product')
							@endforeach
						</div>
					@else
						<div class="no-results">По вашему запросу ничего не найдено</div>
					@endif
				@endif
			</div>
		</div>

	</section>

@stop