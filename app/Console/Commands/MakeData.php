<?php

namespace App\Console\Commands;

use App\Models\Installment;
use App\Models\InstallmentItem;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:add_data {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '添加还款数据';

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
        $type = $this->argument('type');
        switch ($type) {
            case 'xiao_mi':
                $this->addXiaoMi();
                break;
            case 'jing_dong':
                $this->addJDItems();
                break;
        }
    }

    /**
     * @param int $sequece
     * @param int $flag
     */
    public function addJDItems($sequece = 24, $flag = 12)
    {

        $installment = [
            'user_id' => 1,
            'name' => '【京东】:DJI 大疆 御 Mavic Mini',
            'price' => 3399,
            'base' => 24,
            'pingtai' => '京东'
        ];
        $JD = Installment::create($installment);

        $data = [
            'fee' => 141.63,
            'repay_date' => Carbon::create('2019', '12', '16'),
            'status' => 1
        ];

        for ($i = 1; $i <= $sequece; $i++) {
            $data['sequence'] = $i;
            if ($i >= 2) {
                $data['repay_date'] = $data['repay_date']->addMonths();
            }
            if ($flag <= $i) {
                $data['status'] = 0;
            }
            $install = new InstallmentItem($data);
            $install->installment()->associate($JD);
            $install->save();
        }
    }

    public function addXiaoMi($sequece = 12, $flag = 7)
    {

        $installment = [
            'user_id' => 1,
            'name' => '小米贷款',
            'price' => 3399,
            'base' => 24,
            'pingtai' => '小米'
        ];
        $xiaomi = Installment::create($installment);

        $data = [
            'fee' => 275.04,
            'repay_date' => Carbon::create('2020', '5', '13'),
            'status' => 1
        ];

        for ($i = 1; $i <= $sequece; $i++) {
            $data['sequence'] = $i;
            if ($i >= 2) {
                $data['repay_date'] = $data['repay_date']->addMonths();
            }
            if ($flag <= $i) {
                $data['status'] = 0;
            }
            $install = new InstallmentItem($data);
            $install->installment()->associate($xiaomi);
            $install->save();
        }
    }
}
