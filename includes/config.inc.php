<?php

    // configuration init
    $callbacks = array();
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

    // grab parent directory
    $info = pathinfo(__DIR__);
    $parent = $info['dirname'];

    // GET views
    $views = array(
        'register' => ($parent) . '/views/register.inc.php',
        'login' => ($parent) . '/views/login.inc.php',
        'resetPassword' => ($parent) . '/views/resetPassword.inc.php',
        'changePassword' => ($parent) . '/views/changePassword.inc.php',
        'resetPasswordEmail' => ($parent) . '/views/emails/resetPassword.v1.inc.php',
        'welcomeEmail' => ($parent) . '/views/emails/welcome.v1.inc.php'
    );

    // config storage
    \Plugin\Config::add(
        'TurtlePHP-UsersModule',
        array(
            'callbacks' => $callbacks,
            'memcached' => $memcached,
            'views' => $views
        )
    );
