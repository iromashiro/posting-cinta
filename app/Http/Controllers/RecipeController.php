<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // GET /recipes
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $age = $request->string('age_category')->toString();

        $items = Recipe::query()
            ->where('is_published', true)
            ->when($q, fn($qb) => $qb->where('title', 'like', "%{$q}%"))
            ->when($age, fn($qb) => $qb->where('age_category', $age))
            ->orderBy('title')
            ->simplePaginate(12)
            ->appends($request->query());

        $ageCategories = [
            'mpasi_6_12' => 'MPASI (6-12 bln)',
            'balita_1_3' => 'Balita (1-3 thn)',
            'anak_3_5' => 'Anak (3-5 thn)',
        ];

        return view('recipes.index', compact('items', 'q', 'age', 'ageCategories'));
    }

    // GET /recipes/{recipe}
    public function show(Recipe $recipe)
    {
        if (!$recipe->is_published) {
            abort(404);
        }

        return view('recipes.show', compact('recipe'));
    }
}
