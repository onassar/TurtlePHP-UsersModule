<?php

    // namespaces
    namespace Modules\Users;

    // add module routes to application
    \Turtle\Application::addRoutes(array(

        '^/users$' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionIndex',
            'view' => MODULE . '/views/raw.inc.php'
        ),
        '^/users/login$' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionLogin',
            'view' => MODULE . '/views/raw.inc.php'
        ),
        '^/users/logout$' => array(// P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionLogout',
            'view' => MODULE . '/views/raw.inc.php'
        ),
        '^/users/changePassword$' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionChangePassword',
            'view' => MODULE . '/views/raw.inc.php'
        ),
        '^/users/resetPassword$' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionResetPassword',
            'view' => MODULE . '/views/raw.inc.php'
        )
    ));
