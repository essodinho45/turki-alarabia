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
    public $update_name;
    public $modalFormVisible = false;
    public $updateFormVisible = false;
    public $modelToChange;

    public function read()
    {
        return Branch::with(['bank'])->paginate(10);
    }
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }
    public function updateShowModal($id)
    {
        $this->modelToChange = Branch::find($id);
        $this->update_name = $this->modelToChange->name;
        $this->updateFormVisible = true;
    }
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('The Name cannot be empty.'),
        ];
    }
    public function create()
    {
        $validated_data = $this->validate();
        $user = Branch::create([
            'name' => $validated_data['name'],
            'bank_id' => Bank::first()->id
        ]);
        $this->modalFormVisible = false;
        $this->name = NULL;
    }
    public function update()
    {
        $validated_data = $this->validate([
            'update_name' => 'required',
        ]);
        $this->modelToChange->update([
            'name' => $validated_data['update_name'],
            'bank_id' => Bank::first()->id
        ]);
        $this->updateFormVisible = false;
        $this->update_name = NULL;
        $this->modelToChange = NULL;
    }
    public function render()
    {
        return view('livewire.branches', [
            'data' => $this->read()
        ])->withBanks(Bank::all());
    }
}
