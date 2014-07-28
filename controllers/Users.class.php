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
         * @access protected
         * @param  string $action
         * @param  string $method
         * @return string
         */
        protected function __getSchemaPath($action, $method)
        {
            $config = getConfig();
            return $config['schemas'][$action][$method];
        }

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
            $path = $this->__getSchemaPath('register', 'get');
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest()
            ));

            // Bail if invalid
            if ($validator->valid() === false) {

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, false, $args);

                // Done
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

            // Parent
            $args = func_get_args();
            $this->__callParent(__FUNCTION__, true, $args);
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
            //     $userModel = $this->_getModel('User');
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
            //     $userModel = $this->_getModel('User');
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
$user = \getLoggedInUser();
$user->sendWelcomeEmail();
exit(0);
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
            $path = $this->__getSchemaPath('logout', 'post');
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
            $loggedInUser = \getLoggedInUser();
            $loggedInUser->logout();
            $response = array(
                'success' => true
            );
            $this->_pass('response', json_encode($response));
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
