<?php

namespace AsyncPHP\Helpers;

class ThreadPool{

    private $threads;

    public function __construct($threads = []){
        $this->threads = collect($threads);
    }

    public function execute(){

        $max_processes = $this->num_cpus();

        foreach($this->threads->chunk($max_processes) as $threads){            
            foreach($threads as $thread){
                $thread->start();
            }            
        }
    }

    public function get_processor_cores_number() {
        if (PHP_OS_FAMILY == 'Windows') {
            $cores = shell_exec('echo %NUMBER_OF_PROCESSORS%');
        } else {
            $cores = shell_exec('nproc');
        }
    
        return (int) $cores;
    }

    public function num_cpus()
    {
        $numCpus = 1;

        if (is_file('/proc/cpuinfo'))
        {
            $cpuinfo = file_get_contents('/proc/cpuinfo');
            preg_match_all('/^processor/m', $cpuinfo, $matches);

            $numCpus = count($matches[0]);
        }
        else if ('WIN' == strtoupper(substr(PHP_OS, 0, 3)))
        {
            $process = @popen('wmic cpu get NumberOfCores', 'rb');

            if (false !== $process)
            {
            fgets($process);
            $numCpus = intval(fgets($process));

            pclose($process);
            }
        }
        else
        {
            $process = @popen('sysctl -a', 'rb');

            if (false !== $process)
            {
            $output = stream_get_contents($process);

            preg_match('/hw.ncpu: (\d+)/', $output, $matches);
            if ($matches)
            {
                $numCpus = intval($matches[1][0]);
            }

            pclose($process);
            }
        }
        
        return $numCpus;
    }
}