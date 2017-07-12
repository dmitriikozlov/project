<select name="size[]">
    @foreach($sizes as $size)
        <option value="{{ $size->id }}">
            <table>
                <tr>
                    <th>Код</th>
                    <td>{{ $size->id }}</td>
                </tr>
                <tr>
                    <th>Название</th>
                    <td>{{ $size->name }}</td>
                </tr>
                <tr>
                    <th>Вес</th>
                    <td>{{ $size->weight }}</td>
                </tr>
                <tr>
                    <th>Цена</th>
                    <td>{{$size->price }}</td>
                </tr>
            </table>
        </option>
    @endforeach
</select>
