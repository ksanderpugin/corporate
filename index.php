<?php


spl_autoload_register(function (string $className) {
    require_once __DIR__ . DIRECTORY_SEPARATOR  . 'src' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
});

$route = $_GET['route'] ?? '';

$patterns = require __DIR__ . '/src/routes.php';

$isRouteFound = false;

$className = ''; $action = ''; $data = '';

foreach ($patterns as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        $className = $controllerAndAction[0];
        $action = $controllerAndAction[1];
        unset($matches[0]);
        $data = $matches;
        break;
    }
}

if (!$isRouteFound) {
    echo '404 page not found';
    return;
}

try {
    if ($className == \controllers\APIController::class) {
        //
    } else {
        if (is_null(\services\SecurityService::getAuthAccount()) && $className != \controllers\AuthController::class) {
            header('Location:/auth');
            exit;
        }
    }
    $controller = new $className();
    $controller->$action(...$data);
} catch (\Exception $e) {
    exit($e->getMessage());
}
