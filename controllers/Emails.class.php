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
         * __getTag
         *
         * @access private
         * @param  string $action
         * @return string
         */
        private function __getTag($action)
        {
            $config = getConfig();
            return $config['emails'][$action]['tag'];
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

                // Done
                throw new \SchemaValidationException(
                    \Modules\Users::getFailedSchemaMessage($validator)
                );
            }
        }

        /**
         * actionBypassPassword
         * 
         * @access public
         * @return void
         */
        public function actionBypassPassword()
        {
            // View
            $this->__setView('bypassPassword', 'get');

            /**
             * Validation
             * 
             */

            // Preview check
            $_get = $this->getGet();
            if (!isset($_get['preview'])) {
                $this->__validateUserSchema('bypassPassword', 'get');
            }

            /**
             * Body
             * 
             */

            // Get user record
            $userModel = $this->_getModel('Modules\\Users\\User');
            $user = $userModel->getUserById($_get['userId']);
            $this->_pass('user', $user);

            // callback (for sending the email)
            $self = $this;
            $subject = $this->__getSubject('bypassPassword');
            $tag = $this->__getTag('bypassPassword');
            $this->getRequest()->addCallback(
                function($buffer) use ($self, $subject, $tag, $user) {

                    // Email should be preview
                    if ($self->isPreviewing()) {
                        exit($buffer);
                    } else {

                        // Send it off
                        $response = \Plugin\Emailer::send(
                            $user->email,
                            $subject,
                            $buffer,
                            $tag,
                            true,
                            false,
                            false,
                            false,
                            $self->getSignature('bypassPassword')
                        ); 

                        // Donezo
                        return json_encode(array(
                            'success' => $response !== false,
                            'data' => $response
                        ));
                    }
                }
            );
        }

        /**
         * actionResetPassword
         * 
         * @access public
         * @return void
         */
        public function actionResetPassword()
        {
            // View
            $this->__setView('resetPassword', 'get');

            /**
             * Validation
             * 
             */

            // Preview check
            $_get = $this->getGet();
            if (!isset($_get['preview'])) {
                $this->__validateUserSchema('resetPassword', 'get');
            }

            /**
             * Body
             * 
             */

            // Get user record
            $userModel = $this->_getModel('Modules\\Users\\User');
            $user = $userModel->getUserById($_get['userId']);
            $this->_pass('user', $user);
            $this->_pass('randomPassword', $_get['randomPassword']);

            // callback (for sending the email)
            $self = $this;
            $subject = $this->__getSubject('resetPassword');
            $tag = $this->__getTag('resetPassword');
            $this->getRequest()->addCallback(
                function($buffer) use ($self, $subject, $tag, $user) {

                    // Email should be preview
                    if ($self->isPreviewing()) {
                        exit($buffer);
                    } else {

                        // Send it off
                        $response = \Plugin\Emailer::send(
                            $user->email,
                            $subject,
                            $buffer,
                            $tag,
                            true,
                            false,
                            false,
                            false,
                            $self->getSignature('resetPassword')
                        );

                        // Donezo
                        return json_encode(array(
                            'success' => $response !== false,
                            'data' => $response
                        ));
                    }
                }
            );
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
            $userModel = $this->_getModel('Modules\\Users\\User');
            $user = $userModel->getUserById($_get['userId']);
            $this->_pass('user', $user);

            // callback (for sending the email)
            $self = $this;
            $subject = $this->__getSubject('welcome');
            $tag = $this->__getTag('welcome');
            $this->getRequest()->addCallback(
                function($buffer) use ($self, $subject, $tag, $user) {

                    // Email should be preview
                    if ($self->isPreviewing()) {
                        exit($buffer);
                    } else {

                        // Send it off
                        $response = \Plugin\Emailer::send(
                            $user->email,
                            $subject,
                            $buffer,
                            $tag,
                            true,
                            false,
                            false,
                            false,
                            $self->getSignature('welcome')
                        );

                        // Donezo
                        return json_encode(array(
                            'success' => $response !== false,
                            'data' => $response
                        ));
                    }
                }
            );
        }

        /**
         * getSignature
         * 
         * @access public
         * @param  string $action
         * @return string
         */
        public function getSignature($action)
        {
            $config = getConfig();
            return $config['emails'][$action]['signature'];
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
