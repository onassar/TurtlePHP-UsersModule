<?php

    // namespaces
    namespace Modules\Users;

    /**
     * Plugin/vendors Requirements
     * 
     */

    // hash
    $required = array(
        '\Plugin\Config' => 'TurtlePHP-ConfigPlugin',
        'Email' => 'PHP-Email',
        '\Postmark\Mail' => 'postmark-php',
        'Geo' => 'PHP-Geo',
        'RequestCache' => 'PHP-RequestCache',
        'MySQLQuery' => 'PHP-MySQL',
        'Query' => 'PHP-Query',
        'SMSession' => 'PHP-SecureSessions',
        'Schema' => 'PHP-JSON-Validation',
        'SmartSchema' => 'PHP-JSON-Validation',
        'Schema' => 'PHP-JSON-Validation'
    );

    // checks
    foreach ($required as $class => $package) {
        if (!class_exists($class)) {
            throw new \Exception(
                'Class *' . ($class) . '* couldn\'t be found. Ensure it, and ' .
                'it\'s associated library (' . ($package) . ') are properly ' .
                'included.'
            );
        }
    }

    /**
     * Application requirements
     * 
     */

    // hash
    $required = array(
        'UsersController',
        'UserAccessor',
        'UserModel',
        'EmailsController'
    );

    // checks
    foreach ($required as $class) {
        if (!class_exists($class)) {
            throw new \Exception(
                'Class *' . ($class) . '* couldn\'t be found. Load it!'
            );
        }
    }
