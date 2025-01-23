<x-app-layout>
    <div class="max-w-5xl mx-auto py-4 px-2 sm:px-8">
        <div class="bg-teal-600 text-white p-2 rounded-t-xl py-4 font-bold text-2xl font-lobster">
            Ajouter une catégorie
        </div>
        <div class="bg-white shadow-xl p-6 rounded-b-xl font-paragraph">
            <div class="text-black font-bold">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    @include('categories._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
