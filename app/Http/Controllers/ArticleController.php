<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class ArticleController extends Controller
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'             => 'required | string',
            'price'             => 'nullable | decimal:2',
            'quantity'          => 'required | integer | min:0',
            'quantity_alert'    => 'required | integer | min:0',
            'category_id'       => 'required',
            'image'             => 'nullable | image | mimes:jpeg,png,jpg,gif,webp,heif,heic,heif-sequence,heic-sequence',
            'description'       => 'nullable | string',
            'reference'         => 'nullable',
            'status'            => 'required | in:actif,inactif',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'quantity.required' => 'Le champ stock est requis avec un minimum de 0',
            'quantity_alert.required' => 'Le champ alerte stock est requis avec un minimum de 0',
        ];
    }

    public function index()
    {
        $articles = Article::all();

        return view('articles.index',compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validData = $request->validate($this->rules(), $this->messages());

        if ($request->image != null) {
            $path = $request->file('image')->storeAs('img', Str::slug($validData['title'], '_').'.'.$request->image->extension(), 'public');
            $validData["image"] = 'storage/' . $path;
        }

        Article::create($validData);

        return redirect()->route('articles.index')->with('success','Article créé avec succès !');
    }

    public function show(Article $article)
    {
        return view('articles.show',compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::all();

        return view('articles.edit',compact('article','categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validData = $request->validate($this->rules());

        if ($request->image != null) {
            $path = Storage::putFileAs('img', $request->image, Str::slug($validData['title'], '_').'.'.$request->image->extension());
            $validData["image"] = $path;
        }

        $article->update($validData);

        return redirect()->route('articles.index')->with('success','Article mis à jour avec succès !');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')->with('success','Article supprimé avec succès !');
    }
}
