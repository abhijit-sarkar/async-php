<?php

namespace AsyncPHP\Console\Commands;

use ReflectionClass;
use Illuminate\Console\Command;

class Process extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:process {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executes process';

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
     * @return int
     */
    public function handle()
    {
        $data = $this->argument('data');
        $data = json_decode($data, true);

        $class = stripslashes($data['data']['class']);
        
        $constructor_parameters = array_keys(get_class_vars($class));
                
        $reg_arguments = [];

        foreach($data['data']['arguments'] as $key => $args){
            $reg_arguments[] = $args;
        }

        $reflection = new ReflectionClass($class); 
        $myClassInstance = $reflection->newInstanceArgs($reg_arguments);
        $myClassInstance->run();

        exit();
    }
}
