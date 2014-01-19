<?php

session_start();

require dirname(__FILE__) . '/../../lib/Nette/Debugger.php';
require dirname(__FILE__) . '/../../lib/dibi/dibi.php';

ndebug();


// connects to MySQLi using array
//echo '<p>Connecting to MySQLi: ';
try {
	dibi::connect(array(
		'driver'   => 'mysqli',
		'host'     => 'sql5.web4u.cz',
		'username' => 'mikointe',
		'password' => 'erdn8679',
		'database' => 'mikointe',
                'charset' => 'cp1250',
                'profiler' => array(
                    'run' => TRUE,
            )
	));
//	echo 'OK';

} catch (DibiException $e) {
	echo get_class($e), ': ', $e->getMessage(), "\n";
}
