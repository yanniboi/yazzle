<?php

static $path;

if (isset($path)) {
  return $path;
}

if (isset($_GET['path']) && is_string($_GET['path'])) {
  $path = $_GET['path'];
}
elseif (isset($_SERVER['REQUEST_URI'])) {
  // This request is either a clean URL, or 'index.php', or nonsense.
  // Extract the path from REQUEST_URI.
  $request_path = strtok($_SERVER['REQUEST_URI'], '?');
  $base_path_len = strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/'));
  // Unescape and strip $base_path prefix, leaving path without a leading slash.
  $path = substr(urldecode($request_path), $base_path_len + 1);
  // If the path equals the script filename, either because 'index.php' was
  // explicitly provided in the URL, or because the server added it to
  // $_SERVER['REQUEST_URI'] even when it wasn't provided in the URL (some
  // versions of Microsoft IIS do this), the front page should be served.
  if ($path == basename($_SERVER['PHP_SELF'])) {
    $path = '';
  }
}
else {
  // This is the front page.
  $path = '';
}

// Under certain conditions Apache's RewriteRule directive prepends the value
// assigned to $_GET['path'] with a slash. Moreover we can always have a trailing
// slash in place, hence we need to normalize $_GET['path'].
$path = trim($path, '/');

return $path;
