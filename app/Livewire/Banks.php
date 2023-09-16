<?php

namespace App\Livewire;

use App\Models\Bank;
use Livewire\Component;
use Livewire\WithPagination;

class Banks extends Component
{
    use WithPagination;
    public $name;
    public $modalFormVisible = false;
    public function read()
    {
        return Bank::paginate(10);
    }
    public function createShowModal()
    {
        $this->modalFormVisible = true;
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
        $user = Bank::create([
            'name' => $validated_data['name'],
        ]);
        $this->modalFormVisible = false;
        $this->name = NULL;
    }
    public function render()
    {
        return view('livewire.banks', [
            'data' => $this->read()
        ]);
    }
}
