<?php

    /**
     * Class Requirements
     * 
     */

    // required classes
    $required = array(
        'Email' => 'PHP-Email',
        'Geo' => 'PHP-Geo',
        '\Plugin\Config' => 'PHP-JSON-Validation',
        'MemcachedCache' => 'PHP-MemcachedCache',
        'MySQLQuery' => 'PHP-MySQL',
        'Query' => 'PHP-Query',
        'RequestCache' => 'PHP-RequestCache',
        'SMSession' => 'PHP-SecureSessions'
    );

    // perform checks
    foreach ($required as $class => $package) {

        // not found
        if (!class_exists($class)) {

            // error out
            throw new Exception(
                'Class *' . ($class) . '* couldn\'t be found. Ensure it, and ' .
                'it\'s associated library (' . ($package) . ') are properly ' .
                'included.'
            );
        }
    }
