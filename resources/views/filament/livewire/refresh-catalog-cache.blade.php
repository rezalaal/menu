<div>
    <x-filament::button
        wire:click="refresh"
        wire:loading.attr="disabled"
        wire:target="refresh"
        color="warning"
        icon="heroicon-o-arrow-path"
        size="sm"
    >
        به‌روزرسانی کش
    </x-filament::button>
</div>
