{{ Form::open(array('route' => 'route.name', 'method' => 'POST')) }}
	<ul>
		<li>
			{{ Form::label('effet_id', 'Effet_id:') }}
			{{ Form::text('effet_id') }}
		</li>
		<li>
			{{ Form::label('possession_id', 'Possession_id:') }}
			{{ Form::text('possession_id') }}
		</li>
		<li>
			{{ Form::submit() }}
		</li>
	</ul>
{{ Form::close() }}