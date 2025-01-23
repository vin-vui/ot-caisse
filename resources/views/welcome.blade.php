<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="body-bg min-h-screen pt-4 md:pt-20 pb-6 px-2 md:px-0" style="font-family:'Lato',sans-serif;">
    <header class="max-w-lg mx-auto pt-2">
        <h1 class="text-4xl font-bold text-white text-center">Office de tourisme</h1>
        <h2 class="text-2xl py-4 font-bold text-white text-center">Baume les Dames</h2>
    </header>
    <main class="bg-white bg-opacity-40 max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section class='flex items-center justify-between'>
            <img src="{{ asset('img/Logo_OT_Turquoise_BLD.jpeg') }}" class="h-16 ml-4">
            <h3 class="font-bold text-2xl ml-12 mt-4">Gestion des ventes</h3>
        </section>
        <section class="mt-10">
            <form class="flex flex-col" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-300 transition duration-500 px-3 pb-3" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-300 transition duration-500 px-3 pb-3" required>
                    @error('password')
                        <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <!-- <div class="flex justify-end">
                    <a href="{{ route('password.request') }}" class="text-sm text-purple-700 hover:text-purple-00 hover:underline mb-6">Mot de passe oublié ?</a>
                </div> -->
                <button class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Se connecter</button>
            </form>
        </section>
    </main>
</body>
</html>
