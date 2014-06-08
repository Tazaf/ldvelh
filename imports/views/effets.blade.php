{{ Form::open(array('route' => 'route.name', 'method' => 'POST')) }}
	<ul>
		<li>
			{{ Form::label('modificateur', 'Modificateur:') }}
			{{ Form::text('modificateur') }}
		</li>
		<li>
			{{ Form::label('valeur', 'Valeur:') }}
			{{ Form::text('valeur') }}
		</li>
		<li>
			{{ Form::label('caracteristique_id', 'Caracteristique_id:') }}
			{{ Form::text('caracteristique_id') }}
		</li>
		<li>
			{{ Form::submit() }}
		</li>
	</ul>
{{ Form::close() }}