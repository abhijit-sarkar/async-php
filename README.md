# async-php

This library is not supported in Laravel Framework.

In config/app.php, add - AsyncPHP\AsyncPHPServiceProvider:class inside "providers"


class MyClass{

    public $roll_nums;
    public $standard;

    public function __construct($roll_nums, $standard){
        $this->roll_nums = $roll_nums;
        $this->standard = $standard;
    }

    public function run(){
        sleep(2);        
        logger()->info("Inside my class: ". Carbon::now()->format('Y-m-d H:i:s'));       
    }
}

$myClass1 = new MyClass(["123", "234"], 1);
$myClass2 = new MyClass(["123", "234"], 2);

$thread1 = new Thread($myClass1);
$thread2 = new Thread($myClass2);

//Either
$thread1->start();
$thread2->start();

//OR
$threadPool = new ThreadPool([$thread1, $thread2]);
$threadPool->execute();

Note: MyClass is just a representation of any Class that needs to be run as a separate Process. You can pass arguments of any data type and n-number of arguments to MyClass, 
except any "OBJECT" type. MyClass should contain a run() method. The code inside the run() method gets executed asynchronously.

