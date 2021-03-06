<?php

    // namespaces
    namespace Modules\Users;

    /**
     * UsersController
     * 
     * @extends \UsersController
     * @final
     */
    final class UsersController extends \UsersController
    {
        /**
         * prepare
         *
         * @access public
         * @return void
         */
        public function prepare()
        {
            // Pass in the Csrf token
            \Modules\Users::generateAndStoreCsrfToken();
            $this->_pass('csrfToken', $_SESSION['csrfToken']);

            // parental guidance :)
            parent::prepare();
        }

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
            return getConfig('schemas', $action, $method);
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
            $path = $this->__getSchemaPath('changePassword', 'get');
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

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, false, $args);
                }
                // Otherwise
                else {

                    // Send to login
                    $config = getConfig();
                    $redirectGetRequestsOnError = getConfig(
                        'defaults',
                        'redirectGetRequestsOnError'
                    );
                    if ($redirectGetRequestsOnError === true) {
                        header('Location: ' . ($config['paths']['login']));
                        exit(0);
                    }

                    // Exception
                    throw new \SchemaValidationException(
                        \Modules\Users::getFailedSchemaMessage($validator)
                    );
                }
            }
            /**
             * Body
             * 
             */
            else {

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
        }

        /**
         * _actionChangePasswordPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionChangePasswordPost()
        {
            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('changePassword', 'post');
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_POST
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

                // Logic
                $liu = \getLoggedInUser();
                $liu->setPassword($_POST['password']);

                // Response
                $response = array(
                    'success' => true,
                    'data' => array(
                        'user' => $liu->getPublicData()
                    )
                );
                $this->_pass('response', json_encode($response));

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
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

            /**
             * Validation failed
             * 
             */
            if ($validator->valid() === false) {

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, false, $args);
                }
                // Otherwise
                else {

                    // Send to dashboard
                    $config = getConfig();
                    $redirectGetRequestsOnError = getConfig(
                        'defaults',
                        'redirectGetRequestsOnError'
                    );
                    if ($redirectGetRequestsOnError === true) {
                        header('Location: ' . ($config['paths']['dashboard']));
                        exit(0);
                    }

                    // Exception
                    throw new \SchemaValidationException(
                        \Modules\Users::getFailedSchemaMessage($validator)
                    );
                }
            }
            /**
             * Body
             * 
             */
            else {

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
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

            // Schema
            $path = $this->__getSchemaPath('register', 'post');
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_POST
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

                // Username
                $email = $_POST['email'];
                $fragments = explode('@', $email);
                $firstFragment = $fragments[0];
                $userModel = $this->_getModel('Modules\\Users\\User');
                $username = $userModel->getUniqueUsername($firstFragment);

                // Newsletter
                $receiveNewsletters = 0;
                if (isset($_POST['receiveNewsletters'])) {
                    $receiveNewsletters = 1;
                }

                // Create the user
                $user = $userModel->createUser(array(
                    'publicKey' => $userModel->getUniquePublicKey(),
                    'firstName' => isset($_POST['firstName'])
                        ? $_POST['firstName']
                        : '',
                    'lastName' => isset($_POST['lastName'])
                        ? $_POST['lastName']
                        : '',
                    'email' => $_POST['email'],
                    'username' => $username,
                    'registeredIPAddress' => IP,
                    'locationCity' => \Geo::getCity(),
                    'locationCountryName' => \Geo::getCountry(),
                    'locationRegionName' => \Geo::getRegion(),
                    'locationCountryCode' => \Geo::getCountryCode(2),
                    'receiveNewsletters' => $receiveNewsletters
                ));

                // Stripe checkout
                if (getConfig('defaults', 'stripeCheckout') === true) {
                    if (isset($_POST['planId'])) {

                        // Stripe records
                        try {
                            $stripeCustomer = \Modules\Stripe::checkout(
                                $user,
                                $_POST['strokeToken'],
                                (int) $_POST['planId'],
                                $_POST['province']
                            );
                        } catch (Exception $exception) {
                            $user->delete();
                        }
                    }
                }

                // Password + login
                $user->setPassword($_POST['password']);
                $config = getConfig();
                $defaults = $config['defaults'];
                $expire = 0;
                if ($defaults['rememberMe'] === true) {
                    $expire = time() + ($defaults['rememberMeDuration']);
                }
                $user->login($expire);

                // Welcome email
                $config = getConfig();
                if ($config['emails']['welcome']['autoSend'] === true) {
                    $emailResponse = $user->sendWelcomeEmail();
                }

                // Response
                $response = array(
                    'success' => true,
                    'data' => array(
                        'user' => $user->getPublicData()
                    )
                );
                $this->_pass('response', json_encode($response));

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
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
            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('login', 'get');
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

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, false, $args);
                }
                // Otherwise
                else {

                    // Send to dashboard
                    $config = getConfig();
                    $redirectGetRequestsOnError = getConfig(
                        'defaults',
                        'redirectGetRequestsOnError'
                    );
                    if ($redirectGetRequestsOnError === true) {
                        header('Location: ' . ($config['paths']['dashboard']));
                        exit(0);
                    }

                    // Exception
                    throw new \SchemaValidationException(
                        \Modules\Users::getFailedSchemaMessage($validator)
                    );
                }
            }
            /**
             * Body
             * 
             */
            else {

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
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

            // Schema
            $path = $this->__getSchemaPath('login', 'post');
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_POST
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

                // Logic
                $userModel = $this->_getModel('Modules\\Users\\User');
                $user = $userModel->getUserByEmail($_POST['email']);
                $defaults = getConfig('defaults');
                $expire = 0;
                if (
                    $defaults['rememberMe'] === true
                    && isset($_POST['rememberMe']) === true
                ) {
                    $expire = time() + ($defaults['rememberMeDuration']);
                }
                $user->login($expire);

                // Response
                $response = array(
                    'success' => true,
                    'data' => array(
                        'user' => $user->getPublicData()
                    )
                );
                $this->_pass('response', json_encode($response));

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
        }

        /**
         * _actionLogoutGet
         * 
         * @access public
         * @return void
         */
        public function _actionLogoutGet()
        {
            // View
            $this->__setView('logout', 'get');

            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('logout', 'get');
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_GET
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

                // Quick and done
                $liu = \getLoggedInUser();
                $liu->logout();
                header('Location: /');
                exit(0);
            }
        }

        /**
         * _actionLogoutPost
         * 
         * @access public
         * @return void
         */
        public function _actionLogoutPost()
        {
            // View
            $this->__setView('logout', 'post');

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

                // View
                $liu = \getLoggedInUser();
                $liu->logout();
                $response = array(
                    'success' => true
                );
                $this->_pass('response', json_encode($response));

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
        }

        /**
         * _actionBypassPasswordGet
         * 
         * @access protected
         * @return void
         */
        protected function _actionBypassPasswordGet()
        {
            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('bypassPassword', 'get');
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

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, false, $args);
                }
                // Otherwise
                else {

                    // Send to dashboard
                    $config = getConfig();
                    $redirectGetRequestsOnError = getConfig(
                        'defaults',
                        'redirectGetRequestsOnError'
                    );
                    if ($redirectGetRequestsOnError === true) {
                        header('Location: ' . ($config['paths']['dashboard']));
                        exit(0);
                    }

                    // Exception
                    throw new \SchemaValidationException(
                        \Modules\Users::getFailedSchemaMessage($validator)
                    );
                }
            }
            /**
             * Body
             * 
             */
            else {

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
        }

        /**
         * _actionBypassPasswordPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionBypassPasswordPost()
        {
            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('bypassPassword', 'post');
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_POST
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

                // Let's do this
                $userModel = $this->_getModel('Modules\\Users\\User');
                $user = $userModel->getUserByEmail($_POST['email']);
                $emailResponse = $user->sendBypassPasswordEmail();

                // Email cookie
                $defaults = getConfig('defaults');
                $expire = time() + ($defaults['rememberMeDuration']);
                $user->setEmailCookie($expire);

                // Response
                $response = array(
                    'success' => true,
                    'data' => array(
                        'user' => $user->getPublicData()
                    )
                );
                $this->_pass('response', json_encode($response));

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
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
            $path = $this->__getSchemaPath('resetPassword', 'get');
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

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, false, $args);
                }
                // Otherwise
                else {

                    // Send to dashboard
                    $config = getConfig();
                    $redirectGetRequestsOnError = getConfig(
                        'defaults',
                        'redirectGetRequestsOnError'
                    );
                    if ($redirectGetRequestsOnError === true) {
                        header('Location: ' . ($config['paths']['dashboard']));
                        exit(0);
                    }

                    // Exception
                    throw new \SchemaValidationException(
                        \Modules\Users::getFailedSchemaMessage($validator)
                    );
                }
            }
            /**
             * Body
             * 
             */
            else {

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
        }

        /**
         * _actionResetPasswordPost
         * 
         * @access protected
         * @return void
         */
        protected function _actionResetPasswordPost()
        {
            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('resetPassword', 'post');
            $schema = (new \SmartSchema($path));

            // Validator
            $validator = (new ProjectSchemaValidator(
                $schema,
                $this->getRequest(),
                $_POST
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

                // Matching user
                $userModel = $this->_getModel('Modules\\Users\\User');
                $user = $userModel->getUserByEmail($_POST['email']);

                // Generate a random password
                $possibleWords = getConfig(
                    'emails',
                    'resetPassword',
                    'resetTerms'
                );
                $randomNumber = rand(1000, 9999);
                $randomKey = rand(0, count($possibleWords) - 1);
                $randomPassword = ($possibleWords[$randomKey]) .
                    ($randomNumber);

                // Reset login hash; set password; send email
                $user->resetLoginHash();
                $user->setPassword($randomPassword);
                $emailResponse = $user->sendResetPasswordEmail($randomPassword);

                // Email cookie
                $defaults = getConfig('defaults');
                $expire = time() + ($defaults['rememberMeDuration']);
                $user->setEmailCookie($expire);

                // Response
                $response = array(
                    'success' => true,
                    'data' => array(
                        'user' => $user->getPublicData()
                    )
                );
                $this->_pass('response', json_encode($response));

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
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
                $this->__setView('changePassword', 'post');
                $this->_actionChangePasswordPost();
            } else {
                $this->__setView('changePassword', 'get');
                $this->_actionChangePasswordGet();
            }
        }

        /**
         * actionCrumble
         * 
         * @access public
         * @return void
         */
        public function actionCrumble()
        {
            // View
            $this->__setView('crumble', 'get');

            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('crumble', 'get');
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

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, false, $args);
                }
                // Otherwise
                else {

                    // Send to login
                    $config = getConfig();
                    $redirectGetRequestsOnError = getConfig(
                        'defaults',
                        'redirectGetRequestsOnError'
                    );
                    if ($redirectGetRequestsOnError === true) {
                        header('Location: ' . ($config['paths']['login']));
                        exit(0);
                    }

                    // Exception
                    throw new \SchemaValidationException(
                        \Modules\Users::getFailedSchemaMessage($validator)
                    );
                }
            }
            /**
             * Body
             * 
             */
            else {

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, true, $args);
                }
                // Otherwise
                else {
                    foreach ($_COOKIE as $key => $value) {
                        setcookie(
                            $key,
                            '',
                            time() - 3600,
                            '/',
                            $_SERVER['HTTP_HOST'],
                            HTTPS,
                            true
                        );
                    }
                    exit(0);
                }
            }
        }

        /**
         * actionDashboard
         * 
         * @access public
         * @return void
         */
        public function actionDashboard()
        {
            // View
            $this->__setView('dashboard', 'get');

            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('dashboard', 'get');
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

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, false, $args);
                }
                // Otherwise
                else {

                    // Send to login
                    $config = getConfig();
                    $redirectGetRequestsOnError = getConfig(
                        'defaults',
                        'redirectGetRequestsOnError'
                    );
                    if ($redirectGetRequestsOnError === true) {
                        header('Location: ' . ($config['paths']['login']));
                        exit(0);
                    }

                    // Exception
                    throw new \SchemaValidationException(
                        \Modules\Users::getFailedSchemaMessage($validator)
                    );
                }
            }
            /**
             * Body
             * 
             */
            else {

                // User
                $user = \getLoggedInUser();
                $this->_pass('liu', $user);

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
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
                $this->__setView('register', 'post');
                $this->_actionIndexPost();
            } else {
                $this->__setView('register', 'get');
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
                $this->__setView('login', 'post');
                $this->_actionLoginPost();
            } else {
                $this->__setView('login', 'get');
                $this->_actionLoginGet();
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
            if (!empty($_POST)) {
                $this->__setView('bypassPassword', 'post');
                $this->_actionBypassPasswordPost();
            } else {
                $this->__setView('bypassPassword', 'get');
                $this->_actionBypassPasswordGet();
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
            if (!empty($_POST)) {
                $this->__setView('logout', 'post');
                $this->_actionLogoutPost();
            } else {
                $this->__setView('logout', 'get');
                $this->_actionLogoutGet();
            }
        }

        /**
         * actionPrivacy
         * 
         * @access public
         * @return void
         */
        public function actionPrivacy()
        {
            // View
            $this->__setView('privacy', 'get');

            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('privacy', 'get');
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

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, false, $args);
                }
                // Otherwise
                else {

                    // Send to login
                    $config = getConfig();
                    $redirectGetRequestsOnError = getConfig(
                        'defaults',
                        'redirectGetRequestsOnError'
                    );
                    if ($redirectGetRequestsOnError === true) {
                        header('Location: ' . ($config['paths']['login']));
                        exit(0);
                    }

                    // Exception
                    throw new \SchemaValidationException(
                        \Modules\Users::getFailedSchemaMessage($validator)
                    );
                }
            }
            /**
             * Body
             * 
             */
            else {

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
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
                $this->__setView('resetPassword', 'post');
                $this->_actionResetPasswordPost();
            } else {
                $this->__setView('resetPassword', 'get');
                $this->_actionResetPasswordGet();
            }
        }

        /**
         * actionTerms
         * 
         * @access public
         * @return void
         */
        public function actionTerms()
        {
            // View
            $this->__setView('terms', 'get');

            /**
             * Validation
             * 
             */

            // Schema
            $path = $this->__getSchemaPath('terms', 'get');
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

                // Parent check
                if (is_callable(array('parent', __FUNCTION__))) {

                    // Parent
                    $args = func_get_args();
                    $this->__callParent(__FUNCTION__, false, $args);
                }
                // Otherwise
                else {

                    // Send to login
                    $config = getConfig();
                    $redirectGetRequestsOnError = getConfig(
                        'defaults',
                        'redirectGetRequestsOnError'
                    );
                    if ($redirectGetRequestsOnError === true) {
                        header('Location: ' . ($config['paths']['login']));
                        exit(0);
                    }

                    // Exception
                    throw new \SchemaValidationException(
                        \Modules\Users::getFailedSchemaMessage($validator)
                    );
                }
            }
            /**
             * Body
             * 
             */
            else {

                // Parent
                $args = func_get_args();
                $this->__callParent(__FUNCTION__, true, $args);
            }
        }
    }
