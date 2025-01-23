<x-app-layout>
    <div class="max-w-5xl mx-auto py-4 px-2 sm:px-8">
        <div class="bg-teal-600 text-white p-2 rounded-t-xl py-4 flex items-center justify-between">
            <span class="font-bold text-2xl font-lobster">Modifier la catégorie</span>
            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="flex items-center justify-end gap-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-white bg-red-600 py-1 px-2 rounded-md flex items-center gap-1 hover:bg-white hover:text-red-600">
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79s-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg>
                    Supprimer
                </button>
            </form>
        </div>
        <div class="bg-white shadow-xl p-6 rounded-b-xl font-paragraph">
            <div class="text-black font-bold">
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('categories._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
