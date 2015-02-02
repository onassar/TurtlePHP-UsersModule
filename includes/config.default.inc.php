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
        'gACode' => 'UA-XXXXXXX-XX',
        'rememberMe' => true,
        'rememberMeDuration' => 10 * 365 * 24 * 60 * 60,
        'css' => false,
        'logoPath' => 'http://i.imgur.com/EneDoVl.png',
        'redirectGetRequestsOnError' => true,
        'welcomeEmailsCronBatchCount' => 5,
        'autoLogin' => true,
        'trackLastActive' => true,
        'stripeCheckout' => false,

        /**
         * Method of recovering an account
         * 
         * If 'resetPassword', user's password will be changed, and login link
         * will be sent. If 'bypassPassword', user will be passed link which will
         * log them in, and forward them to the change password view
         * 
         * @var string (default: 'bypassPassword') can also be 'resetPassword'
         */
        'accountRecoveryMethod' => 'bypassPassword'
    );

    /**
     * Email settings
     * 
     */
    $emails = array(
        'bypassPassword' => array(
            'subject' => 'Account recovery',
            'tag' => 'bypassPassword',
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
        'privacy' => '/privacy',
        'crumble' => '/crumble',
        'dashboard' => '/dashboard',
        'register' => '/register',
        'login' => '/login',
        'logout' => '/logout',
        'resetPassword' => '/password/reset',
        'bypassPassword' => '/recover',
        'changePassword' => '/password/change',
        'emails' => array(
            'welcome' => '/emails/user/welcome',
            'bypassPassword' => '/emails/user/password/bypass',
            'resetPassword' => '/emails/user/password/reset'
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
        'privacy' => array(
            'get' => MODULE . '/schemas/users.privacy.get.json'
        ),
        'crumble' => array(
            'get' => MODULE . '/schemas/users.crumble.get.json'
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
            'get' => MODULE . '/schemas/users.logout.get.json',
            'post' => MODULE . '/schemas/users.logout.post.json'
        ),
        'resetPassword' => array(
            'get' => MODULE . '/schemas/users.resetPassword.get.json',
            'post' => MODULE . '/schemas/users.resetPassword.post.json'
        ),
        'bypassPassword' => array(
            'get' => MODULE . '/schemas/users.bypassPassword.get.json',
            'post' => MODULE . '/schemas/users.bypassPassword.post.json'
        ),
        'changePassword' => array(
            'get' => MODULE . '/schemas/users.changePassword.get.json',
            'post' => MODULE . '/schemas/users.changePassword.post.json'
        ),
        'emails' => array(
            'bypassPassword' => array(
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
        'privacy' => array(
            'get' => MODULE . '/views/privacy.inc.php'
        ),
        'crumble' => array(
            'get' => false
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
            'get' => MODULE . '/views/raw.inc.php',
            'post' => MODULE . '/views/raw.inc.php'
        ),
        'resetPassword' => array(
            'get' => MODULE . '/views/resetPassword.inc.php',
            'post' => MODULE . '/views/raw.inc.php'
        ),
        'bypassPassword' => array(
            'get' => MODULE . '/views/bypassPassword.inc.php',
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
            'bypassPassword' => array(
                'get' => MODULE . '/views/emails/bypassPassword.v1.inc.php'
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
