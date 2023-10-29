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
                    {{ __('Bank') }}</th>
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
                @foreach ($data as $branch)
                    <tr>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $branch->id }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $branch->name }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $branch->bank->name }}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <x-button wire:click="updateShowModal({{ $branch->id }})">
                                {{ __('Update') }}
                            </x-button>
                            @role('Super Admin')
                                <button wire:click="deleteShowModal({{ $branch->id }})" @disabled(!($branch->users->isEmpty() && $branch->transactions->isEmpty()))
                                    @class([
                                        'btn',
                                        'text-white',
                                        'bg-red-300' => !(
                                            $branch->users->isEmpty() && $branch->transactions->isEmpty()
                                        ),
                                        'hover:bg-red-300' => !(
                                            $branch->users->isEmpty() && $branch->transactions->isEmpty()
                                        ),
                                        'btn-red' => $branch->users->isEmpty() && $branch->transactions->isEmpty(),
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
            {{ __('Save Branch') }}
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
                <x-label for="bank_id" value="{{ __('Bank') }}" />
                <select name="bank_id"
                    class="rounded border-gray-300 shadow-sm p-2 bg-white w-full focus:ring-indigo-800 focus:border-indigo-800"
                    disabled>
                    @foreach ($banks as $bank)
                        <option value={{ $bank->id }} wire:key="bank_{{ $bank->id }}">{{ $bank->name }}
                        </option>
                    @endforeach
                </select>
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
            {{ __('Save Branch') }}
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
                <x-label for="update_bank_id" value="{{ __('Bank') }}" />
                <select name="update_bank_id"
                    class="rounded border-gray-300 shadow-sm p-2 bg-white w-full focus:ring-indigo-800 focus:border-indigo-800"
                    disabled>
                    @foreach ($banks as $bank)
                        <option value={{ $bank->id }} wire:key="bank_{{ $bank->id }}">
                            {{ $bank->name }}
                        </option>
                    @endforeach
                </select>
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
            {{ __('Delete Branch') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                {{ __('Are you sure you want to delete') . __(' branch: ') . ($modelToDelete->name ?? '') . __(' ?') }}
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
