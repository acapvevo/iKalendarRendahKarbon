<div>
    <button {{ $attributes->merge(['class' => 'btn btn-' . $type]) }} {{ $attributes->merge(['type' => 'button']) }}
        wire:click='{{ $target }}'>
        <span wire:loading.remove>{{ $text }}</span>
        <div wire:loading wire:target='{{ $target }}'>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            {{ $text }}
        </div>
    </button>
</div>
