{{ Form::open(array('route' => 'route.name', 'method' => 'POST')) }}
	<ul>
		<li>
			{{ Form::label('nom', 'Nom:') }}
			{{ Form::text('nom') }}
		</li>
		<li>
			{{ Form::label('habilete_max', 'Habilete_max:') }}
			{{ Form::text('habilete_max') }}
		</li>
		<li>
			{{ Form::label('endurance_max', 'Endurance_max:') }}
			{{ Form::text('endurance_max') }}
		</li>
		<li>
			{{ Form::label('chance_max', 'Chance_max:') }}
			{{ Form::text('chance_max') }}
		</li>
		<li>
			{{ Form::label('habilete', 'Habilete:') }}
			{{ Form::text('habilete') }}
		</li>
		<li>
			{{ Form::label('endurance', 'Endurance:') }}
			{{ Form::text('endurance') }}
		</li>
		<li>
			{{ Form::label('chance', 'Chance:') }}
			{{ Form::text('chance') }}
		</li>
		<li>
			{{ Form::label('repas', 'Repas:') }}
			{{ Form::text('repas') }}
		</li>
		<li>
			{{ Form::label('bourse', 'Bourse:') }}
			{{ Form::text('bourse') }}
		</li>
		<li>
			{{ Form::submit() }}
		</li>
	</ul>
{{ Form::close() }}