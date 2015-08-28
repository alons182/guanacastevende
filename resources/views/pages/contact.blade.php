@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | Contáctenos @stop
@section('meta-description')Llamános o escribínos para solucionar cualquier duda o consulta que tengas, en Guanacaste Vende</b>
estamos para servirle @stop
@section('content')
    <section class="contact">

        <address class="contact__address">
            <h2 class="contact__address__title">Horario de atención cása</h2>
            De Lunes a Viernes de 08:00 am a 12:00 y de 1:00 pm a 5:00 pm<br/>
            Sábados de 08:00 a 12:00 pm<br/>

            <span><b>Email:</b> info@guanacastevende.com</span><br/>
            <span><b>Telefono:</b> 2222-2222</span>
            <div class="contact__social">
                <a class="contact__social__link" href="https://www.facebook.com/guanacastevende" target="_blank"><i class="icon-facebook"></i></a>
                <a class="contact__social__link" href="https://twitter.com/GuanacasteVende" target="_blank"><i class="icon-twitter"></i></a>
                <a class="contact__social__link" href="https://www.youtube.com/channel/UCVDiC3vIclXSKmrKViPIIag" target="_blank"><i class="icon-youtube"></i></a>
                <a class="contact__social__link" href="https://plus.google.com/+GuanacastevendeCR" target="_blank"><i class="icon-google-plus"></i></a>
            </div>
        </address>

        <div class="form contact__form">
            <h1 class="contact__form__title">Contáctenos</h1>
            <p class="intro">"Llamános o escribínos para solucionar cualquier duda o consulta que tengas, en <b>Guanacaste Vende</b>
                estamos para servirle !!"</p>

            {!! Form::open(['route'=>'contact.store','class'=>'form-contact']) !!}

            <div class="form__group">
                <div class="label-container">
                    {!! Form::label('name','Nombre:')!!}
                </div>
                <div class="input-container">
                    {!! Form::text('name',null,['class'=>'form__control','required'=>'required'])!!}
                    {!! errors_for('name',$errors) !!}
                </div>

            </div>
            <div class="form__group">
                <div class="label-container">
                    {!! Form::label('email','Email:')!!}
                </div>
                <div class="input-container">
                    {!! Form::email('email',null,['class'=>'form__control','required'=>'required'])!!}
                    {!! errors_for('email',$errors) !!}
                </div>
            </div>
            <div class="form__group">

                {!! Form::textarea('comment',null,['class'=>'form__control']) !!}
                {!! errors_for('comment',$errors) !!}
            </div>
            <div class="form__group">
                {!! Form::submit('Enviar',['class'=>'btn btn-primary'])!!}
            </div>

            {!! Form::close() !!}
        </div>


    </section>
@stop