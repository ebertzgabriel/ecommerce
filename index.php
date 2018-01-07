<?php 

// composer
require_once("vendor/autoload.php");

// namespaces
use \Slim\Slim;
use \Extras\Page;
use \Extras\PageAdmin;


// Slim Framework usando as rotas
$app = new \Slim\Slim();

$app->config('debug', true);

// Slim, quando for o index
$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});


// Slim, quando for o idex da página administrativa
$app->get('/admin/', function () {

	$page = new PageAdmin();

	$page->setTpl("index");
});


// Rodando o slim
$app->run();

?>