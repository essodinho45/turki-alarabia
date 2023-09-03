<div class="p-6">
    <div>
        <x-label for="id" value="{{ __('ID') }}" />
        <x-input id="id" type="text" class="mt-1 block w-full" wire:model="id" wire:change="$refresh" />
    </div>
    <div class="mt-4">
        <x-label for="date" value="{{ __('Date') }}" />
        <x-input id="date" type="date" class="mt-1 block w-full" value="{{ $transaction->date ?? '' }}"
            disabled />
    </div>
    <div class="mt-4">
        <x-label for="amount" value="{{ __('Amount') }}" />
        <div class="relative mb-4 flex flex-wrap items-stretch w-full relative">
            <x-input id="amount" type="number"
                class="mt-1 flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border ltr:border-r-0 rtl:border-l-0 h-10 border-grey-light rounded-lg ltr:rounded-r-none rtl:rounded-l-none px-3 relative"
                disabled value="{{ $transaction->amount ?? '' }}" />
            <span
                class="mt-1 flex items-center leading-normal bg-grey-lighter border-1 ltr:rounded-l-none rtl:rounded-r-none border ltr:border-l-0 rtl:border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 justify-center items-center rounded-lg">{{ __('KWD') }}</span>
        </div>
    </div>
    <div class="mt-4">
        <x-label for="material" value="{{ __('Material') }}" />
        <x-input id="material" type="text" class="mt-1 block w-full"
            value="{{ $transaction->material->name ?? '' }}" disabled />
    </div>
    <div class="mt-4">
        <x-label for="price" value="{{ __('Price') }}" />
        <div class="relative mb-4 flex flex-wrap items-stretch w-full relative">
            <x-input id="amount" type="number"
                class="mt-1 flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border ltr:border-r-0 rtl:border-l-0 h-10 border-grey-light rounded-lg ltr:rounded-r-none rtl:rounded-l-none px-3 relative"
                value="{{ $transaction->material->unit_price ?? '' }}" disabled />
            <span
                class="mt-1 flex items-center leading-normal bg-grey-lighter border-1 ltr:rounded-l-none rtl:rounded-r-none border ltr:border-l-0 rtl:border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 justify-center items-center rounded-lg">{{ __('KWD') }}</span>
        </div>
    </div>
    <div class="mt-4">
        <x-label for="quantity" value="{{ __('Quantity') }}" />
        <x-input id="quantity" type="number" class="mt-1 block w-full"
            value="{{ $transaction ? $transaction->amount / $transaction->material->unit_price : '' }}" disabled />
    </div>
    <hr class="mt-4">
    <div class="mt-4">
        <x-label for="client_name" value="{{ __('Client Name') }}" />
        <x-input id="client_name" type="text" class="mt-1 block w-full"
            value="{{ $transaction->client_name ?? '' }}" disabled />
    </div>
    <div class="mt-4">
        <x-label for="client_national_id" value="{{ __('Client National Id') }}" />
        <x-input id="client_national_id" type="text" class="mt-1 block w-full"
            value="{{ $transaction->client_national_id ?? '' }}" disabled />
    </div>
    <div class="mt-4">
        <x-label for="client_phone" value="{{ __('Client Phone') }}" />
        <x-input id="client_phone" type="text" class="mt-1 block w-full"
            value="{{ $transaction->client_phone ?? '' }}" disabled />
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
