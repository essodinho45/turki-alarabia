<?php

namespace App\Livewire;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Carbon\Carbon;

class IndexTransactions extends Component
{
    use WithPagination;
    public $status;
    public function read()
    {
        $transactions = Transaction::query();
        if (auth()->user()->branch_id) {
            $users = Branch::find(auth()->user()->branch_id)->users()->pluck('id');
            $transactions = $transactions->whereIn('user_id', $users);
        }
        if ($this->status == 'print')
            return $transactions->paginate(10);
        return $transactions->where('status', $this->status)
            ->whereDate('created_at', '>=', Carbon::now()->StartOfDay())
            ->paginate(10);
    }
    public function approve($id)
    {
        $current = Transaction::find($id);
        $current->status = 'approved_by_bank';
        $current->save();
    }
    public function approveByManager($id)
    {
        $current = Transaction::find($id);
        $current->status = 'approved_by_manager';
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
