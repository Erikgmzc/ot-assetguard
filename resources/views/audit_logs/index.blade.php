<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registro de Auditoría (Solo Admin)</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">
                            <tr>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Usuario</th>
                                <th class="px-4 py-3">Acción</th>
                                <th class="px-4 py-3">Objetivo</th>
                                <th class="px-4 py-3">IP Origen</th>
                                <th class="px-4 py-3">Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($logs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ $log->user?->name ?? 'Sistema' }}
                                    </td>
                                    <td class="px-4 py-3 font-mono text-xs text-indigo-700">{{ $log->action }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $log->target_type }} #{{ $log->target_id }}</td>
                                    <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $log->ip_origin }}</td>
                                    <td class="px-4 py-3 font-mono text-xs text-gray-600">
                                        {{ json_encode($log->details, JSON_UNESCAPED_UNICODE) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        Todavía no hay eventos registrados en la auditoría.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $logs->links() }}</div>
        </div>
    </div>
</x-app-layout>