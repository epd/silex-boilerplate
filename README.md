Silex Boilerplate
=================

This is a simple boilerplate for an application written with the [Silex PHP 
microframework](http://silex.sensiolabs.org/). It is intended to be a starting 
point for a REST Web application.  It comes with Twig, MongoDB, and LESS support by 
default.

## Installation ##
Installation is very easy. It makes use of [Composer](http://getcomposer.org/) 
for PHP as well as git submodules for dependencies not yet available as a 
Composer package. Open up a new Terminal window and run this command:

``` bash
$ curl -S https://raw.github.com/evNN/silex-boilerplate/master/system/get.sh | sh
```

This will create a new directory `silex-boilerplate` in the current working directory
and install all dependencies for the project.

If you have PHP 5.4 installed, you can simply run the following and start a new
local development server to test out your app:

``` bash
$ php -S localhost:8080 ./silex-boilerplate
```

### Important ###
You must give write access to the `system/logs` directory for Monolog to be able to do
its job. Also, to use LESS compilation, the component needs write access to `app/assets/css`
and `app/assets/less`. Use something similar to the following if you encounter any problems:

``` bash
$ chmod a+w system/logs app/assets/less app/assets/css
```

You must also have the `less` node.js binary and library files installed in your system for the
LESS component to function successfully. Install it with the following:

``` bash
$ npm install -g less
```

## Future ##
I intend to integrate this fully with [Backbone Boilerplate](https://github.com/tbranyen/backbone-boilerplate)
as a backend/REST portion of the framework.
