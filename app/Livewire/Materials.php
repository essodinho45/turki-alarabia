<?php

namespace App\Livewire;

use App\Models\Material;
use Livewire\Component;
use Livewire\WithPagination;

class Materials extends Component
{
    use WithPagination;
    public $name;
    public $unit_price;
    public $modalFormVisible = false;

    public function read()
    {
        return Material::paginate(10);
    }
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }
    public function rules()
    {
        return [
            'name' => 'required',
            'unit_price' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('The Name cannot be empty.'),
            'unit_price.required' => __('The Unit Price cannot be empty.'),
            'unit_price.numeric' => __('The Unit Price must be a number.'),
        ];
    }
    public function create()
    {
        $validated_data = $this->validate();
        $user = Material::create([
            'name' => $validated_data['name'],
            'unit_price' => $validated_data['unit_price'],
        ]);
        $this->modalFormVisible = false;
        $this->name = NULL;
        $this->unit_price = NULL;
    }
    public function render()
    {
        return view('livewire.materials', [
            'data' => $this->read()
        ]);
    }
}