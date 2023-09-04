<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
class IndexTransactions extends Component
{
    use WithPagination;
    public $status;
    public function read()
    {
        return Transaction::where('status', $this->status)->paginate(10);
    }
    public function approveByBank($id)
    {
        $current = Transaction::find($id);
        $current->status = 'approved_by_bank';
        $current->save();
    }
    public function approveByManager($id)
    {
        $current = Transaction::find($id);
        $current->status = 'done';
        $current->save();
    }
    public function cancelByManager($id)
    {
        $current = Transaction::find($id);
        $current->status = 'canceled';
        $current->save();
    }
    public function render()
    {
        return view('livewire.index-transactions', [
            'data' => $this->read()
        ]);
    }
}
