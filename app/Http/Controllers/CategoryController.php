<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Pantalla de categorías: lista + formulario para agregar.
     * Se incluye el conteo de sitios para saber cuáles están en uso.
     */
    public function index(): View
    {
        $categories = Category::withCount('sites')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Agrega una nueva categoría.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('status', 'Categoría agregada correctamente.');
    }

    /**
     * Elimina una categoría, solo si no está en uso por ningún sitio.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->isInUse()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'No se puede eliminar «'.$category->name.'» porque está asignada a uno o más sitios.');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('status', 'Categoría eliminada correctamente.');
    }
}
