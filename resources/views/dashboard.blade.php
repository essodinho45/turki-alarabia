<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden sm:rounded-lg">
                <x-welcome :notifications="$notifications"/>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        setTimeout(function(){
            window.location.reload();
        }, 5000);
    });
</script>
