@props(['variant' => 'light', 'type' => 'button'])

<button type="{{ $type }}" {{ $attributes->class(['rd-btn', 'rd-btn--'.$variant]) }}>
    {{ $slot }}
</button>
