<?php
/**
 * @file
 * Application router file.
 */

// Initialize our Silex-based app
require_once __DIR__ . '/silex.phar';
$app = new Silex\Application();

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

// Turn Silex debugging on
$app['debug'] = TRUE;

// Inject our application routes
require_once __DIR__ . "/app/routes.php";

// Compile LESS files in a "before" filter
$app->before(function () use($app) {
  if (!$app['less']->isClean()) {
    $app['less']->compile();
  }
});

// All systems are go!
$app->run();
