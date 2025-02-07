<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Article;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SellController extends Controller
{
    public function index()
    {
        $categories = Category::with('articles')->get();

        $articles = Article::all();
        if (!session()->has('stock_alert_shown')) {
            foreach($articles as $article) {
                if ($article->quantity <= $article->quantity_alert) {
                    session()->flash('message', 'L\'article ' . $article->title . ' a atteint le stock d\'alerte.');
                    session()->put('stock_alert_shown', true);
                    break;
                }
            }
        }

        return view('dashboard', compact('categories'));
    }

    public function list()
    {
        $sales = Sale::all();

        return view('sales_list', compact('sales'));
    }

    public function create(Article $article)
    {
        $articles = Article::all();

        return view('cart', compact('article', 'articles'));
    }

    public function store(Request $request, Article $article)
    {
        $validData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'payment_method' => 'required|array',
        ]);

        $sale = new Sale;
        $sale->article_id = $article->id;
        $sale->quantity = $validData['quantity'];
        $sale->price = $validData['price'];
        $sale->payment_method = $validData['payment_method'][0];
        $sale->status = 'active';
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Vente enregistrée !');
    }

    public function updateCart(Request $request)
    {
        $articleId = $request->input('articleId');
        $newQuantity = $request->input('quantity');
        $newPrice = $request->input('price');

        $cart = Session::get('cart', []);

        if ($newQuantity == 0) {
            unset($cart[$articleId]);
        } else {
            $cart[$articleId] = [
                'quantity' => $newQuantity,
                'price' => $newPrice,
            ];
        }

        Session::put('cart', $cart);

        return Redirect::route('cart')->with('success', 'Panier mis à jour avec succès !');
    }

    public function confirmPurchase(Request $request)
    {
        $cart = Session::get('cart', []);

        $paymentMethods = $request->input('payment_method');
        if (empty($paymentMethods)) {
            return redirect()->route('cart')->with('error', 'Veuillez choisir un moyen de paiement.');
        }

        DB::beginTransaction();

        try {
            foreach ($cart as $articleId => $details) {
                $article = Article::find($articleId);

                if (!$article || $article->quantity < $details['quantity']) {
                    return redirect()->route('cart')->with('error', 'Article indisponible dans la quantité souhaitée.');
                }

                $sale = new Sale;
                $sale->article_id = $article->id;
                $sale->quantity = $details['quantity'];
                $sale->price = $details['price'];
                $sale->status = 'active';
                $sale->save();

                $article->quantity -= $details['quantity'];
                $article->save();

                $paymentMethods = $request->input('payment_method');
                foreach ($paymentMethods as $method) {
                    $amount = (float) $request->input('amount_' . $method);
                    $comment = $request->input('comment_' . $method);
                    $request->input('amount_cb');
                    $request->input('comment_cb');
                    $request->input('amount_especes');
                    $request->input('comment_especes');
                    $request->input('amount_chq');
                    $request->input('comment_chq');

                    if ($amount > 0) {
                        $payment = new Payment;
                        $payment->sale_id = $sale->id;
                        $payment->method = $method;
                        $payment->amount = $amount;
                        $payment->comment = $comment;
                        $payment->save();
                    }
                }
            }

            Session::forget('cart');

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Vente enregistrée avec succès!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('cart')->with('error', 'Oops...la vente n\'a pas été enregistrée.');
        }
    }

    public function addToCart(Request $request)
    {
        $selectedArticles = $request->input('selected_articles');
        $cart = Session::get('cart', []);

        foreach ($selectedArticles as $articleId) {
            $article = Article::findOrFail($articleId);
            if(isset($cart[$articleId])) {
                $cart[$articleId]['quantity'] += 1;
            } else {
                $cart[$articleId] = [
                'quantity' => 1,
                'price' => $article->price,
                ];
            }
        }

        Session::put('cart', $cart);

        return Redirect::route('cart')->with('success', 'Article ajouté au panier avec succès !');
    }

    public function cart()
    {
        $cart = Session::get('cart', []);
        $selectedArticles = Article::whereIn('id', array_keys($cart))->get();

        return view('cart', compact('cart','selectedArticles'));
    }

}
