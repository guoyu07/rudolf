<?php

$request = $_SERVER['REQUEST_URI'];

$rudolfPublic = __DIR__.'/public';

// workaround https://bugs.php.net/bug.php?id=61286
$_SERVER['SCRIPT_NAME'] = '/index.php';

$requestFile = $rudolfPublic.$request;
$index = $rudolfPublic.'/index.php';

if (preg_match('/\.(?:png|jpg|jpeg|gif|svg|ttf)$/', $request)) {
    if (file_exists($requestFile)) {
        return false;
    }
    include $index;
} elseif (preg_match('/(.)*\.(?:js|css|php)\??(.*)?$/', $request)) {
    return false;
} else {
    include $index;
}
