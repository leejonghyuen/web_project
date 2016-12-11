<?php
/**
 * Register application modules
 */

$application->registerModules(
    [
        'web'  => [
            'className' => 'Modules\Modules\Web\Module',
            'path'      => __DIR__ . '/../modules/web/Module.php'
        ],
        'dashboard' => [
            'className' => 'Modules\Modules\Dashboard\Module',
            'path'      => __DIR__ . '/../modules/dashboard/Module.php'
        ]
    ]
);
