<div wire:poll.5000ms>
    <table class="w-full divide-y divide-gray-200">
        <thead class="bg-white border-b">
            <tr>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('ID') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Date') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Client Name') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Client Phone') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Client National Id') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Employee Name') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Branch') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Amount') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Material') }}</th>

                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-left ltr:text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                </th>
            </tr>
        </thead>
        <tbody class="devide-y devide-gray-200">
            @if ($data->count())
                @foreach ($data as $transaction)
                    <tr @class([
                        'bg-red-100' =>
                            $transaction->status == 'canceled_by_manager' ||
                            $transaction->status == 'canceled_by_bank',
                    ])>
                        <td class="px-6 py-2 text-sm whitespace-no-wrap">{{ $transaction->id }}</td>
                        <td class="px-6 py-2 text-sm whitespace-no-wrap">{{ $transaction->date }}</td>
                        <td class="px-6 py-2 text-sm whitespace-no-wrap">{{ $transaction->client_name }}</td>
                        <td class="px-6 py-2 text-sm whitespace-no-wrap">{{ $transaction->client_phone }}</td>
                        <td class="px-6 py-2 text-sm whitespace-no-wrap">{{ $transaction->client_national_id }}</td>
                        <td class="px-6 py-2 text-sm whitespace-no-wrap">{{ $transaction->user->name }}</td>
                        <td class="px-6 py-2 text-sm whitespace-no-wrap">
                            {{ $transaction->user->branch ? $transaction->user->branch->bank->name . ' - ' . $transaction->user->branch->name : '' }}
                        </td>
                        <td class="px-6 py-2 text-sm whitespace-no-wrap">
                            {{ number_format($transaction->amount + config('settings.commission'), 3) }}
                        </td>
                        <td class="px-6 py-2 text-sm whitespace-no-wrap">
                            {{ $transaction->material->name }}
                        </td>
                        <td class="px-6 py-2 text-sm text-right">
                            @switch($status)
                                @case('print')
                                    <a href="
                                        @if ($transaction->status == 'offer') {{ route('transactions.printOffer', ['transaction' => $transaction->id]) }}
                                        @elseif ($transaction->status == 'order') {{ route('transactions.printOrder', ['transaction' => $transaction->id]) }}
                                        @else # @endif
                                        "
                                        target="_blank"
                                        class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 rtl:mr-3 ltr:ml-3">
                                        {{ __('Print') }}
                                    </a>
                                @break

                                @case('to_approve')
                                    @if ($transaction->status == 'approved_by_manager')
                                        @role('Bank Employee')
                                            <a href="{{ route('transactions.printOrder', ['transaction' => $transaction->id]) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 rtl:mr-3 ltr:ml-3">
                                                {{ __('Print') }}
                                            </a>
                                        @endrole
                                    @elseif($transaction->status == 'waiting_manager_approval')
                                        @role('Manager')
                                            <button class="btn btn-blue" wire:click="approveByManager({{ $transaction->id }})">
                                                {{ __('Approve') }}
                                            </button>
                                            <button class="btn btn-red" wire:click="cancelByManager({{ $transaction->id }})">
                                                {{ __('Refuse') }}
                                            </button>
                                        @endrole
                                    @endif
                                @break

                                @case('in_progress')
                                    @if ($transaction->status == 'waiting_turki_approval')
                                        @role('Company Employee')
                                            <button class="btn btn-blue" wire:click="approveByTurki({{ $transaction->id }})">
                                                {{ __('Approve') }}
                                            </button>
                                        @endrole
                                    @elseif($transaction->status == 'approved_by_turki')
                                        @role('Bank Employee')
                                            <button class="btn btn-blue" wire:click="sendMessage({{ $transaction->id }})">
                                                {{ __('Send Message To Client') }}
                                            </button>
                                        @endrole
                                    @endif
                                @break

                                @case('completed')
                                    @if ($transaction->status == 'approved_by_client')
                                        @role('Company Employee')
                                            <button class="btn btn-blue" wire:click="setAsDone({{ $transaction->id }})">
                                                {{ __('Approve') }}
                                            </button>
                                        @endrole
                                    @endif
                                @break

                                @default
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="px-6 py-4 text-sm text-center" colspan="6">
                        {{ __('No data to show.') }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="p-6">
        {{ $data->links('vendor.livewire.tailwind') }}
    </div>
</div>
