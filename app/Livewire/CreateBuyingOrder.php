<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class CreateBuyingOrder extends Component
{
    public $id;
    public $transaction;
    public $modalFormVisible = false;
    public function mount()
    {
        if ($this->id)
            $this->transaction = Transaction::find($this->id);
    }

    public function back()
    {
        return redirect()->route('dashboard');
    }
    public function create()
    {
        if ($this->transaction) {
            $this->transaction->status = 'order';
            $this->transaction->save();
        }
        $this->modalFormVisible = true;
        $this->transaction = NULL;
    }
    public function closeModal()
    {
        $this->id = NULL;
        $this->modalFormVisible = false;
    }
    public function render()
    {
        $this->transaction = Transaction::find($this->id);
        return view('livewire.create-buying-order');
    }
}
