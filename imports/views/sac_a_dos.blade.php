{{ Form::open(array('route' => 'route.name', 'method' => 'POST')) }}
	<ul>
		<li>
			{{ Form::label('personnage_id', 'Personnage_id:') }}
			{{ Form::text('personnage_id') }}
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