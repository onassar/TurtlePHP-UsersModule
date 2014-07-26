<?php

    // namespaces
    namespace Modules\Users;

    // dependencies
    require_once MODULE . '/controllers/App.class.php';

    /**
     * UsersController
     * 
     * @extends AppController
     * @final
     */
    final class UsersController extends AppController
    {
        /**
         * _actionChangePasswordGet
         * 
         * @access protected
         * @return void
         */
        protected function _actionChangePasswordGet()
        {
            /**
             * Validation
             * 
             */

            // Schema
            $path = MODULE . '/schemas/users.changePassword.get.json';
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest()
            ));

            // Bail if invalid
            if ($validator->valid() === false) {
                throw new \SchemaValidationException(
                    $this->_getFailedSchemaMessage($validator)
                );
            }

            /**
             * Body
             * 
             */

            // View
            $config = \Modules\Users::getConfig();
            $view = $config['views']['changePassword'];
            $this->_setView($view);

            // User
            $loggedInUser = getLoggedInUser();
            $this->_pass('loggedInUser', $loggedInUser);
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
            /**
             * Validation
             * 
             */

            // Schema
            $path = MODULE . '/schemas/users.index.get.json';
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest()
            ));

            // Bail if invalid
            if ($validator->valid() === false) {
                throw new \SchemaValidationException(
                    $this->_getFailedSchemaMessage($validator)
                );
            }

            /**
             * Body
             * 
             */

            // View
            $config = \Modules\Users::getConfig();
            $view = $config['views']['register'];
            $this->_setView($view);
        }

        /**
         * _actionIndexPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionIndexPost()
        {
            // /**
            //  * Validation
            //  * 
            //  */

            // // validate
            // $schema = (new SmartSchema(
            //     APP . '/schemas/users.index.post.json',
            //     true
            // ));
            // $validator = (new ProjectSchemaValidator(
            //     $schema,
            //     $this->getRequest(),
            //     $_POST
            // ));
            // if ($validator->valid() === false) {

            //     // Baillll
            //     $response = array(
            //         'success' => false,
            //         'failedRules' => $validator->getFailedRules(false)
            //     );
            //     $this->_pass('response', json_encode($response));
            // } else {

            //     /**
            //      * Body
            //      * 
            //      */

            //     // Generate unique handle from the email
            //     $email = $_POST['email'];
            //     $fragments = explode('@', $email);
            //     $firstFragment = $fragments[0];
            //     $userModel = $this->_getModel('\Modules\Users\User');
            //     $username = $userModel->getUniqueUsername($firstFragment);

            //     // Newsletter check
            //     $receiveNewsletters = 0;
            //     if (isset($_POST['receiveNewsletters'])) {
            //         $receiveNewsletters = 1;
            //     }

            //     // Create the user and log them in
            //     $user = $userModel->createUser(array(
            //         'type' => 'default',
            //         'email' => $_POST['email'],
            //         'username' => $username,
            //         'publicKey' => $userModel->getUniquePublicKey(),
            //         'registeredIPAddress' => IP,
            //         'locationCity' => Geo::getCity(),
            //         'locationCountryName' => Geo::getCountry(),
            //         'locationRegionName' => Geo::getRegion(),
            //         'locationCountryCode' => Geo::getCountryCode(2),
            //         'receiveNewsletters' => $receiveNewsletters
            //     ));
            //     $user->setPassword($_POST['password']);
            //     $user->login();

            //     // Add to Campaign Monitor
            //     if ((int) $user->receiveNewsletters === 1) {
            //         $user->addToFreeMailingList();
            //     }

            //     // Say hi :)
            //     // $user->sendWelcomeEmail();

            //     // Success, homie ;)
            //     $response = array(
            //         'success' => true,
            //         'data' => array(
            //             'user' => $user->getPublicData()
            //         )
            //     );
            //     $this->_pass('response', json_encode($response));
            // }
        }

        /**
         * _actionLoginGet
         * 
         * @access protected
         * @return void
         */
        protected function _actionLoginGet()
        {
            /**
             * Validation
             * 
             */

            // Schema
            $path = MODULE . '/schemas/users.login.get.json';
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest()
            ));

            // Bail if invalid
            if ($validator->valid() === false) {
                throw new \SchemaValidationException(
                    $this->_getFailedSchemaMessage($validator)
                );
            }

            /**
             * Body
             * 
             */

            // View
            $config = \Modules\Users::getConfig();
            $view = $config['views']['login'];
            $this->_setView($view);
        }

        /**
         * _actionLoginPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionLoginPost()
        {
            /**
             * Validation
             * 
             */

            // // validate
            // $schema = (new SmartSchema(
            //     APP . '/schemas/users.login.post.json',
            //     true
            // ));
            // $validator = (new ProjectSchemaValidator(
            //     $schema,
            //     $this->getRequest(),
            //     $_POST
            // ));
            // if ($validator->valid() === false) {

            //     // Baillll
            //     $response = array(
            //         'success' => false,
            //         'failedRules' => $validator->getFailedRules(false)
            //     );
            //     $this->_pass('response', json_encode($response));
            // } else {

            //     /**
            //      * Body
            //      * 
            //      */

            //     // Log them in
            //     $userModel = $this->_getModel('\Modules\Users\User');
            //     $user = $userModel->getUserByEmail($_POST['email']);
            //     $user->login();

            //     // Success, homie ;)
            //     $response = array(
            //         'success' => true,
            //         'data' => array(
            //             'user' => $user->getPublicData()
            //         )
            //     );
            //     $this->_pass('response', json_encode($response));

            //     // Callbacks
            //     $callbacks = $config['callbacks']['changePassword'];
            //     foreach ($callbacks as $callback) {
            //         call_user_func($callback);
            //     }
            // }
        }

        /**
         * _actionResetPasswordGet
         * 
         * @access protected
         * @return void
         */
        protected function _actionResetPasswordGet()
        {
            /**
             * Validation
             * 
             */

            // Schema
            $path = MODULE . '/schemas/users.resetPassword.get.json';
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest()
            ));

            // Bail if invalid
            if ($validator->valid() === false) {
                throw new \SchemaValidationException(
                    $this->_getFailedSchemaMessage($validator)
                );
            }

            /**
             * Body
             * 
             */

            // View
            $config = \Modules\Users::getConfig();
            $view = $config['views']['resetPassword'];
            $this->_setView($view);
        }

        /**
         * _actionResetPasswordPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionResetPasswordPost()
        {
// 
// 
// 
// 
// 
// 
// 
// 
// 
//             
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
            /**
             * Validation
             * 
             */

            // Schema
            $path = MODULE . '/schemas/users.logout.post.json';
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_POST
            ));

            // Bail if invalid
            if ($validator->valid() === false) {
                throw new \SchemaValidationException(
                    $this->_getFailedSchemaMessage($validator)
                );
            }

            /**
             * Body
             * 
             */

            // Yup
            $loggedInUser = getLoggedInUser();
            $loggedInUser->logout();
            $response = array(
                'success' => true
            );
            $this->_pass('response', json_encode($response));

            // Callbacks
            $callbacks = $config['callbacks']['changePassword'];
            foreach ($callbacks as $callback) {
                call_user_func($callback);
            }
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
