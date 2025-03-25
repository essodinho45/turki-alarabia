<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Notifications\ApprovedByClient;
use Illuminate\Notifications\DatabaseNotification;

class ViewTransaction extends Component
{
    public $id;
    public $transaction;
    public $choice;
    public $modalFormVisible;
    public function mount()
    {
        if ($this->id)
            $this->transaction = Transaction::find($this->id);
        $this->modalFormVisible = false;
        $this->choice = 'sell';
    }
    public function submit()
    {
        if ($this->transaction) {
            $this->transaction->status = 'approved_by_client';
            $this->transaction->save();
        }
        $users = $this->transaction->branch->users;
        foreach ($users as $user) {
            if ($user->hasRole('Manager'))
                $user->notify(new ApprovedByClient($this->transaction->id));
        }
        // DatabaseNotification::where([
        //     ['type', ApproveByClient::class],
        //     ['data->transaction_id', $this->transaction->id],
        //     ['read_at', NULL],
        // ])->update(['read_at' => now()]);
        $this->modalFormVisible = true;
        $this->transaction = NULL;
    }
    public function closeModal()
    {
        $this->modalFormVisible = false;
    }
    public function render()
    {
        return view('livewire.view-transaction');
    }
}
