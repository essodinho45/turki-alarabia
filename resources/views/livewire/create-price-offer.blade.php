<div>
    <div class="relative flex items-center">
        <span class="flex-shrink mx-4 text-blue-700">معلومات العرض</span>
        <div class="flex-grow border-t border-blue-700"></div>
    </div>

    <div class="flex items-center gap-x-2">
        <x-label for="id" value="{{ __('ID') }}" class="basis-1/4 text-lg flex justify-end" />
        <x-input id="id" type="text" class="mt-1 block basis-3/4" value="{{ $id }}" disabled />
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="date" value="{{ __('Date') }}" class="basis-1/4 text-lg flex justify-end" />
        <div class="mt-1 block basis-3/4">
            <x-date wire:model="date" class="w-full" />
            @error('date')
                <span class="error w-full">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="amount" value="{{ __('Amount') }}" class="basis-1/4 text-lg flex justify-end" />
        <div class="relative flex flex-wrap items-stretch basis-3/4 relative">
            <x-input id="amount" type="number" step='.001'
                class="mt-1 flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border ltr:border-r-0 rtl:border-l-0 h-10 border-grey-light rounded-lg ltr:rounded-r-none rtl:rounded-l-none px-3 relative"
                wire:change="$refresh" wire:model="amount" />
            <span
                class="mt-1 flex items-center leading-normal bg-grey-lighter border-1 ltr:rounded-l-none rtl:rounded-r-none border ltr:border-l-0 rtl:border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 justify-center items-center rounded-lg">{{ __('KWD') }}</span>
            @error('amount')
                <span class="error w-full">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="material_id" value="{{ __('Material') }}" class="basis-1/4 text-lg flex justify-end" />
        <select name="material_id" wire:model="material_id" wire:change="$refresh"
            class="rounded border-gray-300 shadow-sm p-2 bg-white basis-3/4 text-sm focus:ring-indigo-800 focus:border-indigo-800">
            <option hidden selected></option>
            @foreach ($materials as $material)
                <option value={{ $material->id }} wire:key="material_{{ $material->id }}">{{ $material->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="price" value="{{ __('Price') }}" class="basis-1/4 text-lg flex justify-end" />
        <div class="relative flex flex-wrap items-stretch basis-3/4 relative">
            <x-input id="amount" type="text"
                class="mt-1 flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border ltr:border-r-0 rtl:border-l-0 h-10 border-grey-light rounded-lg ltr:rounded-r-none rtl:rounded-l-none px-3 relative"
                value='{{ number_format($price, 3) }}' disabled />
            <span
                class="mt-1 flex items-center leading-normal bg-grey-lighter border-1 ltr:rounded-l-none rtl:rounded-r-none border ltr:border-l-0 rtl:border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 justify-center items-center rounded-lg">{{ __('KWD') }}</span>
        </div>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="quantity" value="{{ __('Quantity') }}" class="basis-1/4 text-lg flex justify-end" />
        <x-input id="quantity" type="text" class="mt-1 block basis-3/4" value='{{ number_format($quantity, 5) }}'
            disabled />
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="total_amount" value="{{ __('Total') }}" class="basis-1/4 text-lg flex justify-end" />
        <div class="relative flex flex-wrap items-stretch basis-3/4 relative">
            <x-input id="total_amount" type="text"
                class="mt-1 flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border ltr:border-r-0 rtl:border-l-0 h-10 border-grey-light rounded-lg ltr:rounded-r-none rtl:rounded-l-none px-3 relative"
                value='{{ number_format($total_amount, 3) }}' disabled />
            <span
                class="mt-1 flex items-center leading-normal bg-grey-lighter border-1 ltr:rounded-l-none rtl:rounded-r-none border ltr:border-l-0 rtl:border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 justify-center items-center rounded-lg">{{ __('KWD') }}</span>
        </div>
    </div>
    <div class="relative flex items-center mt-1">
        <span class="flex-shrink mx-4 text-blue-700">معلومات العميل</span>
        <div class="flex-grow border-t border-blue-700"></div>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="client_name" value="{{ __('Client Name') }}" class="basis-1/4 text-lg flex justify-end" />
        <div class="mt-1 block basis-3/4">
            <x-input id="client_name" type="text" class="w-full" wire:model="client_name" />
            @error('client_name')
                <span class="error w-full">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="client_national_id" value="{{ __('Client National Id') }}"
            class="basis-1/4 text-lg flex justify-end" />
        <div class="mt-1 block basis-3/4">
            <x-input id="client_national_id" type="text" class="w-full" wire:model="client_national_id" />
            @error('client_national_id')
                <span class="error w-full">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="client_phone" value="{{ __('Client Phone') }}" class="basis-1/4 text-lg flex justify-end" />
        <div class="mt-1 block basis-3/4">
            <x-input id="client_phone" type="text" class="w-full" wire:model="client_phone" />
            @error('client_phone')
                <span class="error w-full">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="flex mt-2 justify-end">
        <x-secondary-button wire:click="back" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-button class="@if (\App::isLocale('ar')) mr-3 @else ml-3 @endif" wire:click="create"
            wire:loading.attr="disabled">
            {{ __('Order Price Offer') }}
        </x-button>
    </div>

    <x-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Price Offer') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                {{ __('Price offer created with number:') }}&nbsp;{{ $id }}
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-secondary-button>

            <x-button class="rtl:mr-3 ltr:ml-3" wire:click="proceedToOrder" wire:loading.attr="disabled">
                {{ __('Proceed to Buying Order') }}
            </x-button>

            <a href="{{ route('transactions.printOffer', ['transaction' => $id]) }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 rtl:mr-3 ltr:ml-3">
                {{ __('Print') }}
            </a>
        </x-slot>
    </x-dialog-modal>
</div>
