<?php

namespace PimcoreDeployment;

class Customsql extends DAbstract
{
    /**
     * @var string
     */
    private $backupPath = PIMCORE_WEBSITE_VAR . '/plugins/PimcoreDeployment/customsql/';
    /**
     * @var string
     */
    private $dumpFileNamePattern = '*.sql';
    /**
     * @var Zend_Config
     */
    public $config;

    public function __construct()
    {
        parent::__construct();

        \Pimcore\File::mkdir($this->backupPath);
    }

    /**
     * Creates migration
     */
    public function create()
    {
        die('Custom SQL files to import should be created manually in ' . $this->backupPath . ' folder');
    }

    /**
     * Migrate migration
     * @throws Exception
     * @throws Zend_Exception
     */
    public function migrate()
    {
        $cnf = \Pimcore\Config::getSystemConfig();

        $u = $cnf->database->params->username;
        $p = $cnf->database->params->password;
        if($p) $p = " -p " . $p;
        $db = $cnf->database->params->dbname;
        $h = $cnf->database->params->host;

        $sqlFilesPattern = $this->backupPath . $this->dumpFileNamePattern;

        $sqlFiles = glob($sqlFilesPattern);

        foreach($sqlFiles as $sf)
        {
            $command = "cat $sf | mysql -u$u $p -h$h $db";
            print "EXEC: $command \n";
            exec($command, $output, $return_var);
        }
    }
}
