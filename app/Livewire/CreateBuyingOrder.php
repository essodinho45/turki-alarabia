<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\OfferCreated;
use App\Notifications\OrderCreated;
use Illuminate\Notifications\DatabaseNotification;
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
            $this->transaction->status = 'waiting_manager_approval';
            $this->transaction->save();
        }
        $users = User::where(['branch_id', $this->transaction->branch_id])->get();
        foreach ($users as $user) {
            if($user->hasRole('Manager'))
                $user->notify(new OrderCreated($this->transaction->id));
        }
        DatabaseNotification::where([
            ['type', OfferCreated::class],
            ['data->transaction_id', $this->transaction->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
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
