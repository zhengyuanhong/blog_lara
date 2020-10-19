<?php

namespace App\Console\Commands;

use App\Mail\InstallShip;
use App\Models\Installment;
use App\Models\InstallmentItem;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\Email;

class NotifyRepay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:Notify-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $res = InstallmentItem::query()->with('installment')->whereHas('installment',function($query){
            $query->where('user_id',1);
        })->whereBetween('repay_date',[Carbon::now()->firstOfMonth(),Carbon::now()->lastOfMonth()])->get();

        InstallmentItem::query()->whereBetween('repay_date',[Carbon::now()->subMonth()->firstOfMonth(),Carbon::now()->subMonth()->lastOfMonth()])->update(['status'=>1]);

        $total = [];
        $installments = Installment::query()->where('user_id',1)->get();
        /** @var Installment $installment */
        foreach($installments as $installment){
            $total[] = $installment->items()->where('status',0)->sum('fee');
        }
        Mail::to($res[0]->installment->notify)->send(new InstallShip($res,$total));
    }
}
