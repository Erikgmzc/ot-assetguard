<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $asset->name }}</h2>
            <a href="{{ route('assets.index') }}" class="text-sm text-indigo-600 hover:underline">← Volver al inventario</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-md text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div><span class="font-semibold text-gray-600">Tipo:</span> {{ $asset->type }}</div>
                <div><span class="font-semibold text-gray-600">IP:</span> <span class="font-mono">{{ $asset->ip_address }}</span></div>
                <div><span class="font-semibold text-gray-600">Ubicación:</span> {{ $asset->location }}</div>
                <div><span class="font-semibold text-gray-600">Firmware:</span> {{ $asset->firmware_version ?? 'No especificado' }}</div>
                <div><span class="font-semibold text-gray-600">Estado:</span> {{ ucfirst($asset->status) }}</div>
                <div><span class="font-semibold text-gray-600">Última actualización:</span> {{ $asset->updated_at->format('d/m/Y H:i') }}</div>
            </div>

            {{-- Formulario para abrir incidencia --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-semibold text-gray-800 mb-4">Reportar nueva incidencia</h3>
                <form method="POST" action="{{ route('assets.incidents.store', $asset) }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <x-input-label for="title" value="Título" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required
                                          :value="old('title')" placeholder="Ej: Pérdida de paquetes en puerto 2" />
                            <x-input-error :messages="$errors->get('title')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="severity" value="Severidad" />
                            <select id="severity" name="severity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                @foreach (['baja', 'media', 'alta', 'critica'] as $sev)
                                    <option value="{{ $sev }}" @selected(old('severity', 'media') === $sev)>
                                        {{ ucfirst($sev) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="description" value="Descripción técnica" />
                        <textarea id="description" name="description" rows="3" required
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm"
                                  placeholder="Síntomas observados, logs o acciones iniciales...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                    <x-primary-button>Registrar incidencia</x-primary-button>
                </form>
            </div>

            {{-- Listado de incidencias del activo --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg space-y-4">
                <h3 class="font-semibold text-gray-800">Incidencias asociadas ({{ $asset->incidents->count() }})</h3>
                @forelse ($asset->incidents->sortByDesc('created_at') as $incident)
                    <div class="border rounded-md p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-900">{{ $incident->title }}</span>
                                <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700">
                                    {{ strtoupper($incident->severity) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $incident->description }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                Reportada por {{ $incident->user->name }} · {{ $incident->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('incidents.updateStatus', $incident) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="border-gray-300 rounded-md text-xs">
                                @foreach (['abierta' => 'Abierta', 'en_proceso' => 'En proceso', 'resuelta' => 'Resuelta'] as $val => $label)
                                    <option value="{{ $val }}" @selected($incident->status === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-3 py-1.5 bg-gray-800 text-white text-xs rounded-md hover:bg-gray-700">
                                Guardar
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Este activo no tiene incidencias registradas.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>