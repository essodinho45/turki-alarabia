<?php

namespace App\Livewire;

use App\Models\Material;
use App\Models\Transaction;
use Livewire\Component;

class CreatePriceOffer extends Component
{
    public $id;
    public $date;
    public float $amount;
    public $material_id;
    public $client_name;
    public $client_national_id;
    public $client_phone;
    public float $price;
    public float $quantity;

    public function mount()
    {
        $latest_transaction = Transaction::orderBy('id', 'DESC')->first();
        $this->id = $latest_transaction ? ($latest_transaction->id + 1) : 1;
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
        $validated_data['quantity'] = $this->quantity;
        $transaction = Transaction::create([
            'date' => $validated_data['date'],
            'amount' => $validated_data['amount'],
            'material_id' => $validated_data['material_id'],
            'client_name' => $validated_data['client_name'],
            'client_national_id' => $validated_data['client_national_id'],
            'client_phone' => $validated_data['client_phone'],
            'quantity' => $validated_data['quantity'],
        ]);
        $this->date = NULL;
        $this->amount = 0;
        $this->material_id = NULL;
        $this->client_name = NULL;
        $this->client_national_id = NULL;
        $this->client_phone = NULL;
        $this->quantity = 0;
        $this->price = 0;
    }
    public function back()
    {
        return redirect()->back();
    }
    public function render()
    {
        $material = Material::find($this->material_id);
        if ($material) {
            $this->price = $material->unit_price;
            $this->quantity = $this->amount / $this->price;
        }
        return view('livewire.create-price-offer')->withMaterials(Material::all());
    }
}
