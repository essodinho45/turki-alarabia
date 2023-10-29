<div class="p-6">
    <div class="flex items-center justify-between px-4 py-3 text-right sm:px-6">
        <x-button wire:click="createShowModal">
            {{ __('Create') }}
        </x-button>
    </div>
    <table class="w-full divide-y divide-gray-200">
        <thead class="bg-white border-b">
            <tr>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    #</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Name') }}</th>
                {{-- <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Roles') }}</th> --}}

                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-left ltr:text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                </th>
            </tr>
        </thead>
        <tbody class="devide-y devide-gray-200">
            @if ($data->count())
                @foreach ($data as $bank)
                    <tr>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $bank->id }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $bank->name }}</td>
                        <td class="px-6 py-4 text-sm text-right">
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
    <x-dialog-modal wire:model.live="modalFormVisible">
        <x-slot name="title">
            {{ __('Save Bank') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.live.debounce.800ms="name" />
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="rtl:mr-3 ltr:ml-3" wire:click="create" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
