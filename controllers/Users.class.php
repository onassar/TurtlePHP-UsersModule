<?php

    // namespaces
    namespace Modules\Users;

    /**
     * UsersController
     * 
     * @extends \Turtle\Controller
     * @final
     */
    final class UsersController extends \Turtle\Controller
    {
        /**
         * _actionChangePasswordGet
         * 
         * @access protected
         * @return void
         */
        protected function _actionChangePasswordGet()
        {
        }

        /**
         * _actionChangePasswordPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionChangePasswordPost()
        {
        }

        /**
         * _actionIndexGet
         * 
         * @access protected
         * @return void
         */
        protected function _actionIndexGet()
        {
        }

        /**
         * _actionIndexPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionIndexPost()
        {
            /**
             * Validation
             * 
             */

            // validate
            $schema = (new SmartSchema(
                APP . '/schemas/users.index.post.json',
                true
            ));
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_POST
            ));
            if ($validator->valid() === false) {

                // Baillll
                $response = array(
                    'success' => false,
                    'failedRules' => $validator->getFailedRules(false)
                );
                $this->_pass('response', json_encode($response));
            } else {

                /**
                 * Body
                 * 
                 */

                // Generate unique handle from the email
                $email = $_POST['email'];
                $fragments = explode('@', $email);
                $firstFragment = $fragments[0];
                $userModel = $this->_getModel('User');
                $username = $userModel->getUniqueUsername($firstFragment);

                // Newsletter check
                $receiveNewsletters = 0;
                if (isset($_POST['receiveNewsletters'])) {
                    $receiveNewsletters = 1;
                }

                // Defaults
                $config = getConfig();
                $role = getRole();
                $rate = $config['defaults'][$role]['rate'];
                $yearlyRate = $config['defaults'][$role]['yearlyRate'];
                $frequency = $config['defaults'][$role]['frequency'];
                $maxFreeImages = $config['defaults'][$role]['maxFreeImages'];

                // Default template
                $embedImageTemplateId = $config['defaults'][$role]['embedImageTemplateId'];

                // Create the user and log them in
                $userModel = $this->_getModel('User');
                $user = $userModel->createUser(array(
                    'type' => 'default',
                    'email' => $_POST['email'],
                    'username' => $username,
                    'watermarkJson' => json_encode($config['watermark']),
                    'rate' => $rate,
                    'yearlyRate' => $yearlyRate,
                    'frequency' => $frequency,
                    'maxFreeImages' => $maxFreeImages,
                    'registeredIPAddress' => IP,
                    'receiveImageRemixEmail' => 1,
                    'locationCity' => Geo::getCity(),
                    'locationCountryName' => Geo::getCountry(),
                    'locationRegionName' => Geo::getRegion(),
                    'locationCountryCode' => Geo::getCountryCode(2),
                    'embedImageTemplateId' => $embedImageTemplateId,
                    'embedTotalImageViews' => 0,
                    'embedTotalImagesSaved' => 0,
                    'receiveNewsletters' => $receiveNewsletters
                ));
                $user->update(array(
                    'publicKey' => $userModel->getUniquePublicKey()
                ));
                $user->setPassword($_POST['password']);
                $user->login();

                // Add to Campaign Monitor
                if ((int) $user->receiveNewsletters === 1) {
                    $user->addToFreeMailingList();
                }

                // Say hi :)
                // $user->sendWelcomeEmail();

                // Success, homie ;)
                $response = array(
                    'success' => true,
                    'data' => array(
                        'user' => $user->getPublicData()
                    )
                );
                $this->_pass('response', json_encode($response));
            }
        }

        /**
         * _actionLoginGet
         * 
         * @access protected
         * @return void
         */
        protected function _actionLoginGet()
        {
        }

        /**
         * _actionLoginPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionLoginPost()
        {
        }

        /**
         * _actionResetPasswordGet
         * 
         * @access protected
         * @return void
         */
        protected function _actionResetPasswordGet()
        {
        }

        /**
         * _actionResetPasswordPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionResetPasswordPost()
        {
        }

        /**
         * actionChangePassword
         * 
         * @access public
         * @return void
         */
        public function actionChangePassword()
        {
            if (!empty($_POST)) {
                $this->_actionChangePasswordPost();
            } else {
                $this->_actionChangePasswordGet();
            }
        }

        /**
         * actionIndex
         * 
         * @access public
         * @return void
         */
        public function actionIndex()
        {
            if (!empty($_POST)) {
                $this->_actionIndexPost();
            } else {
                $this->_actionIndexGet();
            }
        }

        /**
         * actionLogin
         * 
         * @access public
         * @return void
         */
        public function actionLogin()
        {
            if (!empty($_POST)) {
                $this->_actionLoginPost();
            } else {
                $this->_actionLoginGet();
            }
        }

        /**
         * actionLogout
         * 
         * @access public
         * @return void
         */
        public function actionLogout()
        {
        }

        /**
         * actionResetPassword
         * 
         * @access public
         * @return void
         */
        public function actionResetPassword()
        {
            if (!empty($_POST)) {
                $this->_actionResetPasswordPost();
            } else {
                $this->_actionResetPasswordGet();
            }
        }
    }
