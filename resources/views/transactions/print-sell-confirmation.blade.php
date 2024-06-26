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
        <div class="flex justify-center mb-8">
            <p class="w-1/3 text-center">
                تأكيد بيع العميل
            </p>
        </div>
        <div class="flex justify-center">
            <table class="w-full table-auto">
                <tbody class="text-gray-600 text-sm">
                    <tr class="border border-gray-200">
                        <td class="py-2 px-6 text-right whitespace-nowrap border w-1/4">{{ __('Date') }}</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border w-3/4">{{ date('Y/m/d') }}</td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-2 px-6 text-right whitespace-nowrap border w-1/4">الوقت</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border w-3/4">{{ date('H:i:s') }}</td>
                    </tr>
                    <tr class="border border-gray-200">
                        <td class="py-2 px-6 text-right whitespace-nowrap border w-1/4">من</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border w-3/4">شركة تركي العربية للتجارة العامة
                        </td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-2 px-6 text-right whitespace-nowrap border w-1/4">إلى</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border w-3/4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center my-3">
            <p class="w-full text-right">
                تحية طيبة وبعد..
                <br>
                اشارة الى الموضوع الموضح اعلاه و الى اتفاقية تداول السلع الدولية الموقعة معكم بتاريخ 11-03-2019م
                وبناءعلى طلبكم باتمام عملية بيع السلع، نحيطكم علما بأننا قمنا ببيع السلع المذكورة أدناه وفقا للشروط و
                الأحكام الاتية:
            </p>
        </div>
        <div class="flex justify-center">
            <table class="w-full table-auto">
                <tbody class="text-gray-600 text-sm">
                    <tr class="border border-gray-200">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">مرجع الصفقة</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">{{ $transaction->id }}</td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">تاريخ تنفيذ البيع</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            {{ date('Y/m/d', strtotime($transaction->date)) }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">من حساب</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            {{ date('Y/m/d', strtotime($transaction->date)) }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">إلى حساب</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            {{ $transaction->user->bank->name ?? '' }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">نوع السلعة</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            {{ $transaction->material->name }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">وصف السلعة</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            {{ $transaction->material->description }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">سعر الشراء</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            {{ number_format($transaction->material->unit_price, 3) }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">الكمية</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            {{ number_format($transaction->quantity, 5) }}
                        </td>
                    </tr>
                    <tr class="border border-gray-200">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">المبلغ الإجمالي</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            {{ number_format($transaction->amount, 3) }}
                        </td>
                    </tr>
                    {{-- <tr class="border border-gray-200 bg-gray-100">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">رسوم العملية</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            {{ number_format(50, 3) }}</td>
                    </tr> --}}
                    {{-- <tr class="border border-gray-200">
                        <td class="py-2 px-6 text-right whitespace-nowrap border">تعليمات الدفع</td>
                        <td class="py-2 px-6 text-right whitespace-nowrap border">
                            يتم قيد المبلغ المستحق على الصفقة في حساب التسوية الخاص
                            بنا لديكم
                        </td>
                    </tr> --}}
                </tbody>
            </table>
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
