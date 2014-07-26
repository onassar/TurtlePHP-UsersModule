<?php

    // closure (variable scope preservation)
    $closure = function() {

        // grab parent directory
        $info = pathinfo(__DIR__);
        $parent = $info['dirname'];

        // include functions, classes, controller
        require_once ($parent) . '/functions.inc.php';
        require_once ($parent) . '/Users.class.php';
        require_once ($parent) . '/models/User.class.php';
        require_once ($parent) . '/controllers/Users.class.php';

        // flow includes
        require_once 'requirements.inc.php';
        require_once 'config.inc.php';
        require_once 'routes.inc.php';
    };

    // run/clear
    $closure();
    unset($closure);
