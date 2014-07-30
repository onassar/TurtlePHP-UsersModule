<?php

    // namespaces
    namespace Modules\Users;

    // configuration init
    $emails = array();
    $memcached = array();
    $paths = array();
    $schemas = array();
    $security = array();
    $settings = array();
    $views = array();

    /**
     * Email settings
     * 
     */
    $emails = array(
        'resetPassword' => array(
            'send' => true,
            'subject' => 'Password reset',
            'resetTerms' => array(
                'Boat',
                'Apple',
                'Shoe',
                'Pencil',
                'Kitten'
            )
        ),
        'welcome' => array(
            'send' => true,
            'subject' => 'Welcome'
        )
    );

    /**
     * Memcached
     * 
     */

    // servers
    $memcached = array(
    );

    /**
     * Paths
     * 
     */

    // generic
    $paths = array(
        'register' => '/users',
        'login' => '/users/login',
        'logout' => '/users/logout',
        'resetPassword' => '/users/resetPassword',
        'changePassword' => '/users/changePassword',
        'emails' => array(
            'welcome' => '/emails/user/welcome',
            'resetPassword' => '/emails/user/resetPassword'
        )
    );

    /**
     * Schemas
     * 
     */

    // generic
    $schemas = array(
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
        'changePassword' => array(
            'get' => MODULE . '/schemas/users.changePassword.get.json',
            'post' => MODULE . '/schemas/users.changePassword.post.json'
        ),
        'emails' => array(
            'resetPassword' => array(
                'get' => MODULE . '/schemas/emails.userStandard.get.json'
            ),
            'welcome' => array(
                'get' => MODULE . '/schemas/emails.userStandard.get.json'
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
     * Settings
     * 
     */

    // generic
    $settings = array(
        'cacheData' => false
    );

    /**
     * Views
     * 
     */

    // GET views
    $views = array(
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
        'changePassword' => array(
            'get' => MODULE . '/views/changePassword.inc.php',
            'post' => MODULE . '/views/raw.inc.php'
        ),
        'emails' => array(
            'welcome' => array(
                'get' => MODULE . '/views/emails/welcome.v1.inc.php',
                'post' => MODULE . '/views/raw.inc.php'
            ),
            'resetPassword' => array(
                'get' => MODULE . '/views/emails/resetPassword.v1.inc.php',
                'post' => MODULE . '/views/raw.inc.php'
            )
        )
    );

    // config storage
    \Plugin\Config::add(
        'TurtlePHP-UsersModule',
        array(
            'emails' => $emails,
            'memcached' => $memcached,
            'paths' => $paths,
            'schemas' => $schemas,
            'security' => $security,
            'settings' => $settings,
            'views' => $views
        )
    );
