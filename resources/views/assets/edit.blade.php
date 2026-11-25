<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar activo: {{ $asset->name }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('assets.update', $asset) }}">
                    @csrf
                    @method('PUT')
                    @include('assets._form', ['submitLabel' => 'Actualizar activo'])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>