<div class="grid grid-cols-1 gap-4">
    <div class="pb-5">
        <label class="font-bold text-lg">Nom</label>
        <div class="text-black">
            <input type="text" name="name" class="w-full" value="{{ old('name', $category->name ?? null) }}">
        </div>
    </div>
    <div class="pb-5">
        <label class="font-bold text-lg text-black">Description</label>
        <div class="text-black">
            <input type="text" name="description" value="{{ old('description', $category->description ?? null) }}" class="w-full">
        </div>
    </div>
    <div class="flex items-center justify-between mb-12">
        <div class="flex items-center gap-4 basis-1/2">
            <label class="font-bold text-lg">Couleur</label>
            <div class="w-full text-black">
                <input type="color" name="color" class="w-full h-10" value="{{ old('color', $category->color ?? null) }}">
            </div>
        </div>
        <div class="flex items-center gap-4">
            <label class="font-bold text-lg">Statut</label>
            <select name="status">
                <option @if($category ?? false) {{ 'actif' == $category->status ? 'selected' : '' }}
                    @else {{ 'actif' == old('status') ? 'selected' : '' }} @endif
                    value="actif">
                    actif
                </option>
                <option @if($category ?? false) {{ 'inactif' == $category->status ? 'selected' : '' }}
                    @else {{ 'inactif' == old('status') ? 'selected' : '' }} @endif
                    value="inactif">
                    inactif
                </option>
            </select>
        </div>
    </div>
    <div class="bg-teal-600/20 py-4 px-4 rounded-b-xl -m-2 sm:-m-6">
        <div class="flex justify-between items-center">
            <a class="border-2 rounded-md border-teal-600 bg-white hover:bg-teal-600 hover:text-white text-gray-800 p-3 px-5" href="{{ route('categories.index') }}">Retour</a>
            <button type="submit" class="border-2 rounded-md border-teal-600 bg-white hover:bg-teal-600 hover:text-white text-gray-800 p-3 px-5">Enregistrer</button>
        </div>
    </div>
</div>
