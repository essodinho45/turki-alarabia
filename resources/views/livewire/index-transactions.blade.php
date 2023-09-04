<div class="p-6">
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
                    {{ __('Employee Name') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Branch') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Amount') }}</th>

                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-left ltr:text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                </th>
            </tr>
        </thead>
        <tbody class="devide-y devide-gray-200">
            @if ($data->count())
                @foreach ($data as $transaction)
                    <tr>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $transaction->id }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $transaction->date }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $transaction->client_name }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $transaction->user->name }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                            {{ $transaction->user->branch ? $transaction->user->branch->bank->name - $transaction->user->branch->name : '' }}
                        </td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $transaction->amount }}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            @switch($status)
                                @case('order')
                                    @can('approve by bank')
                                        <button class="btn btn-blue" wire:click="approveByBank({{ $transaction->id }})">
                                            {{ __('Approve') }}
                                        </button>
                                    @endcan
                                @break

                                @case('approved_by_agent')
                                    @can('approve by manager')
                                        <button class="btn btn-blue" wire:click="approveByManager({{ $transaction->id }})">
                                            {{ __('Approve') }}
                                        </button>
                                        <button class="btn btn-red" wire:click="cancelByManager({{ $transaction->id }})">
                                            {{ __('Cancel') }}
                                        </button>
                                    @endcan
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
    {{ $data->links('vendor.livewire.tailwind') }}

</div>
