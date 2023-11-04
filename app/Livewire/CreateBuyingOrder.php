<?php

namespace App\Livewire;

use App\Notifications\OrderCreated;
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
        $users = $this->transaction->branch->users;
        foreach ($users as $user) {
            if ($user->id == $this->transaction->user_id || $user->hasRole('Manager'))
                $user->notify(new OrderCreated($this->transaction->id));
        }
        $this->modalFormVisible = true;
        $this->transaction = NULL;
    }
    public function closeModal()
    {
        return redirect()->route('dashboard');
    }
    public function render()
    {
        $this->transaction = Transaction::find($this->id);
        return view('livewire.create-buying-order');
    }
}
