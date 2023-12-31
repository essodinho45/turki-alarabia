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
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Price') }}</th>
                <th
                    class="px-6 py-3 bg-gray-50 rtl:text-right ltr:text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Description') }}</th>
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
                @foreach ($data as $material)
                    <tr>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $material->id }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $material->name }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ number_format($material->unit_price, 3) }}
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $material->description }}
                        </td>
                        <td class="px-6 py-4 text-sm text-right">
                            <x-button wire:click="updateShowModal({{ $material->id }})">
                                {{ __('Update') }}
                            </x-button>
                            @role('Super Admin')
                                <button wire:click="deleteShowModal({{ $material->id }})" @disabled(!$material->transactions->isEmpty())
                                    @class([
                                        'btn',
                                        'text-white',
                                        'bg-red-300' => !$material->transactions->isEmpty(),
                                        'hover:bg-red-300' => !$material->transactions->isEmpty(),
                                        'btn-red' => $material->transactions->isEmpty(),
                                    ])>
                                    {{ __('Delete') }}
                                </button>
                            @endrole
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
    <x-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Save Material') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="unit_price" value="{{ __('Price') }}" />
                <x-input id="unit_price" type="number" class="mt-1 block w-full" step=".001"
                    wire:model="unit_price" />
                @error('unit_price')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="description" value="{{ __('Description') }}" />
                <textarea
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none"
                    id="description" wire:model="description"></textarea>
                @error('description')
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
    <x-dialog-modal wire:model="updateFormVisible">
        <x-slot name="title">
            {{ __('Save Material') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="update_name" value="{{ __('Name') }}" />
                <x-input id="update_name" type="text" class="mt-1 block w-full" wire:model="update_name" />
                @error('update_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="update_unit_price" value="{{ __('Price') }}" />
                <x-input id="update_unit_price" type="number" class="mt-1 block w-full" step=".001"
                    wire:model="update_unit_price" />
                @error('update_unit_price')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="update_description" value="{{ __('Description') }}" />
                <textarea
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none"
                    id="update_description" wire:model="update_description">{{ $update_description }}</textarea>
                @error('update_description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('updateFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="rtl:mr-3 ltr:ml-3" wire:click="update" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model="deleteFormVisible">
        <x-slot name="title">
            {{ __('Delete Material') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                {{ __('Are you sure you want to delete') . __(' material: ') . ($modelToDelete->name ?? '') . __(' ?') }}
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('deleteFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="btn-red rtl:mr-3 ltr:ml-3" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Confirm') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
