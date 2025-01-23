<div class="grid grid-cols-1 gap-6">
    <div class="">
        <label class="font-bold text-lg">
            Titre
            <span class="ml-2 text-red-600">*</span>
            @error('title')
            <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </label>
        <input type="text" name="title" class="w-full" value="{{ old('title', $article->title ?? null) }}">
    </div>
    <div class="flex items-center justify-between gap-8">
        <div class="w-full">
            <label class="font-bold text-lg">
                Prix
                @error('price')
                <span class="ml-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </label>
            <input type="number" min="0" step="0.01" value="0.00" name="price" class="w-full" value="{{ old('price', $article->price ?? null) }}">
        </div>
        <div class="w-full">
            <label class="font-bold text-lg">Référence</label>
            <div class="text-black">
                <input type="text" name="reference" class="w-full" value="{{ old('reference', $article->reference ?? null) }}">
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between gap-8">
        <div class="w-full">
            <label class="font-bold text-lg">
                Stock
                <span class="ml-2 text-red-600">*</span>
                @error('quantity')
                <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </label>
            <input type="number" name="quantity" class="w-full" value="{{ old('quantity', $article->quantity ?? null) }}">
        </div>
        <div class="w-full">
            <label class="font-bold text-lg">
                Alerte stock
                <span class="ml-2 text-red-600">*</span>
                @error('quantity_alert')
                <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </label>
            <input type="number" name="quantity_alert" class="w-full" value="{{ old('quantity_alert', $article->quantity_alert ?? null) }}">
        </div>
    </div>
    <div class="py-2">
        <label class="font-bold text-lg" for="image">
            Image
            @error('image')
            <span class="text-xs text-red-500">{{ $errors->first('image') }}</span>
            @enderror
        </label>
        <div class="flex items-center gap-4">
            @if($article->image ?? false)
                <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="h-24 object-cover" />
            @endif
            <input type="file" name="image" id="image">
        </div>
    </div>
    <div class="">
        <label class="font-bold text-lg">Description</label>
        <textarea class="w-full" name="description">{{ old('description', $article->description ?? null) }}</textarea>
    </div>
    <div class="flex items-center justify-between mb-12">
        <div class="flex items-center gap-4 basis-1/2">
            <label class="font-bold text-lg">Catégorie</label>
            <select name="category_id">
                @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @if ($article ?? false) {{ $category->id == $article->category_id ? 'selected' : '' }}
                    @else {{ $category->id == old('category_id') ? 'selected' : '' }} @endif>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-4">
            <label class="font-bold text-lg">Statut</label>
            <select name="status">
                <option @if($article ?? false) {{ 'actif' == $article->status ? 'selected' : '' }}
                    @else {{ 'actif' == old('status') ? 'selected' : '' }} @endif
                    value="actif">
                    actif
                </option>
                <option @if($article ?? false) {{ 'inactif' == $article->status ? 'selected' : '' }}
                    @else {{ 'inactif' == old('status') ? 'selected' : '' }} @endif
                    value="inactif">
                    inactif
                </option>
            </select>
        </div>
    </div>
    <div class="bg-teal-600/20 py-4 px-4 rounded-b-xl -m-2 sm:-m-6">
        <div class="flex justify-between items-center">
            <a class="border-2 rounded-md border-teal-600 bg-white hover:bg-teal-600 hover:text-white text-gray-800 p-3 px-5" href="{{ route('articles.index') }}">Retour</a>
            <button type="submit" class="border-2 rounded-md border-teal-600 bg-white hover:bg-teal-600 hover:text-white text-gray-800 p-3 px-5">Enregistrer</button>
        </div>
    </div>
</div>
