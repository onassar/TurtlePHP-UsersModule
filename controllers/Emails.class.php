<?php

    // namespaces
    namespace Modules\Users;

    /**
     * EmailsController
     * 
     * @note    No emails should be sent by this controller
     * @extends AppController
     * @final
     */
    final class EmailsController extends AppController
    {
        /**
         * __setView
         *
         * @access private
         * @param  string $action
         * @param  string $method
         * @return void
         */
        protected function __setView($action, $method)
        {
            $config = getConfig();
            parent::_setView($config['views']['emails'][$action][$method]);
        }

        /**
         * subjects
         *
         * Publically scoped to allow for closures.
         *
         * @var    array
         * @access public
         */
        public $subjects = array(
            'userWelcome' => 'Welcome',
            'userResetPassword' => 'Password reset'
        );

        /**
         * _getSchemaPath
         *
         * @access protected
         * @param  string $action
         * @param  string $method
         * @return string
         */
        protected function _getSchemaPath($action, $method)
        {
            $config = getConfig();
            return $config['schemas']['emails'][$action][$method];
        }

        /**
         * _validateUserSchema
         * 
         * @access protected
         * @param  string $action
         * @param  string $method
         * @return void
         */
        protected function _validateUserSchema($action, $method)
        {
            $_get = $this->getGet();
            $schema = (new \SmartSchema($this->_getSchemaPath(
                $action,
                $method
            )));
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_get
            ));
            if ($validator->valid() === false) {
                throw new \SchemaValidationException(
                    $this->_getFailedSchemaMessage($validator)
                );
            }
        }

        /**
         * actionUserWelcome
         * 
         * @access public
         * @return void
         */
        public function actionUserWelcome()
        {
            // Validate
            $_get = $this->getGet();
            if (!isset($_get['preview'])) {
                $this->_validateUserSchema('welcome', 'get');
            }

            // View
            $this->__setView('welcome', 'get');

            // Get user record
            $userModel = $this->_getModel('User');
            $user = $userModel->getUserById($_get['userId']);
            $this->_pass('user', $user);

            // callback (for sending the email)
            $self = $this;
            $this->getRequest()->addCallback(
                function($buffer) use ($self, $user) {

                    // Email should be preview
                    if ($self->isPreviewing()) {
                        exit($buffer);
                    } else {

                        // Send it off
                        sendEmail(
                            $user->email,
                            $self->subjects['userWelcome'],
                            $buffer,
                            'userWelcome'
                        );

                        // Donezo
                        return json_encode(array(
                            'success' => true
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
