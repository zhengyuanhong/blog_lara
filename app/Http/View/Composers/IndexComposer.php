<?php
namespace App\Http\View\Composers;

use Illuminate\View\View;

class IndexComposer {
    public function compose(View $view){
        $view->with('config',Config('view.web_config'));
    }
}

