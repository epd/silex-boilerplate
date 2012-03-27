<?php
/**
 * @file
 * Application routing file
 */

// Render our default route
$app->get('/', function() use($app) {
  // An example of using Monolog for debugging
  if ($app['debug']) {
    $app['monolog']->addInfo('Getting the default layout.');
  }

  // Render our main layout here using the Twig component
  return $app['twig']->render('layout.twig', array(
    'title' => 'My Super Cool App',
    'app_css' => '/app/assets/css/app.css',
  ));
});
