<button {{ $attributes->merge(['class' => 'btn btn-'.$type]) }} {{ $attributes->merge(['type' => 'button']) }}>
    <span wire:loading.remove>{{ $text }}</span>
    <div wire:loading wire:target="{{ $target }}">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        {{ $loading }}
    </div>
</button>
