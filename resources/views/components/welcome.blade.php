<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <div class="grid grid-cols-4 gap-4">
        <a href="{{ route('transactions.create-price-offer') }}">
            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/offer_c.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Create Price Offer') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="#">
            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/order_c.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Create Buying Order') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="#">

            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/offer_v.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('View Price Offers') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="#">

            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/order_v.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('View Buying Orders') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="#">

            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/approval_v.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Transactions To Approve') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="#">
            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/agent_v.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Transactions To Approve By Agent') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="#">

            <div class="content flex py-2 items-center">
                <img src="{{ asset('images/waiting_v.png') }}" alt="" />
                <div class="item-body px-2 ">
                    <h1 class="font-bold text-xl text-blue-700">
                        {{ __('Transactions In Progress') }}
                    </h1>
                </div>
            </div>
        </a>
        <a href="#">
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
