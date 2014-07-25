<?php

    // grab parent directory
    $info = pathinfo(__DIR__);
    $parent = $info['dirname'];

    // add module routes to application
    \Turtle\Application::addRoutes(array(

        '^/users' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionIndex',
            'view' => ($parent) . '/views/raw.inc.php'
        ),
        '^/users/login' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionLogin',
            'view' => ($parent) . '/views/raw.inc.php'
        ),
        '^/users/logout' => array(// P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionLogout',
            'view' => ($parent) . '/views/raw.inc.php'
        ),
        '^/users/changePassword' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionChangePassword',
            'view' => ($parent) . '/views/raw.inc.php'
        ),
        '^/users/resetPassword' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionResetPassword',
            'view' => ($parent) . '/views/raw.inc.php'
        )
    ));
