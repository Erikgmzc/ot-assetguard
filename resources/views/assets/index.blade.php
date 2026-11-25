<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventario de Activos OT / Red
            </h2>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('assets.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                    + Nuevo Activo
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-md text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Barra de filtrado rápido en cliente (JS) --}}
            <div class="bg-white p-4 shadow-sm sm:rounded-lg flex flex-col sm:flex-row gap-3">
                <input id="assetSearch" type="text" placeholder="Buscar por nombre, IP, tipo o ubicación..."
                       class="w-full sm:flex-1 border-gray-300 rounded-md shadow-sm text-sm">
                <select id="statusFilter" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">Todos los estados</option>
                    <option value="operativo">Operativo</option>
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="critico">Crítico</option>
                    <option value="baja">Baja</option>
                </select>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">
                            <tr>
                                <th class="px-4 py-3">Nombre</th>
                                <th class="px-4 py-3">Tipo</th>
                                <th class="px-4 py-3">IP</th>
                                <th class="px-4 py-3">Ubicación</th>
                                <th class="px-4 py-3">Firmware</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="assetsTableBody" class="divide-y divide-gray-200">
                            @forelse ($assets as $asset)
                                @php
                                    $badge = match($asset->status) {
                                        'operativo' => 'bg-green-100 text-green-800',
                                        'mantenimiento' => 'bg-yellow-100 text-yellow-800',
                                        'critico' => 'bg-red-100 text-red-800',
                                        'baja' => 'bg-gray-200 text-gray-700',
                                    };
                                @endphp
                                <tr class="asset-row hover:bg-gray-50"
                                    data-search="{{ strtolower($asset->name . ' ' . $asset->type . ' ' . $asset->ip_address . ' ' . $asset->location) }}"
                                    data-status="{{ $asset->status }}">
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        <a href="{{ route('assets.show', $asset) }}" class="text-indigo-600 hover:underline">
                                            {{ $asset->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $asset->type }}</td>
                                    <td class="px-4 py-3 font-mono text-gray-800">{{ $asset->ip_address }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $asset->location }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $asset->firmware_version ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $badge }}">
                                            {{ ucfirst($asset->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('assets.show', $asset) }}" class="text-gray-600 hover:underline">Ver</a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('assets.edit', $asset) }}" class="text-indigo-600 hover:underline">Editar</a>
                                            <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Seguro que quieres eliminar este activo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        No hay activos registrados todavía.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('assetSearch');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('.asset-row');

        function filterAssets() {
            const term = searchInput.value.toLowerCase().trim();
            const status = statusFilter.value;

            rows.forEach(row => {
                const matchesText = row.dataset.search.includes(term);
                const matchesStatus = !status || row.dataset.status === status;
                row.style.display = (matchesText && matchesStatus) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterAssets);
        statusFilter.addEventListener('change', filterAssets);
    </script>
</x-app-layout>