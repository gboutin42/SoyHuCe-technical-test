@extends('layouts.app')

@section('title', 'Bienvenue')

@section('content')
	@for($i=0; $i<10; $i++)
		<p class="p-2">
			Ici vous pouvez télécharger des photos depuis votre ordinateur,<br>
			vous pouvez modifier leurs apparences grâce à des filtres ( black & white, et sépia ),<br>
			vous pouvez aussi redimensionner et/ou recadrer vos images,<br>
			leurs donner un nouveau nom et enfin les récupérés sur votre ordinateur.
		</p>
	@endfor
@endsection