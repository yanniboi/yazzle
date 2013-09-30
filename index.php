<?php

include_once __DIR__ . '/vendor/autoload.php';
// include_once __DIR__ . '/src/procedural.php';
include_once __DIR__ . '/src/lib/LeapYearController.php';
include_once __DIR__ . '/src/lib/TemplateController.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

$request = Request::createFromGlobals();

// Get path from browser;
$path = include __DIR__.'/src/path.php';

// Goto front if not set
if (empty($path)) {
  $path = 'hello';
}

$routes = include __DIR__.'/src/page_route.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
  $request->attributes->add($matcher->match('/'.$path));

  $resolver = new ControllerResolver();
  $controller = $resolver->getController($request);
  $arguments = $resolver->getArguments($request, $controller);
  $test = '';

  $response = call_user_func_array($controller, $arguments);
}
catch (ResourceNotFoundException $e) {
  $response = new Response('Not Found', 404);
}
catch (Exception $e) {
  $response = new Response('An error occurred', 500);
}

$response->send();
