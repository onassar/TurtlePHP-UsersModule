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
         * _validateSchema
         * 
         * @access protected
         * @return void
         */
        protected function _validateSchema()
        {
            $schema = (new SmartSchema(
                APP . '/schemas/crons.standard.get.json'
            ));
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest()
            ));
            if ($validator->valid() === false) {
                throw new SchemaValidationException(
                    $this->_getFailedSchemaMessage($validator)
                );
            }
        }

        /**
         * actionUsersSendWelcomeEmails
         * 
         * @runs      Every weekday between 9am (14U) and 5pm (22U)
         * @frequency Every 17 minutes
         * @crontab   17,34,51 14,15,16,17,18,19,20,21 * * 1,2,3,4,5 wget https://{host}/crons/users/sendWelcomeEmails --tries=1 --quiet --output-document /dev/null --timeout=120
         * @access    public
         * @return    void
         */
        public function actionUsersSendWelcomeEmails()
        {
            // Validate
            $this->_validateSchema();

            // Get the users
            $userModel = $this->_getModel('User');
            $waitTime = getConfig('emails', 'welcome', 'waitTime');
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

            // Parent
            $args = func_get_args();
            $this->__callParent(__FUNCTION__, true, $args);

            // Cron completed message
            $this->_pass(
                'response',
                'Donezo w/ actionUsersSendWelcomeEmails!'
            );
        }
    }
