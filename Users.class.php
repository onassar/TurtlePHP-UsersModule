<?php

    // modules namespace
    namespace Modules;

    /**
     * Users
     * 
     * Helper methods that are used by the module
     * 
     * @author   Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Users
    {
        /**
         * _configPath
         *
         * @var    string
         * @access protected
         * @static
         */
        protected static $_configPath = 'config.default.inc.php';

        /**
         * autoLogin
         *
         * @access public
         * @static
         * @return void
         */
        public static function autoLogin()
        {
            $loggedInUser = getLoggedInUser();
            if ($loggedInUser === false) {

                // Cookie check
                if (
                    isset($_COOKIE['isLoggedIn'])
                    && $_COOKIE['isLoggedIn'] === '1'
                    && isset($_COOKIE['loginHash'])
                ) {
                    $userModel = \Turtle\Application::getModel(
                        'Modules\\Users\\User'
                    );
                    $user = $userModel->getUserByLoginHash(
                        $_COOKIE['loginHash']
                    );
                    if ($user !== false) {
                        $defaults = \Modules\Users::getConfig('defaults');
                        $expire = 0;
                        if ($defaults['rememberMe'] === true) {
                            $expire = time() + (10 * 365 * 24 * 60 * 60);
                        }
                        $user->login($expire);
                    }
                }

                // GET check
                if (isset($_GET['loginHash'])) {
                    $userModel = \Turtle\Application::getModel(
                        'Modules\\Users\\User'
                    );
                    $user = $userModel->getUserByLoginHash(
                        $_GET['loginHash']
                    );
                    if ($user !== false) {
                        $defaults = \Modules\Users::getConfig('defaults');
                        $expire = 0;
                        if ($defaults['rememberMe'] === true) {
                            $expire = time() + (10 * 365 * 24 * 60 * 60);
                        }
                        $user->login($expire);

                        // Send to path without query param
                        $parsed = parse_url($_SERVER['REQUEST_URI']);
                        header('Location: ' . ($parsed['path']));
                        exit(0);
                    }
                }
            }
        }

        /**
         * generateAndStoreCsrfToken
         *
         * @access public
         * @static
         * @return void
         */
        public static function generateAndStoreCsrfToken()
        {
            if (!isset($_SESSION['csrfToken'])) {
                $_SESSION['csrfToken'] = \Modules\Users\getRandomHash();
            }
        }

        /**
         * getConfig
         * 
         * @access public
         * @static
         * @return array
         */
        public static function getConfig()
        {
            $args = func_get_args();
            return call_user_func_array(
                array('\Plugin\Config', 'retrieve'),
                $args
            );
        }

        /**
         * getConfigPath
         * 
         * @access public
         * @return string
         */
        public static function getConfigPath()
        {
            return self::$_configPath;
        }

        /**
         * getFailedSchemaMessage
         *
         * @access public
         * @static
         * @param  \Modules\Users\ProjectSchemaValidator $validator
         * @return string
         */
        public static function getFailedSchemaMessage(
            \Modules\Users\ProjectSchemaValidator $validator
        ) {
            // Failed rule
            $failedRules = $validator->getFailedRules();
            $firstFailedRule = ($failedRules[0]['validator'][0]) . '::' .
                ($failedRules[0]['validator'][1]);

            // Schema name
            $schema = $validator->getSchema();
            $schemaPath = $schema->getPath();
            $schemaName = basename($schemaPath);

            // Messaging
            return 'Error validating ' . ($schemaName) . ' (' .
                ($firstFailedRule) . ')';
        }

        /**
         * setConfigPath
         * 
         * @access public
         * @param  string $path
         * @return void
         */
        public static function setConfigPath($path)
        {
            self::$_configPath = $path;
        }

        /**
         * trackLastActive
         *
         * @access public
         * @static
         * @return void
         */
        public static function trackLastActive()
        {
            $loggedInUser = getLoggedInUser();
            if ($loggedInUser !== false) {
                $loggedInUser->update(array(
                    'lastActiveEpoch' => time()
                ));
            }
        }
    }

    // non-default config file check
    $info = pathinfo(__DIR__);
    $parent = ($info['dirname']) . '/' . ($info['basename']);
    $configPath = $parent . '/includes/config.inc.php';
    if (is_file($configPath)) {
        Users::setConfigPath($configPath);
    }
