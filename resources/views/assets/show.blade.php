<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $asset->name }}</h2>
            <a href="{{ route('assets.index') }}" class="text-sm text-indigo-600 hover:underline">← Volver al inventario</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div><span class="font-semibold text-gray-600">Tipo:</span> {{ $asset->type }}</div>
                <div><span class="font-semibold text-gray-600">IP:</span> <span class="font-mono">{{ $asset->ip_address }}</span></div>
                <div><span class="font-semibold text-gray-600">Ubicación:</span> {{ $asset->location }}</div>
                <div><span class="font-semibold text-gray-600">Firmware:</span> {{ $asset->firmware_version ?? 'No especificado' }}</div>
                <div><span class="font-semibold text-gray-600">Estado:</span> {{ ucfirst($asset->status) }}</div>
                <div><span class="font-semibold text-gray-600">Última actualización:</span> {{ $asset->updated_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-semibold text-gray-800 mb-2">Incidencias asociadas ({{ $asset->incidents->count() }})</h3>
                <p class="text-sm text-gray-500">El módulo de incidencias se conectará aquí en el Día 4.</p>
            </div>
        </div>
    </div>
</x-app-layout>