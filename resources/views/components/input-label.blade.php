@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm app-text-muted']) }}>
    {{ $value ?? $slot }}
</label>
