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
         * _getPostmarkEmailResource
         * 
         * @access protected
         * @return PostmarkEmail
         */
        protected function _getPostmarkEmailResource()
        {
            if (defined('POSTMARKAPP_API_KEY') === false) {
                $config = getConfig();
                $postmarkConfig = $config['postmark'];
                define('POSTMARKAPP_API_KEY', $postmarkConfig['key']);
                define('POSTMARKAPP_MAIL_FROM_ADDRESS', $postmarkConfig['from']['email']);
                define('POSTMARKAPP_MAIL_FROM_NAME', $postmarkConfig['from']['name']);
            }
            if (is_null($this->_postmarkEmailResource)) {
                $this->_postmarkEmailResource = (new PostmarkEmail());
            }
            return $this->_postmarkEmailResource;
        }

        /**
         * _validateUserSchema
         * 
         * @access protected
         * @return void
         */
        protected function _validateUserSchema()
        {
            $_get = $this->getGet();
            $schema = (new SmartSchema(
                APP . '/schemas/emails.userStandard.get.json'
            ));
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_get
            ));
            if ($validator->valid() === false) {
                throw new SchemaValidationException(
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
                $this->_validateUserSchema();
            }

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
