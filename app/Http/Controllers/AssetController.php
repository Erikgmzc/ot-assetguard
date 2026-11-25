<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function index(): View
    {
        $assets = Asset::latest()->get();

        return view('assets.index', compact('assets'));
    }

    public function create(): View
    {
        return view('assets.create');
    }

    public function store(StoreAssetRequest $request): RedirectResponse
    {
        Asset::create($request->validated());

        return redirect()
            ->route('assets.index')
            ->with('status', 'Activo registrado correctamente.');
    }

    public function show(Asset $asset): View
    {
        $asset->load('incidents.user');

        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset): View
    {
        return view('assets.edit', compact('asset'));
    }

    public function update(UpdateAssetRequest $request, Asset $asset): RedirectResponse
    {
        $asset->update($request->validated());

        return redirect()
            ->route('assets.index')
            ->with('status', 'Activo actualizado correctamente.');
    }

    public function destroy(Asset $asset): RedirectResponse
    {
        $asset->delete();

        return redirect()
            ->route('assets.index')
            ->with('status', 'Activo eliminado del inventario.');
    }
}