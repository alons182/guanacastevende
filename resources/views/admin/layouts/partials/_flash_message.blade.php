@if (Session::has('flash_message'))

	@if (Session::has('flash_type'))

		<div class="flash-message alert {!! Session::get('flash_type') !!}">
	@else
		<div class="flash-message alert alert-info ">

	@endif

			<p>{!! Session::get('flash_message') !!}</p>
		</div>

@endif