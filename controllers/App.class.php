<?php

    // namespaces
    namespace Modules\Users;

    /**
     * AppController
     * 
     * @extends \Turtle\Controller
     */
    class AppController extends \Turtle\Controller
    {
        /**
         * _generateAndStoreCsrfToken
         *
         * @access protected
         * @return void
         */
        protected function _generateAndStoreCsrfToken()
        {
            if (!isset($_SESSION['csrfToken'])) {
                $_SESSION['csrfToken'] = getRandomHash();
            }
        }

        /**
         * _getFailedSchemaMessage
         *
         * @access protected
         * @param  ProjectSchemaValidator $validator
         * @return string
         */
        protected function _getFailedSchemaMessage(
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

        /**
         * prepare
         *
         * @access public
         * @return void
         */
        public function prepare()
        {
            // Pass in the Csrf token
            $this->_generateAndStoreCsrfToken();
            $this->_pass('csrfToken', $_SESSION['csrfToken']);

            // parental guidance :)
            parent::prepare();
        }
    }
