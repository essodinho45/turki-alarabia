<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\Branch;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    public $name;
    public $email;
    public $password;
    public $role_id;
    public $branch_id;
    public $branches = [];
    public $modalFormVisible = false;
    public $show_branch = false;
    public $updateFormVisible = false;
    public $modelToChange;
    public $update_name;
    public $update_email;
    public $update_password;
    public $update_role_id;
    public $update_branch_id;
    public $deleteFormVisible = false;
    public $modelToDelete;
    public function read()
    {
        return User::paginate(10);
    }
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }
    public function updateShowModal($id)
    {
        $this->modelToChange = User::find($id);
        $this->update_name = $this->modelToChange->name;
        $this->update_email = $this->modelToChange->email;
        $this->update_password = NULL;
        $this->update_role_id = $this->modelToChange->roles[0]->id;
        $this->update_branch_id = $this->modelToChange->branch_id;
        $this->updateFormVisible = true;
    }
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'sometimes',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('The Name cannot be empty.'),
            'email.required' => __('The Email cannot be empty.'),
            'email.email' => __('The Email must be valid.'),
            'email.unique' => __('The Email has been taken.'),
            'password.required' => __('The Password cannot be empty.'),
            'password.min' => __('The Password cannot be less than 8 letters.'),
            'role_id.required' => __('The Role cannot be empty.'),
            'role_id.exists' => __('The Role cannot be empty.'),
        ];
    }
    public function create()
    {
        try {
            $validated_data = $this->validate();
            $user = User::create([
                'name' => $validated_data['name'],
                'email' => $validated_data['email'],
                'password' => bcrypt($validated_data['password']),
                'branch_id' => $validated_data['branch_id'],
            ]);
            $user->assignRole($this->role_id);
            $this->modalFormVisible = false;
            $this->email = NULL;
            $this->name = NULL;
            $this->password = NULL;
            $this->role_id = NULL;
            $this->branch_id = NULL;
        } catch (Throwable $e) {
            dd($e);
        }
    }
    public function update()
    {
        $validated_data = $this->validate([
            'update_name' => 'required',
            'update_email' => 'required',
            'update_password' => 'sometimes|nullable|min:8',
            'update_role_id' => 'required|exists:roles,id',
            'update_branch_id' => 'sometimes',
        ]);
        $this->modelToChange->update([
            'name' => $validated_data['update_name'],
            'email' => $validated_data['update_email'],
            'password' => ($validated_data['update_password'] ? bcrypt($validated_data['update_password']) : $this->modelToChange->password),
            'branch_id' => $validated_data['update_branch_id'],
        ]);
        $this->modelToChange->roles()->detach();
        $this->modelToChange->assignRole($validated_data['update_role_id']);
        $this->updateFormVisible = false;
        $this->update_name = NULL;
        $this->update_email = NULL;
        $this->update_password = NULL;
        $this->update_role_id = NULL;
        $this->update_branch_id = NULL;
        $this->modelToChange = NULL;
    }
    public function deleteShowModal($id)
    {
        $this->modelToDelete = User::find($id);
        $this->deleteFormVisible = true;
    }
    public function delete()
    {
        $this->modelToDelete->delete();
        $this->deleteFormVisible = false;
    }
    public function render()
    {
        $banks = Bank::all();
        $this->branches = Branch::where('bank_id', $banks[0]->id)->get();
        return view('livewire.users', [
            'data' => $this->read()
        ])->withRoles(Role::all())->withBanks($banks);
    }
}
