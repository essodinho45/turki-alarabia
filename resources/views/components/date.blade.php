@props([
    'error' => null,
])

<div x-data="{ value: @entangle($attributes->wire('model')).live }" x-on:change="value = $event.target.value" x-init="new Pikaday({ field: $refs.input, 'format': 'DD-MM-YYYY', firstDay: 1 });">
    <input {{ $attributes->whereDoesntStartWith('wire:model.live') }} x-ref="input" x-bind:value="value"
        type="text"
        class="pl-10 block w-full shadow-sm sm:text-lg bg-gray-50 border-gray-300 focus:ring-primary-500 focus:border-primary-500 rounded-md" />
</div>
