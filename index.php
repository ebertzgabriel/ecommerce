<?php 

// composer
require_once("vendor/autoload.php");

// namespaces
use \Slim\Slim;
USE \Extras\Page;

// Slim Framework usando as rotas
$app = new \Slim\Slim();

$app->config('debug', true);

// Slim, quando for o index
$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});


// Rodando o slim
$app->run();

?>