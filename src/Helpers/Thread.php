<?php

namespace AsyncPHP\Helpers;

class Thread{

    private $class;
    private $object;
    private $arguments;

    public function __construct($object){
        $this->object = $object;
        $this->class = get_class($object);        
        $this->arguments = get_object_vars(($object));
    }

    public function start(){        
                              
        $cmd = "php ".base_path(). DIRECTORY_SEPARATOR. "artisan run:process ". json_encode(['data' => [
            'class' => $this->class,
            'arguments' => $this->arguments
            ]
        ]);

        $this->execInBackground(addslashes($cmd));
    }

    public function execInBackground($cmd) {
        if (substr(php_uname(), 0, 7) == "Windows"){                      
            pclose(popen("start /B ". $cmd, "w"));                           
        }else{
            exec($cmd . " > /dev/null &");  
        }
    }    
}