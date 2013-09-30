<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

$routes = new RouteCollection();

$routes->add('hello', new Route('/hello/{name}', array(
  'name' => 'World',
  '_controller' => 'TemplateController::indexAction'
)));

$routes->add('bye', new Route('/bye', array(
  '_controller' => 'TemplateController::indexAction'
)));

$routes->add('leap_year', new Route('/is_leap_year/{year}', array(
  'year' => null,
  '_controller' => 'LeapYearController::indexAction',
)));


return $routes;