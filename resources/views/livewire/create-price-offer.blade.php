<div class="p-6">
    <div>
        <x-label for="id" value="{{ __('ID') }}" />
        <x-input id="id" type="text" class="mt-1 block w-full" wire:model.debounce.800ms="id" disabled />
    </div>
    <div class="mt-4">
        <x-label for="date" value="{{ __('Date') }}" />
        <x-input id="date" type="date" class="mt-1 block w-full" wire:model.debounce.800ms="date" />
        @error('date')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="mt-4">
        <x-label for="amount" value="{{ __('Amount') }}" />
        <div class="relative mb-4 flex flex-wrap items-stretch">
            <x-input id="amount" type="number" class="mt-1 block w-full" wire:model.debounce.800ms="amount" />
            <span
                class="flex items-center whitespace-nowrap rounded-l border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-[1.6] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">{{ __('KWD') }}</span>
        </div>
        @error('amount')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="mt-4">
        <x-label for="material_id" value="{{ __('Material') }}" />
        <select name="material_id" wire:model="material_id" wire:change="$refresh"
            class="rounded border-gray-300 shadow-sm p-2 bg-white w-full focus:ring-indigo-800 focus:border-indigo-800">
            <option value='' wire:key="material_00">{{ __('Choose material') }}</option>
            @foreach ($materials as $material)
                <option value={{ $material->id }} wire:key="material_{{ $material->id }}">{{ $material->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mt-4">
        <x-label for="price" value="{{ __('Price') }}" />
        <div class="relative mb-4 flex flex-wrap items-stretch">
            <x-input id="price" type="number" class="mt-1 block w-full" wire:model.debounce.800ms="price"
                disabled />
            <span
                class="flex items-center whitespace-nowrap rounded-l border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-[1.6] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">{{ __('KWD') }}</span>
        </div>
    </div>
    <div class="mt-4">
        <x-label for="quantity" value="{{ __('Quantity') }}" />
        <x-input id="quantity" type="number" class="mt-1 block w-full" wire:model.debounce.800ms="quantity"
            disabled />
    </div>
    <hr>
    <div class="mt-4">
        <x-label for="client_name" value="{{ __('Client Name') }}" />
        <x-input id="client_name" type="text" class="mt-1 block w-full" wire:model.debounce.800ms="client_name" />
        @error('client_name')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="mt-4">
        <x-label for="client_national_id" value="{{ __('Client National Id') }}" />
        <x-input id="client_national_id" type="text" class="mt-1 block w-full"
            wire:model.debounce.800ms="client_national_id" />
        @error('client_national_id')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="mt-4">
        <x-label for="client_phone" value="{{ __('Client Phone') }}" />
        <x-input id="client_phone" type="text" class="mt-1 block w-full" wire:model.debounce.800ms="client_phone" />
        @error('client_phone')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="flex mt-4 justify-end">
        <x-secondary-button wire:click="back" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-button class="@if (\App::isLocale('ar')) mr-3 @else ml-3 @endif" wire:click="create"
            wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-button>
    </div>
</div>
