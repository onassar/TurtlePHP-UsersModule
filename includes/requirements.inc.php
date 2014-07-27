<?php

    // namespaces
    namespace Modules\Users;

    /**
     * Class Requirements
     * 
     */

    // required classes
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
