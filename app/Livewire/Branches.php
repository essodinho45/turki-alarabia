<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;

class Branches extends Component
{
    use WithPagination;
    public $name;
    public $bank_id;
    public $modalFormVisible = false;

    public function read()
    {
        return Branch::with(['bank'])->paginate(10);
    }
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }
    public function rules()
    {
        return [
            'name' => 'required',
            'bank_id' => 'required|exists:banks,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('The Name cannot be empty.'),
            'bank_id.required' => __('The Bank cannot be empty.'),
            'bank_id.exists' => __('The Bank must be valid.'),
        ];
    }
    public function create()
    {
        $validated_data = $this->validate();
        $user = Branch::create([
            'name' => $validated_data['name'],
            'bank_id' => $validated_data['bank_id'],
        ]);
        $this->modalFormVisible = false;
        $this->name = NULL;
        $this->bank_id = NULL;
    }
    public function render()
    {
        return view('livewire.branches', [
            'data' => $this->read()
        ])->withBanks(Bank::all());
    }
}