<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

require_once 'Zend/Registry.php';

require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

require_once 'Zend/Config.php';

/*$arrConfig = array(
      'webhost'=>'localhost',
	  'appName'=>'My First Zend',
	  'database'=>array(
	      'dbhost'=>'localhost',
		  'dbname'=>'blad_db',
		  'dbuser'=>'root',
		  'dbpass'=>'nagorki'
	      )
      );*/

$config = new Zend_Config(require '../application/configs/config.php');

$title  = $config->appName;
$params = $config->database->toArray();


/*$params = array('host'		=>$config->database->dbhost,
	            'username'	=>$config->database->dbuser,
			    'password'  =>$config->database->dbpass,
				'dbname'	=>$config->database->dbname
	            );*/

/* Ustawienie zmiennej do rejestru */
Zend_Registry::set('title',"My First Application");

$arrName = array('Ilmia Fatin','Aqila Farzana', 'Imanda Fahrizal');
Zend_Registry::set('credits',$arrName);


$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
    
$DB->setFetchMode(Zend_Db::FETCH_OBJ);
Zend_Registry::set('DB',$DB);


// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();