<?php

namespace AsyncPHP;

use AsyncPHP\Console\Commands\Process;
use Illuminate\Support\ServiceProvider;

class AsyncPHPServiceProvider extends ServiceProvider{
    
    public function boot(){

        if($this->app->runningInConsole()){
            $this->commands([
                Process::class
            ]);
        }
    }
}