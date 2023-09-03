<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class CreateBuyingOrder extends Component
{
    public $id;
    public $transaction;

    public function back()
    {
        return redirect()->back();
    }
    public function create()
    {
        if($this->transaction)
        {
            $this->transaction->update(['status' => 'order']);
        }
        $this->id = NULL;
        $this->transaction = NULL;
    }
    public function render()
    {
        $this->transaction = Transaction::find($this->id);
        return view('livewire.create-buying-order');
    }
}
