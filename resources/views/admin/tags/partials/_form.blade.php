<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
            {!! Form::submit(isset($buttonText) ? $buttonText : 'Create Tag',['class'=>'btn btn-primary'])!!}
            {!! link_to_route('tags',  'Cancel', null, ['class'=>'btn btn-default'])!!}
        </header>
        <div class="panel-body">

            @if(isset($tag))
                {!! Form::hidden('tag_id',  $tag->id) !!}
            @endif

            <div class="form-group">
                {!! Form::label('name','Name:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('name',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('price','Price:', ['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">&cent;</span>
                        {!! Form::text('price',isset($product) ? money($product->price, false) : null,['class'=>'form-control','required'=>'required'])!!}
                        {!! errors_for('price',$errors) !!}

                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('icon','Icon:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('icon', null,['class'=>'form-control']) !!}
                    {!! errors_for('icon',$errors) !!}
                </div>


            </div>

        </div>
    </section>

</div>
<div class="col-lg-6">

    <section class="panel">
        <header class="panel-heading">

        </header>
        <div class="panel-body">


        </div>
    </section>

</div>


		
		


