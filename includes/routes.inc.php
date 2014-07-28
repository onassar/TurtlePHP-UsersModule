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
            'controller' => 'Modules\Users\Users',
            'action' => 'actionIndex'
        ),
        '^' . ($paths['login']) . '$' => array(// G + P
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionLogin'
        ),
        '^' . ($paths['logout']) . '$' => array(// P
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionLogout'
        ),
        '^' . ($paths['changePassword']) . '$' => array(// G + P
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionChangePassword'
        ),
        '^' . ($paths['resetPassword']) . '$' => array(// G + P
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionResetPassword'
        ),

        // Emails
        '^' . ($paths['emails']['welcome']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Emails',
            'action' => 'actionUserWelcome'
        ),
        '^' . ($paths['emails']['resetPassword']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Emails',
            'action' => 'actionUserResetPassword'
        )
    ));
