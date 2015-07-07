<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					{!!  link_to_route('dashboard','Inicio')  !!}
					<i class="icon-angle-right"></i>
				</li>
				@if(isset($page))
				    <li><a href="#">{!! $page !!}</a></li>
				@else
				    <li><a href="#">Dashboard</a></li>
				    @endif
			</ul>