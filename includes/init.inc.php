<?php

    // namespaces
    namespace Modules\Users;

    // closure (variable scope preservation)
    $closure = function() {

        // grab parent directory
        $info = pathinfo(__DIR__);
        $parent = $info['dirname'];

        // module path
        DEFINE(__NAMESPACE__ . '\MODULE', $parent);

        // include models, controllers, helpers
        require_once MODULE . '/models/User.class.php';
        require_once MODULE . '/controllers/Users.class.php';
        require_once MODULE . '/controllers/Emails.class.php';
        require_once MODULE . '/controllers/Crons.class.php';
        require_once MODULE . '/includes/validation/ProjectSchemaValidator.class.php';

        // flow includes
        require_once MODULE . '/functions/local.inc.php';
        require_once MODULE . '/functions/global.inc.php';
        require_once 'requirements.inc.php';
        require_once \Modules\Users::getConfigPath();
        require_once 'routes.inc.php';

        // overhead
        if (getConfig('defaults', 'autoLogin') === true) {
            \Modules\Users::autoLogin();
        }
        if (getConfig('defaults', 'trackLastActive') === true) {
            \Modules\Users::trackLastActive();
        }
    };

    // run/clear
    $closure();
    unset($closure);
