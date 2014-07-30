<?php

    // namespaces
    namespace Modules\Users;

    /**
     * EmailsController
     * 
     * @note    No emails should be sent by this controller
     * @extends \EmailsController
     * @final
     */
    final class EmailsController extends \EmailsController
    {
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
            $config = getConfig();
            return $config['schemas']['emails'][$action][$method];
        }

        /**
         * __getSubject
         *
         * @access private
         * @param  string $action
         * @return string
         */
        private function __getSubject($action)
        {
            $config = getConfig();
            return $config['emails'][$action]['subject'];
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
            parent::_setView($config['views']['emails'][$action][$method]);
        }

        /**
         * __validateUserSchema
         * 
         * @access private
         * @param  string $action
         * @param  string $method
         * @return void
         */
        private function __validateUserSchema($action, $method)
        {
            $_get = $this->getGet();
            $schema = (new \SmartSchema($this->__getSchemaPath(
                $action,
                $method
            )));
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_get
            ));
            if ($validator->valid() === false) {

                // Parent
                // $args = func_get_args();
                // $this->__callParent(__FUNCTION__, false, $args);

                // Done
                throw new \SchemaValidationException(
                    $this->_getFailedSchemaMessage($validator)
                );
            }
        }

        /**
         * actionWelcome
         * 
         * @access public
         * @return void
         */
        public function actionWelcome()
        {
            // View
            $this->__setView('welcome', 'get');

            /**
             * Validation
             * 
             */

            // Preview check
            $_get = $this->getGet();
            if (!isset($_get['preview'])) {
                $this->__validateUserSchema('welcome', 'get');
            }

            /**
             * Body
             * 
             */

            // Get user record
            $userModel = $this->_getModel('Modules\Users\User');
            $user = $userModel->getUserById($_get['userId']);
            $this->_pass('user', $user);

            // callback (for sending the email)
            $self = $this;
            $subject = $this->__getSubject('welcome');
            $this->getRequest()->addCallback(
                function($buffer) use ($self, $subject, $user) {

                    // Email should be preview
                    if ($self->isPreviewing()) {
                        exit($buffer);
                    } else {

                        // Send it off
                        // $response = sendEmail(
                        //     $user->email,
                        //     $subject,
                        //     $buffer,
                        //     'welcome'
                        // );

                        // Parent
                        $args = func_get_args();
                        // $this->__callParent(__FUNCTION__, true, $args);

                        // 

                        // Donezo
                        return json_encode(array(
                            'success' => true,
                            'data' => $response
                        ));
                    }
                }
            );
        }

        /**
         * isPreviewing
         * 
         * @note   Has to be scoped public for closures to access (aka. proxy)
         * @access public
         * @return boolean
         */
        public function isPreviewing()
        {
            $_get = $this->getGet();
            return isset($_get['preview']);
        }
    }
