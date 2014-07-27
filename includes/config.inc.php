<?php

    // namespaces
    namespace Modules\Users;

    // configuration init
    $callbacks = array();
    $memcached = array();
    $paths = array();
    $schemas = array();
    $settings = array();
    $views = array();

    /**
     * Callbacks
     * 
     */

    // POST callbacks
    $callbacks = array(
        'register' => array(),
        'login' => array(),
        'resetPassword' => array(),
        'changePassword' => array()
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
            'user' => array(
                'welcome' => '/emails/user/welcome',
                'resetPassword' => '/emails/user/resetPassword'
            )
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
            'user' => array(
                'resetPassword' => array(
                    'get' => MODULE . '/schemas/emails.userStandard.get.json'
                ),
                'welcome' => array(
                    'get' => MODULE . '/schemas/emails.userStandard.get.json'
                )
            )
        )
    );

    /**
     * Settings
     * 
     */

    // generic
    $settings = array(
        'checkForSchema' => true,
        'cacheData' => false
    );

    /**
     * Views
     * 
     */

    // GET views
    $views = array(
        'register' => MODULE . '/views/register.inc.php',
        'login' => MODULE . '/views/login.inc.php',
        'resetPassword' => MODULE . '/views/resetPassword.inc.php',
        'changePassword' => MODULE . '/views/changePassword.inc.php',
        'resetPasswordEmail' => MODULE . '/views/emails/resetPassword.v1.inc.php',
        'welcomeEmail' => MODULE . '/views/emails/welcome.v1.inc.php'
    );

    // config storage
    \Plugin\Config::add(
        'TurtlePHP-UsersModule',
        array(
            'callbacks' => $callbacks,
            'memcached' => $memcached,
            'paths' => $paths,
            'schemas' => $schemas,
            'settings' => $settings,
            'views' => $views
        )
    );
