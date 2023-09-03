<div class="p-6">
    <div>
        <x-label for="id" value="{{ __('ID') }}" />
        <x-input id="id" type="text" class="mt-1 block w-full" value="{{ $id }}" disabled />
    </div>
    <div class="mt-4">
        <x-label for="date" value="{{ __('Date') }}" />
        <x-input id="date" type="date" class="mt-1 block w-full" wire:model="date" />
        @error('date')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="mt-4">
        <x-label for="amount" value="{{ __('Amount') }}" />
        <div class="relative mb-4 flex flex-wrap items-stretch w-full relative">
            <x-input id="amount" type="number"
                class="mt-1 flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border border-r-0 h-10 border-grey-light rounded-lg rounded-r-none px-3 relative"
                wire:change="$refresh" wire:model="amount" />
            <span
                class="mt-1 flex items-center leading-normal bg-grey-lighter border-1 rounded-l-none border border-l-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 justify-center items-center rounded-lg">{{ __('KWD') }}</span>
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
        <div class="relative mb-4 flex flex-wrap items-stretch w-full relative">
            <x-input id="amount" type="number"
                class="mt-1 flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border border-r-0 h-10 border-grey-light rounded-lg rounded-r-none px-3 relative"
                wire:model="price" disabled />
            <span
                class="mt-1 flex items-center leading-normal bg-grey-lighter border-1 rounded-l-none border border-l-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 justify-center items-center rounded-lg">{{ __('KWD') }}</span>
        </div>
    </div>
    <div class="mt-4">
        <x-label for="quantity" value="{{ __('Quantity') }}" />
        <x-input id="quantity" type="number" class="mt-1 block w-full" wire:model="quantity" disabled />
    </div>
    <hr class="mt-4">
    <div class="mt-4">
        <x-label for="client_name" value="{{ __('Client Name') }}" />
        <x-input id="client_name" type="text" class="mt-1 block w-full" wire:model="client_name" />
        @error('client_name')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="mt-4">
        <x-label for="client_national_id" value="{{ __('Client National Id') }}" />
        <x-input id="client_national_id" type="text" class="mt-1 block w-full" wire:model="client_national_id" />
        @error('client_national_id')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="mt-4">
        <x-label for="client_phone" value="{{ __('Client Phone') }}" />
        <x-input id="client_phone" type="text" class="mt-1 block w-full" wire:model="client_phone" />
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
