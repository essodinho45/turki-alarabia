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
                    {{ __('Email') }}</th>
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
                @foreach ($data as $user)
                    <tr>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $user->id }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <x-button wire:click="updateShowModal({{ $user->id }})">
                                {{ __('Update') }}
                            </x-button>
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
            {{ __('Save User') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="role_id" value="{{ __('User Type') }}" />
                <select name="role_id" wire:model="role_id" id="role_id" wire:change="$refresh"
                    class="rounded border-gray-300 shadow-sm p-2 bg-white w-full focus:ring-indigo-800 focus:border-indigo-800">
                    <option value='' wire:key="role_00">{{ __('Choose type') }}</option>
                    @foreach ($roles as $role)
                        <option value={{ $role->id }} wire:key="role_{{ $role->id }}">{{ __($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.debounce.800ms="name" />
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" type="email" class="mt-1 block w-full" wire:model.debounce.800ms="email" />
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" type="password" class="mt-1 block w-full"
                    wire:model.debounce.800ms="password" />
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            @if ($role_id == 3 || $role_id == 4)
                <div class="mt-4">
                    <x-label for="bank" value="{{ __('Bank') }}" />
                    <select name="bank" wire:change="$refresh" disabled
                        class="rounded border-gray-300 shadow-sm p-2 bg-white w-full focus:ring-indigo-800 focus:border-indigo-800">
                        @foreach ($banks as $bank)
                            <option value={{ $bank->id }} wire:key="bank_{{ $bank->id }}">{{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <x-label for="branch_id" value="{{ __('Branch') }}" />
                    <select name="branch_id" wire:model="branch_id"
                        class="rounded border-gray-300 shadow-sm p-2 bg-white w-full focus:ring-indigo-800 focus:border-indigo-800">
                        <option value='' wire:key="branch_00">{{ __('Choose branch') }}</option>
                        @foreach ($branches as $branch)
                            <option value={{ $branch->id }} wire:key="branch_{{ $branch->id }}">
                                {{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
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
            {{ __('Save User') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="update_role_id" value="{{ __('User Type') }}" />
                <select name="update_role_id" wire:model="update_role_id" id="update_role_id" wire:change="$refresh"
                    class="rounded border-gray-300 shadow-sm p-2 bg-white w-full focus:ring-indigo-800 focus:border-indigo-800">
                    @foreach ($roles as $role)
                        <option value={{ $role->id }} wire:key="update_role_{{ $role->id }}"
                            @selected($modelToChange ? $role->id == $modelToChange->role_id : false)>
                            {{ __($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4">
                <x-label for="update_name" value="{{ __('Name') }}" />
                <x-input id="update_name" type="text" class="mt-1 block w-full"
                    wire:model.debounce.800ms="update_name" />
                @error('update_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="update_email" value="{{ __('Email') }}" />
                <x-input id="update_email" type="email" class="mt-1 block w-full"
                    wire:model.debounce.800ms="update_email" />
                @error('update_email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="update_password" value="{{ __('Password') }}" />
                <x-input id="update_password" type="password" class="mt-1 block w-full"
                    wire:model.debounce.800ms="update_password" />
                @error('update_password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            @if ($update_role_id == 3 || $update_role_id == 4)
                <div class="mt-4">
                    <x-label for="bank" value="{{ __('Bank') }}" />
                    <select name="bank" wire:change="$refresh" disabled
                        class="rounded border-gray-300 shadow-sm p-2 bg-white w-full focus:ring-indigo-800 focus:border-indigo-800">
                        @foreach ($banks as $bank)
                            <option value={{ $bank->id }} wire:key="bank_{{ $bank->id }}">
                                {{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <x-label for="update_branch_id" value="{{ __('Branch') }}" />
                    <select name="update_branch_id" wire:model="update_branch_id"
                        class="rounded border-gray-300 shadow-sm p-2 bg-white w-full focus:ring-indigo-800 focus:border-indigo-800">
                        <option value='' wire:key="update_branch_00">{{ __('Choose branch') }}</option>
                        @foreach ($branches as $branch)
                            <option value={{ $branch->id }} wire:key="update_branch_{{ $branch->id }}"
                                @selected($modelToChange ? $role->id == $modelToChange->branch_id : false)>
                                {{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
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
</div>
