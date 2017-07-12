@extends('site.layout.index')

@section('meta')
	<?php 
		$meta = null;
		if($page) 
			if($page->meta_id != null)
				$meta = \App\Models\Meta::find($page->meta_id);
	?>
	@if($meta != null)
		<title>{{ $meta->title != null ? $meta->title : '' }}</title>
		<meta name="description" content="{{ $meta->title != null ? $meta->description : '' }}" >
		<meta name="keywords" content="{{ $meta->title != null ? $meta->keywords : '' }}" >
		<meta name="robots" content="{{ $meta->title != null ? $meta->robots : '' }}" >
	@endif
@stop

@section('content')
    <section id="static_page">
	<div class="wrap">
            <h1 class="page-title">
					{{ $page->title }}
            </h1>
            {!! $page->content !!}
	</div>
    </section>
@stop