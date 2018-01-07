<?php 

session_start();

// composer
require_once("vendor/autoload.php");

// namespaces
use \Slim\Slim;
use \Extras\Page;
use \Extras\PageAdmin;
use \Extras\Model\User;


// Slim Framework usando as rotas
$app = new \Slim\Slim();

$app->config('debug', true);

// Slim, quando for o index
$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});



// Slim, quando for o idex da página administrativa
$app->get('/admin', function () {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index");
});


$app->get('/admin/login', function () {

	$page = new PageAdmin([
		'header' => false,
		'footer' => false,
	]);

	$page->setTpl("login");
});


$app->post('/admin/login', function () {

	User::login($_POST['login'], $_POST['password']);

	header("Location: /admin");

	exit();

});


$app->get('/admin/logout', function () {

	User::logout();

	header("Location: /admin/login");

	exit();
});


// Rodando o slim
$app->run();

?>