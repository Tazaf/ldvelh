{{ Form::open(array('route' => 'route.name', 'method' => 'POST')) }}
	<ul>
		<li>
			{{ Form::label('nom', 'Nom:') }}
			{{ Form::text('nom') }}
		</li>
		<li>
			{{ Form::label('type_id', 'Type_id:') }}
			{{ Form::text('type_id') }}
		</li>
		<li>
			{{ Form::submit() }}
		</li>
	</ul>
{{ Form::close() }}