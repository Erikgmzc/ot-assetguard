<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncidentRequest;
use App\Models\Asset;
use App\Models\Incident;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IncidentController extends Controller
{
    public function index(): View
    {
        $incidents = Incident::with(['asset', 'user'])->latest()->get();

        return view('incidents.index', compact('incidents'));
    }

    public function store(StoreIncidentRequest $request, Asset $asset): RedirectResponse
    {
        $incident = $asset->incidents()->create([
            'user_id' => $request->user()->id,
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'severity' => $request->validated('severity'),
            'status' => 'abierta',
        ]);

        AuditLogger::record('incident.created', $incident, [
            'asset' => $asset->name,
            'severity' => $incident->severity,
            'title' => $incident->title,
        ]);

        return back()->with('status', 'Incidencia registrada correctamente.');
    }

    public function updateStatus(Request $request, Incident $incident): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['abierta', 'en_proceso', 'resuelta'])],
        ]);

        $previousStatus = $incident->status;
        $incident->update(['status' => $validated['status']]);

        AuditLogger::record('incident.status_updated', $incident, [
            'from' => $previousStatus,
            'to' => $incident->status,
            'title' => $incident->title,
        ]);

        return back()->with('status', 'Estado de la incidencia actualizado.');
    }
}