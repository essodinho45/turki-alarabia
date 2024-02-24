<div class="p-6 lg:p-8">
    <div class="grid grid-cols-4 gap-4">
        <a @can('create offer')href="{{ route('transactions.create-price-offer') }}"@endcan>
            <div class="content flex py-2 items-center">
                <img class="welcome-img" src="{{ asset('images/offer_c.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700" @cannot('create offer')style="cursor: default"@endcannot>
                        {{ __('Create Price Offer') }}
                    </h1>
                </div>
            </div>
        </a>
        <a @can('create order')href="{{ route('transactions.create-buying-order') }}"@endcan>
            <div class="content flex py-2 items-center">
                <img class="welcome-img" src="{{ asset('images/order_c.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700"
                        @cannot('create order')style="cursor: default"@endcannot>
                        {{ __('Create Buying Order') }}
                    </h1>
                </div>
            </div>
        </a>
        <a @can('update offer')href="{{ route('transactions.update-price-offer') }}"@endcan>
            <div class="content flex py-2 items-center">
                <img class="welcome-img" src="{{ asset('images/offer_v.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700"
                        @cannot('update offer')style="cursor: default"@endcannot>
                        {{ __('Update Price Offer') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="{{ route('transactions.index', 'print') }}">
            <div class="content flex py-2 items-center">
                <img class="welcome-img" src="{{ asset('images/print.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Print Transactions') }}
                    </h1>
                </div>
            </div>
        </a>
        <a @hasanyrole('Manager|Bank Employee') href="{{ route('transactions.index', 'to_approve') }}" @endhasanyrole>
            <div class="content flex py-2 items-center">
                <div class="relative">
                    <img class="welcome-img" src="{{ asset('images/approval_v.png') }}" alt="" />
                    @if ($notifications['to_approve'] > 0)
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-gray-100 rounded-full -top-0 -left-0">
                            {{ $notifications['to_approve'] }}</div>
                    @endif
                </div>
                <div class="item-body px-2">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Transactions To Approve') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="{{ route('transactions.index', 'to_approve_by_agent') }}">
            <div class="content flex py-2 items-center">
                <div class="relative">
                    <img class="welcome-img" src="{{ asset('images/agent_v.png') }}" alt="" />
                    @if ($notifications['to_approve_by_agent'] > 0)
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-gray-100 rounded-full -top-0 -left-0">
                            {{ $notifications['to_approve_by_agent'] }}</div>
                    @endif
                </div>
                <div class="item-body px-2">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Transactions To Approve By Agent') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="{{ route('transactions.index', 'in_progress') }}">
            <div class="content flex py-2 items-center">
                <div class="relative">
                    <img class="welcome-img" src="{{ asset('images/waiting_v.png') }}" alt="" />
                    @if ($notifications['in_progress'] > 0)
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-gray-100 rounded-full -top-0 -left-0">
                            {{ $notifications['in_progress'] }}</div>
                    @endif
                </div>
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Transactions In Progress') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="{{ route('transactions.index', 'completed') }}">
            <div class="content flex py-2 items-center">
                <div class="relative">
                    <img class="welcome-img" src="{{ asset('images/done_v.png') }}" alt="" />
                    @if ($notifications['completed'] > 0)
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-gray-100 rounded-full -top-0 -left-0">
                            {{ $notifications['completed'] }}</div>
                    @endif
                </div>
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Completed Transactions') }}
                    </h1>
                </div>
            </div>
        </a>
    </div>
</div>
