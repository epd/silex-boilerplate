<?php
/**
 * @file
 * Application routing file
 */

// Render our default route
$app->get('/', function() use($app) {
  if ($app['debug']) {
    $app['monolog']->addInfo('Getting the default layout.');
  }
  return $app['twig']->render('layout.twig', array(
    'title' => 'My Web App',
  ));
});
