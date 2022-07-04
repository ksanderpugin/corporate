<?php

return [
    '~^api/(.+)\.(.+)$~i' => [\controllers\APIController::class, 'request'],
    '~^$~' => [\controllers\MainController::class, 'main'],
    '~^auth~' => [\controllers\AuthController::class, 'main']
];