<x-filament-panels::page>
    <form wire:submit="guardar">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button type="submit" class="mt-4">
                Probar formulario
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>