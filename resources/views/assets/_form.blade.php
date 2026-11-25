<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="name" value="Nombre del activo" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $asset->name ?? '')" required placeholder="Ej: PLC Siemens S7-1200" />
        <x-input-error :messages="$errors->get('name')" class="mt-1" />
    </div>

    <div>
        <x-input-label for="type" value="Tipo" />
        <x-text-input id="type" name="type" type="text" class="mt-1 block w-full"
                      :value="old('type', $asset->type ?? '')" required placeholder="PLC, Switch, Router, Servidor..." />
        <x-input-error :messages="$errors->get('type')" class="mt-1" />
    </div>

    <div>
        <x-input-label for="ip_address" value="Dirección IPv4" />
        <x-text-input id="ip_address" name="ip_address" type="text" class="mt-1 block w-full font-mono"
                      :value="old('ip_address', $asset->ip_address ?? '')" required placeholder="192.168.10.25" />
        <x-input-error :messages="$errors->get('ip_address')" class="mt-1" />
    </div>

    <div>
        <x-input-label for="location" value="Ubicación" />
        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                      :value="old('location', $asset->location ?? '')" required placeholder="Planta 1 - Cuadro A" />
        <x-input-error :messages="$errors->get('location')" class="mt-1" />
    </div>

    <div>
        <x-input-label for="firmware_version" value="Versión de firmware (opcional)" />
        <x-text-input id="firmware_version" name="firmware_version" type="text" class="mt-1 block w-full"
                      :value="old('firmware_version', $asset->firmware_version ?? '')" placeholder="v4.5.2" />
        <x-input-error :messages="$errors->get('firmware_version')" class="mt-1" />
    </div>

    <div>
        <x-input-label for="status" value="Estado" />
        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @foreach (['operativo', 'mantenimiento', 'critico', 'baja'] as $state)
                <option value="{{ $state }}" @selected(old('status', $asset->status ?? 'operativo') === $state)>
                    {{ ucfirst($state) }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-1" />
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a href="{{ route('assets.index') }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
</div>