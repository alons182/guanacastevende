<div class="search">
    {!! Form::open(['route' => 'products_search','method' => 'get','class'=>'form-search']) !!}

    <button type="submit" class="search__button">Buscar</button>

    {!! Form::text('q',isset($q) ? $q : null ,['class'=>'search__input form-control','placeholder'=>'Buscar'])!!}

    {!! Form::close() !!}


</div>