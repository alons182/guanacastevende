<div class="product__edit__left">
    <section class="panel">
        <header class="panel-heading">
            <h1 class="product__edit__left__title">Editando Producto</h1>
        </header>
        <div class="form">
            <div class="form__group">
                {!! Form::submit(isset($buttonText) ? $buttonText : 'Agregar Producto',['class'=>'btn btn-primary'])!!}
                {!! link_to_route('profile.show',  'Regresar', (isset($product)) ? $product->user->username : Auth::user()->username, ['class'=>'btn btn-default'])!!}
            </div>
            <div class="form__group">
                {!! Form::label('name','Nombre:',['class'=>'col-sm-2 control-label']) !!}

                    {!! Form::text('name', null,['class'=>'form__control','required'=>'required']) !!}
                    {!! errors_for('name',$errors) !!}

            </div>
               {!! Form::hidden('slug', null,['class'=>'form__control', 'readonly']) !!}

            <div class="form__group">
                {!! Form::label('categories','Categorias:',['class'=>'col-sm-2 control-label'])!!}
                {!! Form::select('categories[]', ['' => ''] + $categories_list, isset($selected_categories) ? $selected_categories : null , ['id'=>'categories','class'=>'form__control','required'=>'required']) !!}
                {!! errors_for('categories',$errors) !!}

            </div>
                <!--<div class="form__group">
                    {!! Form::label('tags','Etiquetas:',['class'=>'col-sm-2 control-label'])!!}

                        {!! Form::select('tags[]', $tags_list, isset($selected_tags) ? $selected_tags : null , ['multiple' => 'multiple','id'=>'tags','class'=>'form__control']) !!}
                        {!! errors_for('tags',$errors) !!}

                </div>-->


            <div class="form__group">
                {!! Form::label('description','Descripción:',['class'=>'col-sm-2 control-label'])!!}

                    {!! Form::textarea('description',null,['class'=>'form__control','id'=>'ckeditor','required'=>'required']) !!}
                    {!! errors_for('description',$errors) !!}


            </div>
            <div class="form__group">
                {!! Form::label('price','Precio:', ['class'=>'col-sm-2 control-label'])!!}

                    <div class="input__group input__group--left">
                        <span class="input__group__icon">&cent;</span>
                        {!! Form::text('price',isset($product) ? money($product->price, false) : null,['class'=>'form__control','required'=>'required'])!!}
                        {!! errors_for('price',$errors) !!}

                    </div>

            </div>
            <div class="form__group">
                {!! Form::label('option','Opciones:',['class'=>'col-sm-2 control-label'])!!}
                @foreach($options_list as $option)
                    <input type="checkbox" value="{!! $option->id !!}" name="option_id" {!! (isset($product)) ? ($product->option_id == $option->id) ? 'checked="checked"' : '' : '' !!}> <b>{!! $option->name !!}</b> <br />
                    <div class="option__description">
                        {!! $option->description !!}
                    </div>
                @endforeach

            </div>
            <div class="form__group">
                {!! Form::label('tags','Etiquetas:',['class'=>'col-sm-2 control-label'])!!}
                @foreach($tags_list as $tag)
                    <input type="checkbox" value="{!! $tag->id !!}" name="tags[]" {!! isset($selected_tags[0]) ? ($tag->id == $selected_tags[0]) ? 'checked="checked"' : '' : '' !!}> {!! $tag->name !!} - {!! $tag->price !!} <br />
                @endforeach
            </div>

            @if(isset($product))
            <div class="form__group">
                {!! Form::label('published','Publicado:',['class'=>'col-sm-2 control-label'])!!}

                    {!! Form::select('published', ['1' => 'Yes', '0' => 'No'], null,['class'=>'form__control selectpicker','required'=>'required']) !!}
                    {!! errors_for('published',$errors) !!}


            </div>
            @endif




        </div>
    </section>

</div>
<div class="col-lg-6 product__edit__right" >

    <section class="panel">
        <header class="panel-heading">
            <h1 class="product__edit__right__title">Imagen Principal</h1>

        </header>
        <div class="form">
            <div class="form__group">
                {!! Form::label('image','Imagen:',['class'=>'col-sm-2 control-label'])!!}


                {!! Form::file('image') !!}
                {!! errors_for('image',$errors) !!}

            </div>
            @if (isset($product))
                <div class="main_image">
                    @if ($product->image)
                        <img src="{!! photos_path('products') !!}thumb_{!! $product->image !!}"
                             alt="{!! $product->image !!}">

                    @endif

                </div>
            @endif
                <div class="form__group">

                {!! Form::label('gallery','Galeria:',['class'=>'control-label'])!!}
                @if(isset($product))
                    {!! Form::hidden('product_id',  $product->id) !!}
                @endif

                    @if(isset($product))

                        <div id="container-gallery">

                            <a class="UploadButton btn btn-info" id="UploadButton">Subir Imagen</a>
                            <div id="InfoBox"></div>
                            <ul id="gallery">

                                @foreach ($product->photos as $photo)
                                    <li>
                                        <span class="delete" data-imagen="{!! $photo->id !!}" title="Eliminar imagen"><i class="icon-close"></i></span>
                                        <a href="{!! photos_path('products') !!}{!! $photo->product_id !!}/{!! $photo->url !!}"><img src="{!! photos_path('products') !!}{!! $photo->product_id !!}/{!! $photo->url_thumb !!}" alt="img" /></a>
                                    </li>
                                @endforeach

                            </ul>
                            <script id="photoTemplate" type="text/x-handlebars-template">

                                <li>
                                    <span class="delete" data-imagen="@{{ id }}" title="Eliminar imagen"><i class="icon-close"></i></span>
                                    <a href="/media/products/@{{ product_id }}/@{{ url }}" ><img src="/media/products/@{{ product_id }}/@{{ url_thumb }}" alt="img" /></a>
                                </li>


                            </script>

                        </div>
                    @else
                        <div id="inputs_photos">

                            <input class="inputbox btn btn-info" type="button" name="new_photo"  value="Nueva Foto"  id="add_input_photo"/><i class="glyphicon glyphicon-plus-sign"></i>

                        </div>

                    @endif
                </div>
        </div>
    </section>

</div>


		
		


