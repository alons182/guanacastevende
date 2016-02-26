<div class="product__edit">
    <div class="panel">
        <h1 class="product__edit__title">Editando Producto</h1>
        <p>**Ingresa aquí tu producto, es gratis y <strong>estará en línea por 30 días</strong> !!</p>
        <p><strong class="orange underline">Solo se permite un artículo por publicación</strong>, esto para mantener el orden y que tus posibles compradores encuentren tu artículo en la categoría correspondiente.</p>

    </div>
    <hr style="margin: 1.5rem 0;">
    <div class="right-section" >

        <section class="panel">
            <!--<h1 class="product__edit__title">Agregar Imagen</h1>-->
            <div class="form">
                <div class="form__group">
                    <h2 style="text-transform: uppercase;">Imagen Principal:</h2>


                    {!! Form::file('image',['required'=>'required','data-holder' =>'image-holder','class'=>'inputfile','id'=>'image']) !!}

                    <label for="image"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Agregar imagen</span></label>

                    {!! errors_for('image',$errors) !!}
                    <div id="image-holder" class="image-holder"></div>
                    <small>Tamaño recomendado (640x640)</small>
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

                    {!! Form::label('gallery','Fotos adicionales:',['class'=>'control-label'])!!}
                    <span>Podés agregar hasta 5 fotos adicionales de tu producto.</span>
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

                            <!--<input class="inputfile" id="imageGallery" type="file" name="new_photo_file[]" data-multiple-caption="{count} imagenes seleccionadas" multiple  />
                            <label for="imageGallery"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Agregar imagenes</span></label>
                            <output id="result" />-->
                        </div>

                    @endif
                </div>
            </div>
        </section>

    </div>
    <div class="left-section">
        <section class="panel">

            <div class="form">

                <div class="form__group">
                    {!! Form::label('name','Nombre de producto:',['class'=>'col-sm-2 control-label']) !!}

                        {!! Form::text('name', null,['class'=>'form__control','required'=>'required','maxlength'=>'20']) !!}
                        {!! errors_for('name',$errors) !!}

                </div>
                   {!! Form::hidden('slug', null,['class'=>'form__control', 'readonly']) !!}

                <div class="form__group">
                    {!! Form::label('categories','Seleccione una categoria:',['class'=>'col-sm-2 control-label'])!!}

                    <div class="select__category">
                        <select  name="parentCategories" class="rootCategories" size="5" data-container="0" required="required" >
                            <option value="" disabled selected>Escoje tu categoria</option>
                            @foreach($categories_list as $category)
                                <option class="option-icon" value="{!! $category->id !!}">{!! $category->name !!} </option>
                            @endforeach

                        </select>
                        <div class="select__sub-category">

                        </div>

                    </div>
                    <div class="select__category__loader">
                        <div class="select__category__loader__container">

                            <img src="/img/loading.gif" alt="Cargando..." />
                        </div>
                    </div>
                    <span class="select__category__message"><b>Categoria seleccionada</b></span>
                    <script id="selectCategoryTemplate" type="text/x-handlebars-template">

                        <select  name="parentCategories" class="rootCategories" size="5" data-container="@{{ container }}" required="required" >
                            <option value="" disabled selected>Escoje una subcategoria</option>
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

                        {!! Form::textarea('description',null,['class'=>'form__control','id'=>'ckeditor','required'=>'required','maxlength'=>'1000']) !!}
                        {!! errors_for('description',$errors) !!}


                </div>
                <div class="form__group">
                    {!! Form::label('price','Precio:', ['class'=>'col-sm-2 control-label'])!!}

                        <div class="input__group input__group--left">
                            <span class="input__group__icon">&cent;</span>
                            {!! Form::text('price',isset($product) ? money($product->price, false) : null,['class'=>'form__control currency','required'=>'required'/*, 'onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57'*/])!!}
                            {!! errors_for('price',$errors) !!}

                        </div>

                </div>
                <div class="from__group options__info">
                    <div class="box">
                        <p>**Publicar artículos en Guancaste Vende es completamente gratuito, solamente que <b>deberás esperar por la confirmación teléfonica</b> dentro de las próximas 72 horas y la respectiva activación de tu anuncio.</p>
                    </div>
                    <div class="box">
                        <p><b>Si no deseas esperar</b> puedes escoger cualquiera de los siguientes servicios que <b>son opcionales, y tienen el costo indicado.</b> Si escoges cualquiera de ellos, debes pagar en línea con tarjeta de crédito ó débito, o con tu cuenta PayPal en nuestro servidor seguro, una vez que oprimas el botón de <strong>AGREGAR PRODUCTO</strong></p>
                        <p>(si no quieres ninguna de las opciones simplemente deja los checkbox vacíos en las opciones):</p>
                    </div>





                </div>
                <div class="form__group">
                    {!! Form::label('option','Opciones para publicaciones especiales:',['class'=>'col-sm-2 control-label'])!!}
                    @foreach($options_list as $option)
                        <div class="box">
                            <input type="checkbox" value="{!! $option->id !!}" name="option_id" {!! (isset($product)) ? ($product->option_id == $option->id) ? 'checked="checked"' : '' : '' !!}> <b class="option__title">{!! $option->name !!}</b> <br />
                            <div class="option__description">
                                {!! $option->description !!}
                            </div>
                            @if($option->id == 4)
                                <div class="option__tags">
                                    {!! Form::label('tags','Etiquetas:',['class'=>'col-sm-2 control-label'])!!}
                                    @foreach($tags_list as $tag)
                                        <input type="checkbox" value="{!! $tag->id !!}" name="tags[]" {!! isset($selected_tags[0]) ? ($tag->id == $selected_tags[0]) ? 'checked="checked"' : '' : '' !!} disabled="disabled" > {!! $tag->name !!} - {!! money($tag->price, '₡') !!} <i class="{!! $tag->icon !!}"></i> <br />
                                    @endforeach
                                </div>


                            @endif
                        </div>

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


</div>
<div class="form__group">
    {!! Form::submit(isset($buttonText) ? $buttonText : 'Agregar Producto',['class'=>'btn btn-primary'])!!}
    {!! link_to_route('profile.show',  'Regresar', (isset($product)) ? $product->user->username : Auth::user()->username, ['class'=>'btn btn-default'])!!}
</div>

		
		


