<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    // GET /recipes
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $age = $request->string('age_category')->toString();
        $user = auth()->user();

        $query = Recipe::query()
            ->when($q, fn($qb) => $qb->where('title', 'like', "%{$q}%"))
            ->when($age, fn($qb) => $qb->where('age_category', $age))
            ->orderBy('title');

        // Admin dan Puskesmas bisa lihat semua resep (termasuk draft)
        // Kader hanya bisa lihat yang published
        if (!in_array($user->role, ['admin', 'puskesmas'])) {
            $query->where('is_published', true);
        }

        $items = $query->simplePaginate(12)->appends($request->query());

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
        $user = auth()->user();

        // Admin dan Puskesmas bisa lihat semua resep
        // Kader hanya bisa lihat yang published
        if (!$recipe->is_published && !in_array($user->role, ['admin', 'puskesmas'])) {
            abort(404);
        }

        return view('recipes.show', compact('recipe'));
    }

    // GET /recipes/create
    public function create()
    {
        $ageCategories = [
            'mpasi_6_12' => 'MPASI (6-12 bulan)',
            'balita_1_3' => 'Balita (1-3 tahun)',
            'anak_3_5' => 'Anak (3-5 tahun)',
        ];

        return view('recipes.create', compact('ageCategories'));
    }

    // POST /recipes
    public function store(RecipeRequest $request)
    {
        $data = $request->validated();

        // Generate slug from title if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure unique slug
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Recipe::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipes', 'public');
            $data['image_path'] = 'storage/' . $path;
        } elseif (!empty($data['image_url'])) {
            $data['image_path'] = $data['image_url'];
        }
        unset($data['image'], $data['image_url']);

        // Set created_by
        $data['created_by'] = auth()->id();

        // Handle is_published checkbox
        $data['is_published'] = $request->boolean('is_published');

        Recipe::create($data);

        return redirect()->route('recipes.index')
            ->with('success', 'Resep berhasil ditambahkan.');
    }

    // GET /recipes/{recipe}/edit
    public function edit(Recipe $recipe)
    {
        $ageCategories = [
            'mpasi_6_12' => 'MPASI (6-12 bulan)',
            'balita_1_3' => 'Balita (1-3 tahun)',
            'anak_3_5' => 'Anak (3-5 tahun)',
        ];

        return view('recipes.edit', compact('recipe', 'ageCategories'));
    }

    // PUT /recipes/{recipe}
    public function update(RecipeRequest $request, Recipe $recipe)
    {
        $data = $request->validated();

        // Generate slug from title if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure unique slug (excluding current recipe)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Recipe::where('slug', $data['slug'])->where('id', '!=', $recipe->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists and is stored locally
            if ($recipe->image_path && Str::startsWith($recipe->image_path, 'storage/')) {
                $oldPath = str_replace('storage/', '', $recipe->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('recipes', 'public');
            $data['image_path'] = 'storage/' . $path;
        } elseif (!empty($data['image_url'])) {
            // Delete old image if exists and is stored locally
            if ($recipe->image_path && Str::startsWith($recipe->image_path, 'storage/')) {
                $oldPath = str_replace('storage/', '', $recipe->image_path);
                Storage::disk('public')->delete($oldPath);
            }
            $data['image_path'] = $data['image_url'];
        }
        unset($data['image'], $data['image_url']);

        // Handle is_published checkbox
        $data['is_published'] = $request->boolean('is_published');

        $recipe->update($data);

        return redirect()->route('recipes.index')
            ->with('success', 'Resep berhasil diperbarui.');
    }

    // DELETE /recipes/{recipe}
    public function destroy(Recipe $recipe)
    {
        // Delete image if exists and is stored locally
        if ($recipe->image_path && Str::startsWith($recipe->image_path, 'storage/')) {
            $oldPath = str_replace('storage/', '', $recipe->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')
            ->with('success', 'Resep berhasil dihapus.');
    }
}
