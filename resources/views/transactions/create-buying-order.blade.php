<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row gap-x-16">
                <div class="basis-1/3 flex justify-end">
                    <h2 class="font-semibold text-xl text-blue-700 leading-tight inline">
                        {{ __('Create Buying Order') }}
                    </h2>
                </div>
                <div class="basis-1/3">
                    @livewire('create-buying-order', ['id' => $id])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
