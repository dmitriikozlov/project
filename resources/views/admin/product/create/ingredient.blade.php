<div>
	<select class="form-control" name="ingredient[]" style="display: inline-block; width: 93%;">
		<option value="-1">Пусто</option>
		@foreach($ingredients as $i)
			<option value="{{ $i->id }}">{{ $i->id }} | {{ $i->name }}</option>
		@endforeach
	</select>
	<button class="btn btn-danger" type="button" onclick="deleteItem(this)">X</button>
	<br>
</div>