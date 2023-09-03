<?php

namespace App\Livewire;

use App\Models\Material;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class CreatePriceOffer extends Component
{
    public $id;
    public $amount = 0;
    public $material_id;
    public $client_name;
    public $client_national_id;
    public $client_phone;
    public $quantity = 0;

    use WithPagination;
    public function init()
    {
        $latest_transaction = Transaction::orderBy('id', 'DESC')->first();
        $this->id = $latest_transaction ? $latest_transaction->id : 1;
    }
    public function rules()
    {
        return [
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'material_id' => 'required|exists:materials,id',
            'client_name' => 'required|string',
            'client_national_id' => 'required|numeric',
            'client_phone' => 'required|numeric',
        ];
    }
    public function create()
    {
        $validated_data = $this->validate();
        $transaction = Transaction::create([
            'date' => $validated_data['date'],
            'amount' => $validated_data['amount'],
            'material_id' => $validated_data['material_id'],
            'client_name' => $validated_data['client_name'],
            'client_national_id' => $validated_data['client_national_id'],
            'client_phone' => $validated_data['client_phone'],
            'quantity' => $this->quantity,
        ]);
        $this->date = NULL;
        $this->amount = NULL;
        $this->material_id = NULL;
        $this->client_name = NULL;
        $this->client_national_id = NULL;
        $this->client_phone = NULL;
        $this->quantity = NULL;
    }
    public function back()
    {
        return redirect()->back();
    }
    public function render()
    {
        $material = Material::find($this->material_id);
        if ($material) {
            $this->quantitiy = $this->amount / $material->unit_price;
        }
        return view('livewire.create-price-offer')->withMaterials(Material::all());
    }
}