<?php
/**
 * @file
 * Application initialization file.
 *
 * Loads other providers, components, and registers namespaces used in the app.
 */

// Symfony Request and Response components
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Register namespace for Silex Extensions
$app['autoloader']->registerNamespace('SilexExtension', __DIR__ . '/vendor/silex-extension/src');
$app['autoloader']->registerNamespace('evNN', __DIR__ . '/vendor/evNN/less-service-provider/src');
$app['autoloader']->registerNamespace('LessElephant', __DIR__ . '/vendor/cypresslab/less-elephant/src');
$app['autoloader']->registerNamespace('Symfony\\Component\\Finder', __DIR__ . '/vendor/symfony/finder');
$app['autoloader']->registerNamespace('Symfony\\Component\\Process', __DIR__ . '/vendor/symfony/process');


// Include Monolog to add application debug logging
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.class_path' => __DIR__ . '/vendor/monolog/monolog/src',
  'monolog.logfile'    => __DIR__ . '/logs/app.log',
));

// Include Twig component for template rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path'       => __DIR__ . '/app/templates',
  'twig.class_path' => __DIR__ . '/vendor/twig/twig/lib',
));

// Include Doctrine/MongoDB component for database connection
$app->register(new SilexExtension\MongoDbExtension(), array(
  'mongodb.class_path' => __DIR__ . '/vendor/mongodb/lib',
  'mongodb.connection' => array(
    'server' => 'mongodb://localhost',
  )
));

// Include the LESS CSS component
$app->register(new evNN\Silex\Less\LessServiceProvider(), array(
  'less.less_dir' => __DIR__ . '/assets/less',
  'less.app_less' => 'app.less',
  'less.app_css'  => __DIR__ . '/assets/css/app.css',
));
