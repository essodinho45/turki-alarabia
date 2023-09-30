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
    public $update_name;
    public $update_unit_price;
    public $modalFormVisible = false;
    public $updateFormVisible = false;
    public $modelToChange;

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
    public function updateShowModal($id)
    {
        $this->modelToChange = Material::find($id);
        $this->update_name = $this->modelToChange->name;
        $this->update_unit_price = $this->modelToChange->unit_price;
        $this->updateFormVisible = true;
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
    public function update()
    {
        $validated_data = $this->validate([
            'update_name' => 'required',
            'update_unit_price' => 'required|numeric',
        ]);
        $this->modelToChange->update([
            'name' => $validated_data['update_name'],
            'unit_price' => $validated_data['update_unit_price']
        ]);
        $this->updateFormVisible = false;
        $this->update_name = NULL;
        $this->update_unit_price = NULL;
        $this->modelToChange = NULL;
    }
    public function render()
    {
        return view('livewire.materials', [
            'data' => $this->read()
        ]);
    }
}