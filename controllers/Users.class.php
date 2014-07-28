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
            parent::_setView($config['views'][$action][$method]);
        }

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
            $path = $this->_getSchemaPath('changePassword', 'get');
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
            $path = $this->_getSchemaPath('register', 'get');
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
            $config = getConfig();
            $view = $config['views']['register']['get'];
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
            $path = $this->_getSchemaPath('login', 'get');
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
            $config = getConfig();
            $view = $config['views']['login']['get'];
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
            $path = $this->_getSchemaPath('resetPassword', 'get');
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
            $config = getConfig();
            $view = $config['views']['resetPassword']['get'];
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
            return $config['schemas'][$action][$method];
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
                $this->_setView('changePassword', 'post');
                $this->_actionChangePasswordPost();
            } else {
                $this->_setView('changePassword', 'get');
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
                $this->_setView('register', 'post');
                $this->_actionIndexPost();
            } else {
                $this->_setView('register', 'get');
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
                $this->_setView('login', 'post');
                $this->_actionLoginPost();
            } else {
                $this->_setView('login', 'get');
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
            // View
            $this->_setView('logout', 'get');

            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->_getSchemaPath('logout', 'post');
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
                $this->_setView('resetPassword', 'post');
                $this->_actionResetPasswordPost();
            } else {
                $this->_setView('resetPassword', 'get');
                $this->_actionResetPasswordGet();
            }
        }
    }
