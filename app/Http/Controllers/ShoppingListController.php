<?php

namespace App\Http\Controllers;

use App\Mail\ShoppingListMail;
use App\Models\Recipe;
use App\Models\ShoppingListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ShoppingListController extends Controller
{
    /** Vista principal de la lista */
    public function index()
    {
        $items = auth()->user()
            ->shoppingList()
            ->with('ingredient')
            ->orderBy('created_at')
            ->get();

        return view('shopping.index', compact('items'));
    }

    /** Añade los ingredientes seleccionados de una receta (desde el modal) */
    public function addFromRecipe(Recipe $recipe, Request $request)
    {
        $user          = auth()->user();
        $ingredientIds = $request->input('ingredient_ids', []);

        // Solo los ingredientes que pertenecen realmente a esta receta
        $ingredients = $recipe->ingredients->whereIn('id', $ingredientIds);

        foreach ($ingredients as $ingredient) {
            ShoppingListItem::firstOrCreate([
                'user_id'       => $user->id,
                'ingredient_id' => $ingredient->id,
            ]);
        }

        return response()->json([
            'message' => 'Ingredientes añadidos a la lista',
            'total'   => $user->shoppingList()->count(),
        ]);
    }

    /** Elimina un ítem concreto */
    public function remove(ShoppingListItem $item)
    {
        abort_unless($item->user_id === auth()->id(), 403);
        $item->delete();

        return back();
    }

    /** Vacía toda la lista */
    public function clear()
    {
        auth()->user()->shoppingList()->delete();

        return back()->with('status', 'Lista vaciada.');
    }

    /** Envía la lista por correo */
    public function sendEmail()
    {
        $user  = auth()->user();
        $items = $user->shoppingList()->with('ingredient')->orderBy('created_at')->get();

        if ($items->isEmpty()) {
            return back()->with('status', 'Tu lista de la compra está vacía.');
        }

        Mail::to($user->email)->send(new ShoppingListMail($user, $items));

        return back()->with('status', '¡Lista enviada a ' . $user->email . '!');
    }
}
