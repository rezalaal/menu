<div>
    <div>
        <input type="file" wire:model.live="photo" accept="image/png,image/jpeg">
        @if($photo)
            <img src="{{ $photo->temporaryUrl() }}" class="h-40 rounded-lg">
        @else
            <img src="{{ $user->avatar ?? asset('images/avatar.png') }}" class="h-40 rounded-lg">
        @endif
    </div>

</div>
