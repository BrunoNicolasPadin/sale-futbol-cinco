<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
<body>
    <div class="flex items-center justify-center min-h-screen bg-indigo-100  bg-fixed bg-cover bg-bottom error-bg">

	<div class="container">
		<div class="row">
			<div class="col-sm-8 offset-sm-2 text-gray-50 text-center -mt-52">
                <span class="mb-6 text-xl text-black font-semibold">Oops!</span>

                <h1 class="text-9xl text-shadow font-sans font-bold">
                    404
                </h1>

				<h5 class="text-black font-semibold mb-6">Pagina no encontrada</h5>

				{{-- <p class="text-gray-100 mt-2 mb-6">we are sorry, but the page you requested was not found</p> --}}
                
				<a href="{{ route('inicio') }}"
					class="bg-green-400 my-4 px-5 py-3 text-sm shadow-sm font-medium tracking-wider text-gray-50 rounded-full hover:shadow-lg">
					Volver al inicio
				</a>
			</div>
		</div>
	</div>
</div>
</body>
</html>