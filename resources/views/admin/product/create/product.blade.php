<div>
<select class="form-control" name="interesting[]" style="display: inline-block; width: 93%;">
	<option value="-1">Пусто</option>
	@foreach($products as $p)
		<option value="{{ $p->id }}">{{ $p->id }} | {{ $p->name }}</option>
	@endforeach
</select>
<button class="btn btn-danger" type="button" onclick="deleteItem(this)">X</button>
<br>
</div>