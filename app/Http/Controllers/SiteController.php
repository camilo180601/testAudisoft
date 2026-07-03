<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteRequest;
use App\Models\Category;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteController extends Controller
{
    /**
     * Pantalla principal: lista de sitios + formulario para agregar.
     */
    public function index(): View
    {
        $sites = Site::with('category')->latest()->paginate(4)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('sites.index', compact('sites', 'categories'));
    }

    /**
     * Agrega un nuevo sitio.
     */
    public function store(StoreSiteRequest $request): RedirectResponse
    {
        Site::create($request->validated());

        return redirect()
            ->route('sites.index')
            ->with('status', 'Sitio agregado correctamente.');
    }

    /**
     * Elimina un sitio.
     */
    public function destroy(Site $site): RedirectResponse
    {
        $site->delete();

        return redirect()
            ->route('sites.index')
            ->with('status', 'Sitio eliminado correctamente.');
    }
}
