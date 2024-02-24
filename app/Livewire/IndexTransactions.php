<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\User;
use App\Notifications\ApprovedByBank;
use App\Notifications\ApprovedByManager;
use App\Notifications\CanceledByBank;
use App\Notifications\CanceledByManager;
use App\Notifications\OrderCreated;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Carbon\Carbon;

class IndexTransactions extends Component
{
    use WithPagination;
    public $status;
    public function mount()
    {
        switch ($this->status) {
            // case 'order':
            //     auth()->user()->unreadNotifications()->whereIn('type', [OrderCreated::class, CanceledByBank::class])->update(['read_at' => now()]);
            //     break;
            // case 'approved_by_manager':
            //     auth()->user()->unreadNotifications()->where('type', ApprovedByManager::class)->update(['read_at' => now()]);
            //     break;
            // case 'approved_by_bank':
            //     auth()->user()->unreadNotifications()->whereIn('type', [ApprovedByBank::class, CanceledByManager::class])->update(['read_at' => now()]);
            //     break;
            // default:
            //     break;
        }
    }
    public function read()
    {
        $user = auth()->user();
        $transactions = Transaction::query();
        if ($user->branch_id) {
            $transactions = $transactions->where('branch_id', $user->branch_id);
        }
        if ($this->status == 'print')
            return $transactions->paginate(10);
        elseif ($this->status == 'to_approve') {
            if ($user->hasRole('Manager'))
                $transactions->where('status', 'waiting_manager_approval');
            elseif ($user->hasRole('Bank Employee'))
                $transactions->where('status', 'approved_by_manager')
                    ->where('user_id', $user->id);
        } elseif ($this->status == 'in_progress') {
            if ($user->hasRole('Company Employee'))
                $transactions->where('status', 'waiting_turki_approval');
            elseif ($user->hasRole('Bank Employee'))
                $transactions->where('status', 'approved_by_turki')
                    ->where('user_id', $user->id);
        } elseif ($this->status == 'to_approve_by_agent') {
            if ($user->hasRole('Bank Employee'))
                $transactions->where('status', 'waiting_client_approval')
                    ->where('user_id', $user->id);
        } elseif ($this->status == 'completed') {
            if ($user->hasRole('Company Employee'))
                $transactions->where('status', 'approved_by_client');
            elseif ($user->hasRole('Bank Employee'))
                $transactions->where('status', 'done')
                    ->where('user_id', $user->id);
        }
        return $transactions
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
        DatabaseNotification::where([
            ['type', OrderCreated::class],
            ['data->transaction_id', $current->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
        return redirect()->route('dashboard');
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
        DatabaseNotification::where([
            ['type', OrderCreated::class],
            ['data->transaction_id', $current->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
        return redirect()->route('dashboard');
    }
    public function approveByManager($id)
    {
        $current = Transaction::find($id);
        $current->status = 'approved_by_manager';
        $current->save();
        $users = $current->branch->users;
        foreach ($users as $user) {
            if ($user->id == $current->user_id || $user->hasRole('Bank Employee'))
                $user->notify(new ApprovedByManager($current->id));
        }
        DatabaseNotification::where([
            ['type', ApprovedByBank::class],
            ['data->transaction_id', $current->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
        return redirect()->route('dashboard');
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
        DatabaseNotification::where([
            ['type', ApprovedByBank::class],
            ['data->transaction_id', $current->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.index-transactions', [
            'data' => $this->read()
        ]);
    }
}
