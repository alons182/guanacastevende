<div class="product__edit">
    <div class="left-section">
        <section class="panel">
                <h1 class="product__edit__title">Editando Producto</h1>

            <div class="form">
                <div class="form__group">
                    {!! Form::submit(isset($buttonText) ? $buttonText : 'Agregar Producto',['class'=>'btn btn-primary'])!!}
                    {!! link_to_route('profile.show',  'Regresar', (isset($product)) ? $product->user->username : Auth::user()->username, ['class'=>'btn btn-default'])!!}
                </div>
                <div class="form__group">
                    {!! Form::label('name','Nombre de producto:',['class'=>'col-sm-2 control-label']) !!}

                        {!! Form::text('name', null,['class'=>'form__control','required'=>'required']) !!}
                        {!! errors_for('name',$errors) !!}

                </div>
                   {!! Form::hidden('slug', null,['class'=>'form__control', 'readonly']) !!}

                <div class="form__group">
                    {!! Form::label('categories','Seleccione una categoria:',['class'=>'col-sm-2 control-label'])!!}

                    <div class="select__category">
                        <select  name="parentCategories" class="rootCategories" size="5" data-container="0">

                            @foreach($categories_list as $category)
                                <option class="option-icon" value="{!! $category->id !!}">{!! $category->name !!} </option>
                            @endforeach

                        </select>
                        <div class="select__sub-category">

                        </div>
                    </div>
                    <script id="selectCategoryTemplate" type="text/x-handlebars-template">

                        <select  name="parentCategories" class="rootCategories" size="5" data-container="@{{ container }}">

                            @{{#each this}}
                                <option class="@{{#if category_children }} option-icon @{{/if}}" value="@{{ category_id }}">@{{ category_name }} </option>
                            @{{/each}}
                        </select>
                        <div class="select__sub-category">

                        </div>
                    </script>


                    {{-- Form::select('categories[]', ['' => ''] + $categories_list, isset($selected_categories) ? $selected_categories : null , ['id'=>'categories','class'=>'form__control','required'=>'required']) --}}
                    {!! errors_for('categories',$errors) !!}

                </div>

                <div class="form__group">
                    {!! Form::label('description','Descripción:',['class'=>'col-sm-2 control-label'])!!}

                        {!! Form::textarea('description',null,['class'=>'form__control','id'=>'ckeditor','required'=>'required']) !!}
                        {!! errors_for('description',$errors) !!}


                </div>
                <div class="form__group">
                    {!! Form::label('price','Precio:', ['class'=>'col-sm-2 control-label'])!!}

                        <div class="input__group input__group--left">
                            <span class="input__group__icon">&cent;</span>
                            {!! Form::text('price',isset($product) ? money($product->price, false) : null,['class'=>'form__control','required'=>'required', 'onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57'])!!}
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
                        @if($option->id == 4)
                            <div class="option__tags">
                                {!! Form::label('tags','Etiquetas:',['class'=>'col-sm-2 control-label'])!!}
                                @foreach($tags_list as $tag)
                                    <input type="checkbox" value="{!! $tag->id !!}" name="tags[]" {!! isset($selected_tags[0]) ? ($tag->id == $selected_tags[0]) ? 'checked="checked"' : '' : '' !!} disabled="disabled" > {!! $tag->name !!} - {!! $tag->price !!} <br />
                                @endforeach
                            </div>


                        @endif
                    @endforeach


                </div>

                @if(isset($product))
                <div class="form__group">
                    {!! Form::label('published','Publicado:',['class'=>'col-sm-2 control-label'])!!}

                        {!! Form::select('published', ['1' => 'Yes', '0' => 'No'], null,['class'=>'form__control selectpicker','required'=>'required']) !!}
                        {!! errors_for('published',$errors) !!}


                </div>
                @endif
                <div class="form__group">
                    {!! Form::submit(isset($buttonText) ? $buttonText : 'Agregar Producto',['class'=>'btn btn-primary'])!!}
                    {!! link_to_route('profile.show',  'Regresar', (isset($product)) ? $product->user->username : Auth::user()->username, ['class'=>'btn btn-default'])!!}
                </div>




            </div>
        </section>

    </div>
    <div class="right-section" >

        <section class="panel">
            <h1 class="product__edit__title">Imagen Principal</h1>

            <div class="form">
                <div class="form__group">
                    {!! Form::label('image','Imagen:',['class'=>'col-sm-2 control-label'])!!}


                    {!! Form::file('image',['required'=>'required']) !!}
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
</div>

		
		


