<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\User;
use App\Notifications\ApprovedByBank;
use App\Notifications\CanceledByBank;
use App\Notifications\CanceledByManager;
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
            $transactions = $transactions->where('branch_id', auth()->user()->branch_id);
        }
        if ($this->status == 'print')
            return $transactions->paginate(10);
        elseif ($this->status == 'approved_by_bank')
            return $transactions->whereIn('status', [$this->status, 'canceled'])
                ->whereDate('created_at', '>=', Carbon::now()->StartOfDay())
                ->paginate(10);
        return $transactions->where('status', $this->status)
            ->whereDate('created_at', '>=', Carbon::now()->StartOfDay())
            ->paginate(10);
    }
    public function approve($id)
    {
        $current = Transaction::find($id);
        $current->status = 'approved_by_bank';
        $current->save();
        $users = User::role('Company Employee')->orWhere('id', $current->user_id)->get();
        foreach ($users as $user) {
            if ($user->id == $current->user_id || $user->hasRole('Company Employee'))
                $user->notify(new ApprovedByBank($current->id));
        }
    }
    public function cancelByBank($id)
    {
        $current = Transaction::find($id);
        $current->status = 'canceled_by_bank';
        $current->save();
        $users = $current->branch->users;
        foreach ($users as $user) {
            if ($user->id == $current->user_id || $user->hasRole('Bank Employee'))
                $user->notify(new CanceledByBank($current->id));
        }
    }
    public function approveByManager($id)
    {
        $current = Transaction::find($id);
        $current->status = 'approved_by_manager';
        $current->save();
        $users = $current->branch->users;
        foreach ($users as $user) {
            if ($user->id == $current->user_id || $user->hasRole('Bank Employee'))
                $user->notify(new ApprovedByBank($current->id));
        }
    }
    public function cancelByManager($id)
    {
        $current = Transaction::find($id);
        $current->status = 'canceled';
        $current->save();
        $users = $current->branch->users;
        foreach ($users as $user) {
            if ($user->id == $current->user_id || $user->hasRole('Bank Employee'))
                $user->notify(new CanceledByManager($current->id));
        }
    }
    public function render()
    {
        return view('livewire.index-transactions', [
            'data' => $this->read()
        ]);
    }
}
