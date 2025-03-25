<div class="w-full columns-1">
    <div class="relative flex items-center text-center mb-8">
        {{ __('عزيزي العميل، شكراً لتعاملكم معنا، لديكم سلعة بالمواصفات التالية.') }}
        <br>
        {{ __('Dear customer, Thank you for dealing with us, you have a commodity with the following specifications.') }}
        <div class="flex-grow border-t border-blue-700"></div>
    </div>
    <div class="flex items-center gap-x-2">
        <x-label for="id" value="{{ __('ID') }}" class="basis-1/4 text-lg flex justify-end" />
        <x-input id="id" type="text" class="mt-1 block basis-3/4" wire:model="id" disabled />
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="date" value="{{ __('Date') }}" class="basis-1/4 text-lg flex justify-end" />
        <x-input id="date" type="text" class="mt-1 block basis-3/4"
            value="{{ $transaction ? date('d-m-Y', strtotime($transaction->date)) : '' }}" disabled />
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="amount" value="{{ __('Amount') }}" class="basis-1/4 text-lg flex justify-end" />
        <div class="relative flex flex-wrap items-stretch basis-3/4 relative">
            <x-input id="amount" type="text"
                class="mt-1 flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border ltr:border-r-0 rtl:border-l-0 h-10 border-grey-light rounded-lg ltr:rounded-r-none rtl:rounded-l-none px-3 relative"
                disabled value="{{ $transaction ? number_format($transaction->amount, 3) : '' }}" />
            <span
                class="mt-1 flex items-center leading-normal bg-grey-lighter border-1 ltr:rounded-l-none rtl:rounded-r-none border ltr:border-l-0 rtl:border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 justify-center items-center rounded-lg">{{ __('KWD') }}</span>
        </div>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="material" value="{{ __('Material') }}" class="basis-1/4 text-lg flex justify-end" />
        <x-input id="material" type="text" class="mt-1 block basis-3/4"
            value="{{ $transaction->material->name ?? '' }}" disabled />
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="price" value="{{ __('Price') }}" class="basis-1/4 text-lg flex justify-end" />
        <div class="relative mb-4 flex flex-wrap items-stretch basis-3/4 relative">
            <x-input id="amount" type="text"
                class="mt-1 flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border ltr:border-r-0 rtl:border-l-0 h-10 border-grey-light rounded-lg ltr:rounded-r-none rtl:rounded-l-none px-3 relative"
                value="{{ $transaction ? number_format($transaction->material->unit_price, 3) : '' }}" disabled />
            <span
                class="mt-1 flex items-center leading-normal bg-grey-lighter border-1 ltr:rounded-l-none rtl:rounded-r-none border ltr:border-l-0 rtl:border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 justify-center items-center rounded-lg">{{ __('KWD') }}</span>
        </div>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="quantity" value="{{ __('Quantity') }}" class="basis-1/4 text-lg flex justify-end" />
        <x-input id="quantity" type="text" class="mt-1 block basis-3/4"
            value="{{ $transaction ? number_format($transaction->amount / $transaction->material->unit_price, 5) : '' }}"
            disabled />
    </div>
    <div class="relative flex items-center mt-1">
        <span class="flex-shrink mx-4 text-blue-700">معلومات العميل</span>
        <div class="flex-grow border-t border-blue-700"></div>
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="client_name" value="{{ __('Client Name') }}" class="basis-1/4 text-lg flex justify-end" />
        <x-input id="client_name" type="text" class="mt-1 block basis-3/4"
            value="{{ $transaction->client_name ?? '' }}" disabled />
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="client_national_id" value="{{ __('Client National Id') }}"
            class="basis-1/4 text-lg flex justify-end" />
        <x-input id="client_national_id" type="text" class="mt-1 block basis-3/4"
            value="{{ $transaction->client_national_id ?? '' }}" disabled />
    </div>
    <div class="mt-1 flex items-center gap-x-2">
        <x-label for="client_phone" value="{{ __('Client Phone') }}" class="basis-1/4 text-lg flex justify-end" />
        <x-input id="client_phone" type="text" class="mt-1 block basis-3/4"
            value="{{ $transaction->client_phone ?? '' }}" disabled />
    </div>
    <div class="relative flex items-center text-center mb-4 mt-8">
        {{ __('الرجاء اختيار أحد الخيارات التالية.') }}
        <br>
        {{ __('Please choose one of the following options.') }}
    </div>

    <div class="flex items-center mb-4">
        <input checked id="default-radio-1" type="radio" value="sell" name="default-radio" wire:model="choice"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
        <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900">بيع السلعة /
            Sell
            Commodity</label>
    </div>
    <div class="flex items-center mb-4">
        <input id="default-radio-2" type="radio" value="collect" name="default-radio" wire:model="choice"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
        <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900">استلام
            السلعة،
            توكيل شخص للاستلام، طلب توريد السلعة / Collect, Authorize to collect, Request delivery of the
            commodity</label>
    </div>
    <x-button class="@if (\App::isLocale('ar')) mr-3 @else ml-3 @endif" wire:click="submit"
        wire:loading.attr="disabled">
        Submit/متابعة
    </x-button>
    <x-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                تم استلام طلبك بنجاح، سيقوم فريقنا بتنفيذ طلبك.
                <br>
                Your request has benn succefully received, our team will execute your request.
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                {{ __('Close/إغلاق') }}
            </x-secondary-button>

            {{-- <a href="{{ route('transactions.printOrder', ['transaction' => $id ?? 0]) }}" target="_blank"
            class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 rtl:mr-3 ltr:ml-3">
            {{ __('Print') }}
        </a> --}}
        </x-slot>
    </x-dialog-modal>
</div>
