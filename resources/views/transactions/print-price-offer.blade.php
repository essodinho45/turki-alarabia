<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased" dir="rtl">
    <div>
        <div class="flex justify-end">
            <table class="w-1/4 table-auto">
                <tbody class="text-gray-600 text-sm">
                    <tr class="border border-gray-200">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Date') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border">
                            {{ date('Y-m-d', strtotime($transaction->date)) }}</td>
                    </tr>
                    <tr class="border border-gray-200">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Price Offer Id') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ $transaction->id }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-start">
            <div class="w-1/3">
                <p>
                    السادة {{ $transaction->user->branch->bank->name ?? '' }} المحترمين <br>
                    تحية طيبة وبعد
                </p>
            </div>
        </div>
        <div class="flex justify-center mb-8">
            <p class="w-1/3 text-center">
                الموضوع:&nbsp;عرض سعر
            </p>
        </div>
        <div class="flex justify-center">
            <table class="w-full table-auto">
                <tbody class="text-gray-600 text-sm">
                    <tr class="border border-gray-200">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Client Name') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ $transaction->client_name }}</td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Client National Id') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border">
                            {{ $transaction->client_national_id }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Client Phone') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ $transaction->client_phone }}</td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Material') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ $transaction->material->name }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Discription') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border"></td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Unit Price') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border">
                            {{ number_format($transaction->material->unit_price, 3) }}</td>
                    </tr>
                    <tr class="border border-gray-200">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Quantity') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border">
                            {{ number_format($transaction->quantity, 5) }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-3 px-6 text-right whitespace-nowrap border">{{ __('Total Amount') }}</td>
                        <td class="py-3 px-6 text-right whitespace-nowrap border">
                            {{ number_format($transaction->amount + 50, 3) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-end mt-8">
            <p class="w-1/3 text-left">
                توقيع العميل
            </p>
        </div>
        <div class="flex justify-center mt-8">
            <p class="w-1/3 text-center">
                هذا العرض ساري لمدة يوم
            </p>
        </div>
    </div>
    @livewireScripts
</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        window.print();
    });
</script>

</html>
