<?php

    // namespaces
    namespace Modules\Users;

    // Path/view settings
    $paths = getConfig('paths');

    // add module routes to application
    \Turtle\Application::addRoutes(array(

        // Users
        '^' . ($paths['terms']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionTerms'
        ),
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
        '^' . ($paths['dashboard']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionDashboard'
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
        '^' . ($paths['loginBypass']) . '$' => array(// G + P
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionLoginBypass'
        ),

        // Emails
        '^' . ($paths['emails']['welcome']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Emails',
            'action' => 'actionWelcome'
        ),
        '^' . ($paths['emails']['loginBypass']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Emails',
            'action' => 'actionLoginBypass'
        ),
        '^' . ($paths['emails']['resetPassword']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Emails',
            'action' => 'actionResetPassword'
        )
    ));
