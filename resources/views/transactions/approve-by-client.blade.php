<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('postClientApprove', ['id' => $id, 'code' => $code]) }}">
            @csrf

            <div>
                <x-label for="code" value="{{ __('Code') }}" />
                <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required
                         autofocus />
            </div>

        </form>
    </x-authentication-card>
</x-guest-layout>
