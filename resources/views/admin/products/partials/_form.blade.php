<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
            {!! Form::submit(isset($buttonText) ? $buttonText : 'Create Product',['class'=>'btn btn-primary'])!!}
            {!! link_to_route('products',  'Cancel', null, ['class'=>'btn btn-default'])!!}
        </header>
        <div class="panel-body">

            @if(isset($product))
                {!! Form::hidden('product_id',  $product->id) !!}
            @endif

            <div class="form-group">
                {!! Form::label('name','Name:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('name',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('slug','Slug:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <div class="input-group mg-b-md">
                        {!! Form::text('slug', null,['class'=>'form-control', 'readonly']) !!}
                        <span class="input-group-btn">
                        <button class="btn btn-white btn-edit-slug" type="button">Edit!</button>
                    </span>
                        {!! errors_for('slug',$errors) !!}
                    </div>

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('categories','Categoria:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                {!! Form::select('categories[]', ['' => ''] + $categories_list, isset($selected_categories) ? $selected_categories : null , ['class'=>'form-control','required'=>'required']) !!}
                {!! errors_for('categories',$errors) !!}
                </div>
            </div>
                <div class="form-group">
                    {!! Form::label('tags','Tags:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::select('tags[]', $tags_list, isset($selected_tags) ? $selected_tags : null , ['multiple' => 'multiple','class'=>'form-control']) !!}
                        {!! errors_for('tags',$errors) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('option_id','Option:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::text('option_id', null,['class'=>'form-control']) !!}
                        {!! errors_for('option_id',$errors) !!}
                    </div>
                </div>
            <div class="form-group">
                {!! Form::label('description','Description:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::textarea('description',null,['class'=>'form-control','id'=>'ckeditor','required'=>'required']) !!}
                    {!! errors_for('description',$errors) !!}
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('price','Precio:', ['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">&cent;</span>
                        {!! Form::text('price',isset($product) ? money($product->price, false) : null,['class'=>'form-control','required'=>'required'])!!}
                        {!! errors_for('price',$errors) !!}

                    </div>
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('published','Published:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::select('published', ['1' => 'Yes', '0' => 'No'], null,['class'=>'form-control selectpicker','required'=>'required']) !!}
                    {!! errors_for('published',$errors) !!}
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('featured','Featured:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::select('featured', ['1' => 'Yes', '0' => 'No'], null,['class'=>'form-control selectpicker','required'=>'required']) !!}
                    {!! errors_for('featured',$errors) !!}
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('user','User:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    <span class="btn btn-white btn-sm" data-toggle="modal" data-target=".bs-modal-sm" id="btn-add-user">Buscar</span>
                    <ul class="users">
                        @if(isset($product->user_id))

                            <li data-id="{!! $product->user_id !!}">
                                <span class="delete" data-id="{!! $product->user_id !!}"><i class="glyphicon glyphicon-remove"></i></span>

                                <span class="label label-success">{!! $product->user->username !!}</span>

                                {!! Form::hidden('user_id', isset($product) ? $product->user_id : null, ['class' => 'form-control']) !!}

                            </li>


                        @endif
                    </ul>
                    {!! errors_for('user_id',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('image','Image:',['class'=>'col-sm-2 control-label'])!!}

                <div class="col-sm-10">
                    {!! Form::file('image') !!}
                    {!! errors_for('image',$errors) !!}
                </div>
            </div>

        </div>
    </section>

</div>
<div class="col-lg-6">

    <section class="panel">
        <header class="panel-heading">
            {!! Form::label('image','Current Image:',['class'=>'control-label'])!!}
        </header>
        <div class="panel-body">
            @if (isset($product))
                <div class="main_image">
                    @if ($product->image)
                        <img src="{!! photos_path('products') !!}thumb_{!! $product->image !!}"
                             alt="{!! $product->image !!}">

                    @endif

                </div>
            @endif
                <div class="form-group">

                    <header class="panel-heading">
                        {!! Form::label('gallery','Gallery:',['class'=>'control-label'])!!}
                    </header>

                    @if(isset($product))

                        <div id="container-gallery">

                            <a class="UploadButton btn btn-info" id="UploadButton">Subir Imagen</a>
                            <div id="InfoBox"></div>
                            <ul id="gallery">

                                @foreach ($product->photos as $photo)
                                    <li>
                                        <span class="delete" data-imagen="{!! $photo->id !!}"><i class="glyphicon glyphicon-remove"></i></span>
                                        <a href="{!! photos_path('products') !!}{!! $photo->product_id !!}/{!! $photo->url !!}" data-lightbox="gallery"><img src="{!! photos_path('products') !!}{!! $photo->product_id !!}/{!! $photo->url_thumb !!}" alt="img" /></a>
                                    </li>
                                @endforeach

                            </ul>
                            <script id="photoTemplate" type="text/x-handlebars-template">

                                <li>
                                    <span class="delete" data-imagen="@{{ id }}"><i class="glyphicon glyphicon-remove"></i></span>
                                    <a href="/media/products/@{{ product_id }}/@{{ url }}" data-lightbox="gallery"><img src="/media/products/@{{ product_id }}/@{{ url_thumb }}" alt="img" /></a>
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


		
		


