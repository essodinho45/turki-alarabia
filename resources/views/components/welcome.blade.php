<div class="p-6 lg:p-8">
    <div class="grid grid-cols-4 gap-4">
        <a @can('create offer')href="{{ route('transactions.create-price-offer') }}"@endcan>
            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/offer_c.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700" @cannot('create offer')style="cursor: default"@endcannot>
                        {{ __('Create Price Offer') }}
                    </h1>
                </div>
            </div>
        </a>
        <a @can('create order')href="{{ route('transactions.create-buying-order') }}"@endcan>
            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/order_c.png') }}" alt="" />
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
                <img src="{{ asset('images/offer_v.png') }}" alt="" />
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
                <img src="{{ asset('images/print.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Print Transactions') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="{{ route('transactions.index', 'order') }}">
            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/approval_v.png') }}" alt="" />
                <div class="item-body px-2">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Transactions To Approve') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="{{ route('transactions.index', 'approved_by_manager') }}">
            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/agent_v.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Transactions To Approve By Agent') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="{{ route('transactions.index', 'approved_by_bank') }}">
            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/waiting_v.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Transactions In Progress') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="{{ route('transactions.index', 'done') }}">
            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/done_v.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Completed Transactions') }}
                    </h1>
                </div>
            </div>
        </a>
    </div>
</div>
