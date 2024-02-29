<?php

namespace App\Livewire;

use App\Models\Material;
use App\Models\Transaction;
use App\Notifications\OfferCreated;
use App\Notifications\SendPushNotification;
use Livewire\Component;

class CreatePriceOffer extends Component
{
    public $id;
    public $date;
    public float $amount;
    public float $total_amount;
    public $material_id;
    public $client_name;
    public $client_national_id;
    public $client_phone;
    public float $price;
    public float $quantity;
    public $modalFormVisible = false;
    public function mount()
    {
        $latest_transaction = Transaction::orderBy('id', 'DESC')->first();
        $this->id = $latest_transaction ? ($latest_transaction->id + 1) : 1;
        $this->date = date('d-m-Y');
    }
    public function rules()
    {
        return [
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'material_id' => 'required|exists:materials,id',
            'client_name' => 'required|string',
            'client_national_id' => 'required|numeric|digits:12',
            'client_phone' => 'required|numeric|digits:8',
        ];
    }
    public function messages()
    {
        return [
            'date.required' => __('The Date cannot be empty.'),
            'amount.required' => __('The Amount cannot be empty.'),
            'client_name.required' => __('The Client Name cannot be empty.'),
            'client_national_id.required' => __('The Client National Id cannot be empty.'),
            'client_phone.required' => __('The Client Phone cannot be empty.'),
            'client_national_id.numeric' => __('The Client National Id must be a number.'),
            'client_national_id.digits' => __('The Client National Id must contain 12 digits.'),
            // 'client_national_id.unique' => __('The Client National Id has been taken.'),
            'client_phone.numeric' => __('The Client Phone must be a number.'),
            'client_phone.digits' => __('The Client Phone must contain 8 digits.'),
        ];
    }
    public function create()
    {
        $validated_data = $this->validate();
        $validated_data['quantity'] = $this->quantity;
        $date_format = \DateTime::createFromFormat('d-m-Y', $validated_data['date']);
        $transaction = Transaction::create([
            'date' => $date_format->format('Y-m-d'),
            'amount' => $validated_data['amount'],
            'material_id' => $validated_data['material_id'],
            'client_name' => $validated_data['client_name'],
            'client_national_id' => $validated_data['client_national_id'],
            'client_phone' => $validated_data['client_phone'],
            'quantity' => $validated_data['quantity'],
        ]);
        $users = $transaction->branch->users;
//        foreach ($users as $user) {
//            if ($user->id == $transaction->user_id)
//                $user->notify(new OfferCreated($transaction->id));
//        }
        $this->modalFormVisible = true;
        $this->date = date('d-m-Y');
        $this->amount = 0;
        $this->total_amount = 0;
        $this->material_id = NULL;
        $this->client_name = NULL;
        $this->client_national_id = NULL;
        $this->client_phone = NULL;
        $this->quantity = 0;
        $this->price = 0;
    }
    public function closeModal()
    {
        $latest_transaction = Transaction::orderBy('id', 'DESC')->first();
        $this->id = $latest_transaction ? ($latest_transaction->id + 1) : 1;
        $this->modalFormVisible = false;
    }
    public function proceedToOrder()
    {
        return redirect()->route('transactions.create-buying-order', ['id' => $this->id]);
    }
    public function back()
    {
        return redirect()->route('dashboard');
    }
    public function render()
    {
        $material = Material::find($this->material_id);
        if ($material) {
            $this->price = $material->unit_price;
            $this->quantity = $this->amount / $this->price;
            $this->total_amount = ($this->amount == 0) ? 0 : $this->amount + config('settings.commission');
        }
        // auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));
        return view('livewire.create-price-offer')->withMaterials(Material::all());
    }
}
