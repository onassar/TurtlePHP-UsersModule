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
            // configuration settings
            $config = \Plugin\Config::retrieve();
            $config = $config['TurtlePHP-UsersModule'];
            return $config;
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
    }

    // non-default config file check
    $info = pathinfo(__DIR__);
    $parent = ($info['dirname']) . '/' . ($info['basename']);
    $configPath = $parent . '/includes/config.inc.php';
    if (is_file($configPath)) {
        Users::setConfigPath($configPath);
    }
