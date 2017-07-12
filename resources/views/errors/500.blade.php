@extends('site.layout.index')

@section('content')
	<style>
		.background_error {
			background-image: url("<?= asset('images/background-error.jpg') ?>");
			background-size: cover;
			height: 600px;
		}
	
		.content_error {
			display: block;
			width: 1200px;
			margin: 0 auto;
		}
		
		.content_error div {
			display: inline-block;
		}
		
		.logo {
			width: 500px;
		}
		
		.logo img {
			position: relative;
			
			width: 350px;
			height: 350px;
			
			top: 100px;
			left: 100px;
			
			transform: rotateZ(93deg);
		}
		
		.content {
			font-family: "Roboto", sans-serif;
			font-size: 24px;
			line-height: 150%;
			width: 600px;
			color: white;
		}
		.content a {
			color: #ff9c00;
		}
	</style>
	<script>

	</script>
	<div class="background_error">
		<div class="content_error">
			<div class="logo">
				<img src="<?= asset('images/404.png') ?>">
			</div>
			<div class="content">
				Вы попали на несуществующую страницу сайта. Воспользуйтесь главным меню сайта, 
				чтобы попасть на интересующую вас страницу или перейдите на 
				<a href="<?= url('/') ?>">главную страницу.</a>
			</div>
		</div>
	</div>
@endsection