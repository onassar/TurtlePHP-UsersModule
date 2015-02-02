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
        '^' . ($paths['privacy']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionPrivacy'
        ),
        '^' . ($paths['crumble']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionCrumble'
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
        '^' . ($paths['bypassPassword']) . '$' => array(// G + P
            'module' => true,
            'controller' => 'Modules\Users\Users',
            'action' => 'actionBypassPassword'
        ),

        // Emails
        '^' . ($paths['emails']['welcome']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Emails',
            'action' => 'actionWelcome'
        ),
        '^' . ($paths['emails']['bypassPassword']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Emails',
            'action' => 'actionBypassPassword'
        ),
        '^' . ($paths['emails']['resetPassword']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Emails',
            'action' => 'actionResetPassword'
        ),

        // Crons
        '^' . ($paths['crons']['sendWelcomeEmails']) . '$' => array(// G
            'module' => true,
            'controller' => 'Modules\Users\Crons',
            'action' => 'actionSendWelcomeEmails'
        ),
    ));
