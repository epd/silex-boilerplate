#!/bin/sh
git clone --recursive git@github.com:evNN/silex-boilerplate.git
wget http://silex.sensiolabs.org/get/silex.phar
curl -s http://getcomposer.org/installer | php ; php composer.phar install
