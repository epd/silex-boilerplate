<?php
/**
 * @file
 * Application router file.
 */

// Initialize our Silex-based app
require_once __DIR__ . '/silex.phar';
$app = new Silex\Application();

// Load other components, providers, and register namespaces
require_once __DIR__ . '/init.php';

// Turn Silex debugging on
$app['debug'] = TRUE;

// Render our default route
$app->get('/', function() use($app) {
  if ($app['debug']) {
    $app['monolog']->addInfo('Getting the default layout.');
  }
  return $app['twig']->render('layout.twig', array(
    'title' => 'My Web App',
  ));
});

// Compile LESS files in a "before" filter
$app->before(function () use($app) {
  if (!$app['less']->isClean()) {
    $app['less']->compile();
  }
});

// All systems are go!
$app->run();
