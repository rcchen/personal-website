<?php

require 'vendor/autoload.php';

// Instantiate a new Slim application
$app = new \Slim\Slim();

// Twig templating
$app->container->singleton('twig', function ($c) {

	$twig = new \Slim\Views\Twig();

	$twig->parserOptions = array(
		'debug' => true,
		'cache' => dirname(__FILE__) . '/cache'
	);

	$twig->parserExtensions = array(
		new \Slim\Views\TwigExtension(),
	);

	$templatesPath = $c['settings']['templates.path'];
	$twig->setTemplatesDirectory($templatesPath);

	return $twig;	

});

// Define an HTTP GET route
$app->get('/', function() use ($app) {
	$app->twig->display('home.php', array('title' => 'Home'));
});

// Define routes for projects
$app->get('/project/:name', function($name) use ($app) {
	$url = preg_replace('/\\s+/', '-', $name);
	$app->twig->display($url . '.php');
});

// Run the app
$app->run();

?>
