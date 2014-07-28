<?php

    // modules namespace
    namespace Modules;

    /**
     * UsersModule
     * 
     * @author   Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Users
    {
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
         * openSession
         * 
         * @access public
         * @static
         * @return void
         */
        public static function openSession()
        {
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
         * getFailedSchemaMessage
         *
         * @access public
         * @static
         * @param  ProjectSchemaValidator $validator
         * @return string
         */
        public function getFailedSchemaMessage(
            ProjectSchemaValidator $validator
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

    }
