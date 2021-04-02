<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>@yield('title', 'Default content')</title>

		<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

	</head>

	<body class="bg-red-50 text-blue-600 flex flex-col min-h-screen justify-between">
		@include('../inc/header')

		<main role="main" class="text-center m-8">
			@yield('content')
		</main>
		
		@include('../inc/footer')
	</body>
</html>
