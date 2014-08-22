<?php

    // namespaces
    namespace Modules\Users;

    /**
     * CronsController
     * 
     * @extends \CronsController
     * @final
     */
    final class CronsController extends \CronsController
    {
        /**
         * __callParent
         * 
         * @access private
         * @param  string $name
         * @param  boolean $passed
         * @param  array $args (default: array)
         * @return void
         */
        private function __callParent($name, $passed, array $args = array())
        {
            $parent = array('parent', $name);
            if (is_callable($parent)) {
                define('PASSED', $passed);
                call_user_func_array($parent, $args);
            }
        }

        /**
         * __getSchemaPath
         *
         * @access private
         * @param  string $action
         * @param  string $method
         * @return string
         */
        private function __getSchemaPath($action, $method)
        {
            return getConfig('schemas', 'crons', $action, $method);
        }

        /**
         * __setView
         *
         * @access private
         * @param  string $action
         * @param  string $method
         * @return void
         */
        private function __setView($action, $method)
        {
            $config = getConfig();
            parent::_setView($config['views']['crons'][$action][$method]);
        }

        /**
         * actionSendWelcomeEmails
         * 
         * @runs      Every weekday between 9am (14U) and 5pm (22U)
         * @frequency Every 17 minutes
         * @crontab   17,34,51 14,15,16,17,18,19,20,21 * * 1,2,3,4,5 wget https://{host}/crons/users/sendWelcomeEmails --tries=1 --quiet --output-document /dev/null --timeout=120
         * @access    public
         * @return    void
         */
        public function actionSendWelcomeEmails()
        {
            // View
            $this->__setView('sendWelcomeEmails', 'get');

            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('sendWelcomeEmails', 'get');
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest()
            ));

            /**
             * Validation failed
             * 
             */
            if ($validator->valid() === false) {

                // Failed response
                $response = array(
                    'success' => false,
                    'failedRules' => $validator->getFailedRules(false)
                );
                $this->_pass('response', json_encode($response));

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, false, $args);
            }
            /**
             * Body
             * 
             */
            else {

                // Not the best validation check, but good for now
                if (getConfig('emails', 'welcome', 'cron') === true) {

                    // Get the users
                    $userModel = $this->_getModel('Modules\\Users\\User');
                    $waitTime = getConfig('emails', 'welcome', 'cronWaitTime');
                    $users = $userModel->getUsers(
                        0,
                        getConfig('defaults', 'welcomeEmailsCronBatchCount'),
                        array(
                            array('hasReceivedWelcomeEmail', 0),
                            array(
                                'UNIX_TIMESTAMP()',
                                '>',
                                '(created + ' . ($waitTime) . ')',
                                false
                            )
                        ),
                        false
                    );

                    // Mark that the email has been sent
                    foreach ($users as $user) {
                        $user->sendWelcomeEmail();
                    }
                }

                // Cron completed message
                $this->_pass(
                    'response',
                    'Donezo w/ actionSendWelcomeEmails!'
                );

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
        }
    }
