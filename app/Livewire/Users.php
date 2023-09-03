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
    public $bank;
    public $branch_id;
    public $branches = [];
    public $modalFormVisible = false;
    public $show_branch = false;

    public function read()
    {
        return User::paginate(10);
    }
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
            'bank' => 'sometimes|exists:banks,id',
            'branch_id' => 'sometimes|exists:branches,id',
        ];
    }
    public function create()
    {
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
        $this->bank = NULL;
        $this->branch_id = NULL;
    }
    public function render()
    {
        if (!empty($this->bank)) {
            $this->branches = Branch::where('bank_id', $this->bank)->get();
        }
        return view('livewire.users', [
            'data' => $this->read()
        ])->withRoles(Role::all())->withBanks(Bank::all());
    }
}