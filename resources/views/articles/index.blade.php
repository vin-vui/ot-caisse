<x-app-layout>
    <header class="bg-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between">
            <h2 class="font-h1 text-4xl font-bold text-teal-600 leading-tight">Articles</h2>
            <a class="border-2 rounded-md border-teal-600 bg-white text-black font-h1 font-bold p-2 hover:bg-teal-600 hover:text-white mt-4 sm:mt-0" href="{{ route('articles.create') }}">Créer un nouvel article</a>
        </div>
    </header>
    <main class="mx-auto px-2 sm:px-6 pb-12">
        <div class="row mt-4 font-bold">
            <div class="relative overflow-x-auto overflow-auto shadow-xl rounded-lg">
                <table class="w-full text-sm text-left">
                    <thead class="sm:text-sm uppercase bg-teal-600 text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                &nbsp;
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                Titre
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap text-right">
                                Prix
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">
                                Stock
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">
                                Alerte stock
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                Catégorie
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                Référence
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr class="bg-white text-black font-bold hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <img class="size-16 object-cover rounded-full {{ $article->status == 'actif' ? '' : 'grayscale' }}"
                                    src="{{ $article->image != null ? url($article->image) : url('img/placeholder.jpg') }}" alt="">
                                </td>
                                <td scope="row" class="px-6 py-3">
                                    {{ $article->title }}
                                </td>
                                <td class="px-6 py-3 text-black whitespace-nowrap text-right">
                                    {{ number_format($article->price, 2, '.', '') }} €
                                </td>
                                <td class="px-6 py-3 text-center">
                                    @if ($article->quantity <= $article->quantity_alert)
                                        <span class="bg-red-600 text-white py-1 px-2 rounded-full">{{ $article->quantity }}</span>
                                    @else
                                        <span class="bg-green-600 text-white py-1 px-2 rounded-full">{{ $article->quantity }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <span class="bg-gray-100 border-gray-700 py-1 px-2 rounded-full">{{ $article->quantity_alert }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="size-8 rounded-full" style="background-color: {{ $article->category != null ? $article->category->color : null }}"></div>
                                        @if ($article->category != null)
                                            {{ $article->category->name }}
                                        @else
                                            <span class="text-red-600">sans catégorie</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    {{ $article->description }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $article->reference }}
                                </td>
                                <td scope="row" class="px-6 py-3 whitespace-nowrap text-black text-center">
                                     @if ($article->status == 'actif')
                                        <span class="text-white bg-green-600 py-0.5 px-2 text-xs rounded-full">Actif</span>
                                    @else
                                        <span class="text-white bg-red-600 py-0.5 px-2 text-xs rounded-full">Inactif</span>
                                    @endif
                                </td>
                                <td scope="row" class="font-bold flex items-center px-6 py-6 whitespace-nowrap justify-end">
                                    <a class="text-blue-600 py-2 px-3 hover:text-white hover:bg-blue-600 border border-blue-600 rounded-md justify-center flex items-center gap-1" href="{{ route('articles.edit', $article) }}">
                                        Voir
                                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M16.15 13H5q-.425 0-.712-.288T4 12t.288-.712T5 11h11.15L13.3 8.15q-.3-.3-.288-.7t.288-.7q.3-.3.713-.312t.712.287L19.3 11.3q.15.15.213.325t.062.375t-.062.375t-.213.325l-4.575 4.575q-.3.3-.712.288t-.713-.313q-.275-.3-.288-.7t.288-.7z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-app-layout>
