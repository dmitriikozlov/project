@foreach($categories as $category)
    <div class="nav-item">
        <a href="{{ url('/category/') . '/' . $category->id }}">
            <img class="nav-image" src="{{ url('/uploads/categories/') . '/' . $category->image }}">
        </a>
    </div>
    <div class="nav-separator">
        .<br>.<br>.<br>.<br>.<br>.<br>.<br>.<br>.<br>
    </div>
@endforeach