<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\AuditLogger;

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
    $asset = Asset::create($request->validated());

    AuditLogger::record('asset.created', $asset, [
        'name' => $asset->name,
        'ip_address' => $asset->ip_address,
    ]);

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

    AuditLogger::record('asset.updated', $asset, [
        'name' => $asset->name,
        'status' => $asset->status,
    ]);

    return redirect()
        ->route('assets.index')
        ->with('status', 'Activo actualizado correctamente.');
}

public function destroy(Asset $asset): RedirectResponse
{
    $snapshot = ['name' => $asset->name, 'ip_address' => $asset->ip_address];
    AuditLogger::record('asset.deleted', $asset, $snapshot);

    $asset->delete();

    return redirect()
        ->route('assets.index')
        ->with('status', 'Activo eliminado del inventario.');
}
}