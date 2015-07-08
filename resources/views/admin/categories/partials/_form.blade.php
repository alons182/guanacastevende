<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
            {!! Form::submit(isset($buttonText) ? $buttonText : 'Create Category',['class'=>'btn btn-primary'])!!}
            {!! link_to_route('categories',  'Cancel', null, ['class'=>'btn btn-default'])!!}
        </header>
        <div class="panel-body">

            @if(isset($category))
                {!! Form::hidden('category_id',  $category->id) !!}
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
                {!! Form::label('parent_id','Categoria Padre:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::select('parent_id', ($options) ?  ['root' => 'Root'] + $options : ['root' => 'Root']  , null , ['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('parent_id',$errors) !!}
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
            @if (isset($category))
                <div class="main_image">
                    @if ($category->image)
                        <img src="{!! photos_path('categories') !!}thumb_{!! $category->image !!}"
                             alt="{!! $category->image !!}">

                    @endif

                </div>
            @endif

        </div>
    </section>

</div>


		
		


