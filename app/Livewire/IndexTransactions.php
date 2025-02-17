<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\User;
use App\Notifications\ApprovedByBank;
use App\Notifications\ApprovedByClient;
use App\Notifications\ApprovedByManager;
use App\Notifications\ApprovedByTurki;
use App\Notifications\CanceledByBank;
use App\Notifications\CanceledByManager;
use App\Notifications\MessageSent;
use App\Notifications\OfferCreated;
use App\Notifications\OrderCreated;
use App\Notifications\OrderWaitingTurki;
use App\Notifications\TransactionDone;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Carbon\Carbon;

class IndexTransactions extends Component
{
    use WithPagination;
    public $status;
    public $count;
    public function mount()
    {
        $user = auth()->user();
        switch ($this->status) {
            case 'to_approve':
                if ($user->hasRole('Manager'))
                    $user->unreadNotifications()->whereIn('type', [OrderCreated::class])->update(['read_at' => now()]);
                if ($user->hasRole('Bank Employee'))
                    $user->unreadNotifications()->whereIn('type', [OfferCreated::class, ApprovedByManager::class])->update(['read_at' => now()]);
                break;
            case 'in_progress':
                if ($user->hasRole('Company Employee'))
                    $user->unreadNotifications()->whereIn('type', [ApprovedByBank::class, OrderWaitingTurki::class])->update(['read_at' => now()]);
                if ($user->hasRole('Bank Employee'))
                    $user->unreadNotifications()->whereIn('type', [ApprovedByTurki::class])->update(['read_at' => now()]);
                break;
            case 'to_approve_by_agent':
                if ($user->hasRole('Bank Employee'))
                    $user->unreadNotifications()->whereIn('type', [MessageSent::class])->update(['read_at' => now()]);
                break;
            case 'completed':
                if ($user->hasRole('Company Employee'))
                    $user->unreadNotifications()->whereIn('type', [ApprovedByClient::class])->update(['read_at' => now()]);
                if ($user->hasRole('Bank Employee'))
                    $user->unreadNotifications()->whereIn('type', [TransactionDone::class])->update(['read_at' => now()]);
                break;
            default:
                break;
        }
    }
    public function read()
    {
        $user = auth()->user();
        $transactions = Transaction::query()->whereDate('created_at', '>=', Carbon::now()->StartOfDay());
        if ($user->branch_id) {
            $transactions = $transactions->where('branch_id', $user->branch_id);
        }
        if ($this->status == 'print')
            return $transactions->paginate(10);
        elseif ($this->status == 'to_approve') {
            if ($user->hasRole('Manager'))
                $transactions->where('status', 'waiting_manager_approval');
            elseif ($user->hasRole('Bank Employee'))
                $transactions->whereIn('status', ['approved_by_manager'])
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
        $count = clone $transactions;
        $this->count = $count->count();
        return $transactions->paginate(10);
    }
    public function approveByManager($id)
    {
        $current = Transaction::find($id);
        $current->status = 'approved_by_manager';
        $current->save();
        $users = User::where('id', $current->user_id)->get();
        foreach ($users as $user) {
            if ($user->id == $current->user_id)
                $user->notify(new ApprovedByManager($current->id));
        }
        DatabaseNotification::where([
            ['type', OrderCreated::class],
            ['data->transaction_id', $current->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
        if ($this->count > 1)
            return redirect()->back();
        return redirect()->route('dashboard');
    }
    public function cancelByManager($id)
    {
        $current = Transaction::find($id);
        $current->status = 'canceled_by_manager';
        $current->save();
        $users = User::where('id', $current->user_id)->get();
        foreach ($users as $user) {
            if ($user->id == $current->user_id)
                $user->notify(new CanceledByManager($current->id));
        }
        DatabaseNotification::where([
            ['type', ApprovedByBank::class],
            ['data->transaction_id', $current->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
        if ($this->count > 1)
            return redirect()->back();
        return redirect()->route('dashboard');
    }
    //    public function approveByBank($id)
//    {
//        $current = Transaction::find($id);
//        $current->status = 'waiting_turki_approval';
//        $current->save();
//        $users = User::role('Company Employee')->get();
//        foreach ($users as $user) {
//            $user->notify(new ApprovedByBank($current->id));
//        }
//        DatabaseNotification::where([
//            ['type', ApprovedByManager::class],
//            ['data->transaction_id', $current->id],
//            ['read_at', NULL],
//        ])->update(['read_at' => now()]);
//        return redirect()->route('dashboard');
//    }
//    public function cancelByBank($id)
//    {
//        $current = Transaction::find($id);
//        $current->status = 'canceled_by_bank';
//        $current->save();
//        $users = User::where('id', $current->user_id)->get();
//        foreach ($users as $user) {
//            if ($user->id == $current->user_id)
//                $user->notify(new CanceledByBank($current->id));
//        }
//        DatabaseNotification::where([
//            ['type', ApprovedByManager::class],
//            ['data->transaction_id', $current->id],
//            ['read_at', NULL],
//        ])->update(['read_at' => now()]);
//        return redirect()->route('dashboard');
//    }
    public function approveByTurki($id)
    {
        $current = Transaction::find($id);
        $current->status = 'approved_by_turki';
        $current->save();
        $users = User::where('id', $current->user_id)->get();
        foreach ($users as $user) {
            if ($user->id == $current->user_id)
                $user->notify(new ApprovedByTurki($current->id));
        }
        DatabaseNotification::where([
            ['type', ApprovedByBank::class],
            ['data->transaction_id', $current->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
        if ($this->count > 1)
            return redirect()->back();
        return redirect()->route('dashboard');
    }
    public function sendMessage($id)
    {
        $current = Transaction::find($id);
        $code = rand(1000, 9999);
        $message = "رمز التأكيد الخاص بكم هو: ".$code."\n";
        $message .= "يرجى تأكيد طلبكم لدى تركي العربية عبر إدخال رمز التأكيد على الرابط التالي:\n";
        $message .= env('APP_URL')."/approveTransaction/".$current->id."/".$code;
        $response = Http::get('http://62.215.172.203/knews/easy_api_submit.aspx', [
            'un'    => 'ACC_681-742',
            'pw'     => 'KhAsbVi$MQLScUrt',
            'originator'   => '5475726B69417261626961',
            'mobiles_list'     => $current->client_phone,
            'msg_lang' => 'ar',
            'msg_text' => $this->to_unicode($message)
        ]);
        Log::debug($response);
        $current->status = 'waiting_client_approval';
        $current->save();
        $users = User::role('Company Employee')->get();
        foreach ($users as $user) {
            $user->notify(new MessageSent($current->id));
        }
        DatabaseNotification::where([
            ['type', ApprovedByTurki::class],
            ['data->transaction_id', $current->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
        if ($this->count > 1)
            return redirect()->back();
        return redirect()->route('dashboard');
    }
    public function setAsDone($id)
    {
        $current = Transaction::find($id);
        $current->status = 'done';
        $current->save();
        $users = User::where('id', $current->user_id)->get();
        foreach ($users as $user) {
            if ($user->id == $current->user_id)
                $user->notify(new TransactionDone($current->id));
        }
        DatabaseNotification::where([
            ['type', ApprovedByClient::class],
            ['data->transaction_id', $current->id],
            ['read_at', NULL],
        ])->update(['read_at' => now()]);
        if ($this->count > 1)
            return redirect()->back();
        return redirect()->route('dashboard');
    }
    public function render()
    {
        $data = $this->read();
        return view('livewire.index-transactions', [
            'data' => $data
        ]);
    }
    private function utf8ToUnicode(&$str) {
        $mState = 0;     // cached expected number of octets after the current octet
        // until the beginning of the next UTF8 character sequence
        $mUcs4 = 0;     // cached Unicode character
        $mBytes = 1;     // cached expected number of octets in the current sequence

        $out = array();

        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $in = ord($str[$i]);
            if (0 == $mState) {
                // When mState is zero we expect either a US-ASCII character or a
                // multi-octet sequence.
                if (0 == (0x80 & ($in))) {
                    // US-ASCII, pass straight through.
                    $out[] = $in;
                    $mBytes = 1;
                } else if (0xC0 == (0xE0 & ($in))) {
                    // First octet of 2 octet sequence
                    $mUcs4 = ($in);
                    $mUcs4 = ($mUcs4 & 0x1F) << 6;
                    $mState = 1;
                    $mBytes = 2;
                } else if (0xE0 == (0xF0 & ($in))) {
                    // First octet of 3 octet sequence
                    $mUcs4 = ($in);
                    $mUcs4 = ($mUcs4 & 0x0F) << 12;
                    $mState = 2;
                    $mBytes = 3;
                } else if (0xF0 == (0xF8 & ($in))) {
                    // First octet of 4 octet sequence
                    $mUcs4 = ($in);
                    $mUcs4 = ($mUcs4 & 0x07) << 18;
                    $mState = 3;
                    $mBytes = 4;
                } else if (0xF8 == (0xFC & ($in))) {
                    /* First octet of 5 octet sequence.
                    *
                    * This is illegal because the encoded codepoint must be either
                    * (a) not the shortest form or
                    * (b) outside the Unicode range of 0-0x10FFFF.
                    * Rather than trying to resynchronize, we will carry on until the end
                    * of the sequence and let the later error handling code catch it.
                    */
                    $mUcs4 = ($in);
                    $mUcs4 = ($mUcs4 & 0x03) << 24;
                    $mState = 4;
                    $mBytes = 5;
                } else if (0xFC == (0xFE & ($in))) {
                    // First octet of 6 octet sequence, see comments for 5 octet sequence.
                    $mUcs4 = ($in);
                    $mUcs4 = ($mUcs4 & 1) << 30;
                    $mState = 5;
                    $mBytes = 6;
                } else {
                    /* Current octet is neither in the US-ASCII range nor a legal first
                    * octet of a multi-octet sequence.
                    */
                    return false;
                }
            } else {
                // When mState is non-zero, we expect a continuation of the multi-octet
                // sequence
                if (0x80 == (0xC0 & ($in))) {
                    // Legal continuation.
                    $shift = ($mState - 1) * 6;
                    $tmp = $in;
                    $tmp = ($tmp & 0x0000003F) << $shift;
                    $mUcs4 |= $tmp;

                    if (0 == --$mState) {
                        /* End of the multi-octet sequence. mUcs4 now contains the final
                        * Unicode codepoint to be output
                        *
                        * Check for illegal sequences and codepoints.
                        */

                        // From Unicode 3.1, non-shortest form is illegal
                        if (((2 == $mBytes) && ($mUcs4 < 0x0080)) ||
                            ((3 == $mBytes) && ($mUcs4 < 0x0800)) ||
                            ((4 == $mBytes) && ($mUcs4 < 0x10000)) ||
                            (4 < $mBytes) ||
                            // From Unicode 3.2, surrogate characters are illegal
                            (($mUcs4 & 0xFFFFF800) == 0xD800) ||
                            // Codepoints outside the Unicode range are illegal
                            ($mUcs4 > 0x10FFFF)) {
                            return false;
                        }
                        if (0xFEFF != $mUcs4) {
                            // BOM is legal but we don't want to output it
                            $out[] = $mUcs4;
                        }
                        //initialize UTF8 cache
                        $mState = 0;
                        $mUcs4 = 0;
                        $mBytes = 1;
                    }
                } else {
                    /* ((0xC0 & (*in) != 0x80) && (mState != 0))
                    *
                    * Incomplete multi-octet sequence.
                    */
                    return false;
                }
            }
        }
        return $out;
    }

    private function to_unicode($text) {
        $text = $this->utf8ToUnicode($text);
        $res = '';
        foreach ($text as $value) {
            $c = dechex($value + 0);
            switch (strlen($c)) {
                case 1: $res .= '000' . $c;
                    break;
                case 2: $res .= '00' . $c;
                    break;
                case 3: $res .= '0' . $c;
                    break;
                case 4: $res .= $c;
                    break;
            }
        }
        return $res;
    }

}
