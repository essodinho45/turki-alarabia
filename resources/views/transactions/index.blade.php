<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @switch($status)
                @case('order')
                    {{ __('Transactions To Approve') }}
                @break

                @case('approved_by_bank')
                    {{ __('Transactions To Approve By Agent') }}
                @break

                @case('approved_by_agent')
                    {{ __('Transactions In Progress') }}
                @break

                @case('done')
                    {{ __('Completed Transactions') }}
                @break

                @case('print')
                    {{ __('Print') }}
                @break

                @default
            @endswitch
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('index-transactions', ['status' => $status])
            </div>
        </div>
    </div>
</x-app-layout>
