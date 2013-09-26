<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

$request = Request::createFromGlobals();

$routes = include __DIR__.'/../src/page_route.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
  extract($matcher->match('/'.$request->query->get('path')), EXTR_SKIP);
  ob_start();
  include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

  $response = new Response(ob_get_clean());
} catch (Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
  $response = new Response('Not Found', 404);
} catch (Exception $e) {
  $response = new Response('An error occurred', 500);
}

$response->send();
