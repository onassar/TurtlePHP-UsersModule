<?php

    // namespaces
    namespace Modules\Users;

    // Path/view settings
    $config = getConfig();
    $paths = $config['paths'];

    // add module routes to application
    \Turtle\Application::addRoutes(array(

        // Users
        '^' . ($paths['register']) . '$' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionIndex',
            'view' => MODULE . '/views/raw.inc.php'
        ),
        '^' . ($paths['login']) . '$' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionLogin',
            'view' => MODULE . '/views/raw.inc.php'
        ),
        '^' . ($paths['logout']) . '$' => array(// P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionLogout',
            'view' => MODULE . '/views/raw.inc.php'
        ),
        '^' . ($paths['changePassword']) . '$' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionChangePassword',
            'view' => MODULE . '/views/raw.inc.php'
        ),
        '^' . ($paths['resetPassword']) . '$' => array(// G + P
            'module' => true,
            'controller' => '\Modules\Users\Users',
            'action' => 'actionResetPassword',
            'view' => MODULE . '/views/raw.inc.php'
        ),

        // Emails
        '^' . ($paths['emails']['welcome']) . '$' => array(// G
            'module' => true,
            'controller' => '\Modules\Users\Emails',
            'action' => 'actionUserWelcome',
            'view' => MODULE . '/views/raw.inc.php'
        ),
        '^' . ($paths['emails']['resetPassword']) . '$' => array(// G
            'module' => true,
            'controller' => '\Modules\Users\Emails',
            'action' => 'actionUserResetPassword',
            'view' => MODULE . '/views/raw.inc.php'
        )
    ));
