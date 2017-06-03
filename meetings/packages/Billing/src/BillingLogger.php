<?php
namespace Billing;

class BillingLogger
{
    /**
     * @var
     */
    public $value;


    /**
     * MessageLogger constructor.
     * @param $environment
     * @param $logfile
     */
    public function __construct($environment, $logfile)
    {
        $this->environment = $environment;
        $this->logfile = $logfile;
    }

    /**
     * @param $log
     */
    public function log($log)
    {
        file_put_contents(storage_path().'/logs/'.$this->logfile.date("d.m.Y").'.log', $log."\n", FILE_APPEND);
    }

}