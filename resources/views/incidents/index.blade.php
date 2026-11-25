<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel Global de Incidencias</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-md text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">
                            <tr>
                                <th class="px-4 py-3">Activo</th>
                                <th class="px-4 py-3">Título</th>
                                <th class="px-4 py-3">Severidad</th>
                                <th class="px-4 py-3">Reportada por</th>
                                <th class="px-4 py-3">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($incidents as $incident)
                                @php
                                    $sevColor = match($incident->severity) {
                                        'baja' => 'bg-blue-100 text-blue-800',
                                        'media' => 'bg-yellow-100 text-yellow-800',
                                        'alta' => 'bg-orange-100 text-orange-800',
                                        'critica' => 'bg-red-100 text-red-800',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium">
                                        <a href="{{ route('assets.show', $incident->asset) }}" class="text-indigo-600 hover:underline">
                                            {{ $incident->asset->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-gray-900">{{ $incident->title }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $sevColor }}">
                                            {{ ucfirst($incident->severity) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $incident->user->name }}</td>
                                    <td class="px-4 py-3">
                                        <form method="POST" action="{{ route('incidents.updateStatus', $incident) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="border-gray-300 rounded-md text-xs">
                                                @foreach (['abierta' => 'Abierta', 'en_proceso' => 'En proceso', 'resuelta' => 'Resuelta'] as $val => $label)
                                                    <option value="{{ $val }}" @selected($incident->status === $val)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-2.5 py-1 bg-gray-800 text-white text-xs rounded-md hover:bg-gray-700">
                                                OK
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                        No hay incidencias registradas. Entra en un activo para crear la primera.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>