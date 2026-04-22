@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border app-border app-surface focus:border-transparent focus:ring-2 focus-ring rounded-lg shadow-sm']) }}>
