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

    // GET views
    $views = array(
        'register' => MODULE . '/views/register.inc.php',
        'login' => MODULE . '/views/login.inc.php',
        'resetPassword' => MODULE . '/views/resetPassword.inc.php',
        'changePassword' => MODULE . '/views/changePassword.inc.php',
        'resetPasswordEmail' => MODULE . '/views/emails/resetPassword.v1.inc.php',
        'welcomeEmail' => MODULE . '/views/emails/welcome.v1.inc.php'
    );
print_r($views);
exit(0);
    // config storage
    \Plugin\Config::add(
        'TurtlePHP-UsersModule',
        array(
            'callbacks' => $callbacks,
            'memcached' => $memcached,
            'views' => $views
        )
    );
