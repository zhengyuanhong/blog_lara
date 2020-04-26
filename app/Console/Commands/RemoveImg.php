<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemoveImg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除本地文件';

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
        $this->remove('avatars');
        $this->remove('article');
    }

    public function remove(string $dirname){
        $path = storage_path('app\public\/'.$dirname);
        if(!is_dir($path)){
            return false;
        }
        $handle = opendir($path);
        while (($file = readdir($handle)) !== false){
            if($file !='.' && $file != '..'){
                $src = $path.'/'.$file;
                if(!unlink($src)) echo '删除失败';
                Log::info('删除成功:'.$src);
            }
        }
        closedir($handle);
    }
}
