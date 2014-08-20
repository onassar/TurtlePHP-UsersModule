<?php

    // namespaces
    namespace Modules\Users;

    // configuration init
    $defaults = array();
    $emails = array();
    $paths = array();
    $schemas = array();
    $security = array();
    $views = array();

    /**
     * Default settings
     * 
     */
    $defaults = array(
        'rememberMe' => true,
        'redirectGetRequestsOnError' => true,
        'welcomeEmailsCronBatchCount' => 5,

        /**
         * Method of recovering an account
         * 
         * If 'resetPassword', user's password will be changed, and login link
         * will be sent. If 'loginBypass', user will be passed link which will
         * log them in, and forward them to the change password view
         * 
         * @var string (default: 'loginBypass') can also be 'resetPassword'
         */
        'accountRecoveryMethod' => 'loginBypass'
    );

    /**
     * Email settings
     * 
     */
    $emails = array(
        'loginBypass' => array(
            'subject' => 'Account recovery',
            'tag' => 'loginBypass',
        ),
        'resetPassword' => array(
            'subject' => 'Your password has been reset',
            'tag' => 'resetPassword',
            'resetTerms' => array(
                'Boat',
                'Apple',
                'Shoe',
                'Pencil',
                'Kitten'
            )
        ),
        'welcome' => array(
            'autoSend' => true,
            'cron' => false,
            'cronWaitTime' => 3 * 60 * 60,
            'subject' => 'Welcome',
            'tag' => 'welcome'
        )
    );

    /**
     * Paths
     * 
     */

    // generic
    $paths = array(
        'terms' => '/terms',
        'dashboard' => '/dashboard',
        'register' => '/users',
        'login' => '/users/login',
        'logout' => '/users/logout',
        'resetPassword' => '/users/password/reset',
        'loginBypass' => '/users/password/recover',
        'changePassword' => '/users/password/change',
        'emails' => array(
            'welcome' => '/emails/user/welcome',
            'loginBypass' => '/emails/user/loginBypass',
            'resetPassword' => '/emails/user/resetPassword'
        ),
        'crons' => array(
            'sendWelcomeEmails' => '/crons/users/sendWelcomeEmails'
        )
    );

    /**
     * Schemas
     * 
     */

    // generic
    $schemas = array(
        'terms' => array(
            'get' => MODULE . '/schemas/users.terms.get.json'
        ),
        'dashboard' => array(
            'get' => MODULE . '/schemas/users.dashboard.get.json'
        ),
        'register' => array(
            'get' => MODULE . '/schemas/users.index.get.json',
            'post' => MODULE . '/schemas/users.index.post.json'
        ),
        'login' => array(
            'get' => MODULE . '/schemas/users.login.get.json',
            'post' => MODULE . '/schemas/users.login.post.json'
        ),
        'logout' => array(
            'post' => MODULE . '/schemas/users.logout.post.json'
        ),
        'resetPassword' => array(
            'get' => MODULE . '/schemas/users.resetPassword.get.json',
            'post' => MODULE . '/schemas/users.resetPassword.post.json'
        ),
        'loginBypass' => array(
            'get' => MODULE . '/schemas/users.loginBypass.get.json',
            'post' => MODULE . '/schemas/users.loginBypass.post.json'
        ),
        'changePassword' => array(
            'get' => MODULE . '/schemas/users.changePassword.get.json',
            'post' => MODULE . '/schemas/users.changePassword.post.json'
        ),
        'emails' => array(
            'loginBypass' => array(
                'get' => MODULE . '/schemas/emails.userStandard.get.json'
            ),
            'resetPassword' => array(
                'get' => MODULE . '/schemas/emails.userStandard.get.json'
            ),
            'welcome' => array(
                'get' => MODULE . '/schemas/emails.userStandard.get.json'
            )
        ),
        'crons' => array(
            'sendWelcomeEmails' => array(
                'get' => MODULE . '/schemas/crons.standard.get.json'
            )
        )
    );

    /**
     * Security
     * 
     */

    // generic
    $security = array(
        'masterPassword' => 'apples',
        'passwordSalt' => '2389nskj;"sdfdf'
    );

    /**
     * Views
     * 
     */

    // GET views
    $views = array(
        'terms' => array(
            'get' => MODULE . '/views/terms.inc.php'
        ),
        'dashboard' => array(
            'get' => MODULE . '/views/dashboard.inc.php'
        ),
        'register' => array(
            'get' => MODULE . '/views/register.inc.php',
            'post' => MODULE . '/views/raw.inc.php'
        ),
        'login' => array(
            'get' => MODULE . '/views/login.inc.php',
            'post' => MODULE . '/views/raw.inc.php'
        ),
        'logout' => array(
            'post' => MODULE . '/views/raw.inc.php'
        ),
        'resetPassword' => array(
            'get' => MODULE . '/views/resetPassword.inc.php',
            'post' => MODULE . '/views/raw.inc.php'
        ),
        'loginBypass' => array(
            'get' => MODULE . '/views/loginBypass.inc.php',
            'post' => MODULE . '/views/raw.inc.php'
        ),
        'changePassword' => array(
            'get' => MODULE . '/views/changePassword.inc.php',
            'post' => MODULE . '/views/raw.inc.php'
        ),
        'emails' => array(
            'welcome' => array(
                'get' => MODULE . '/views/emails/welcome.v1.inc.php'
            ),
            'loginBypass' => array(
                'get' => MODULE . '/views/emails/loginBypass.v1.inc.php'
            ),
            'resetPassword' => array(
                'get' => MODULE . '/views/emails/resetPassword.v1.inc.php'
            )
        ),
        'crons' => array(
            'sendWelcomeEmails' => array(
                'get' => MODULE . '/views/raw.inc.php'
            )
        )
    );

    // config storage
    \Plugin\Config::add(
        'TurtlePHP-UsersModule',
        array(
            'defaults' => $defaults,
            'emails' => $emails,
            'paths' => $paths,
            'schemas' => $schemas,
            'security' => $security,
            'views' => $views
        )
    );
