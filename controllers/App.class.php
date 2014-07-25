<?php

    /**
     * AppController
     * 
     * @extends Controller
     */
    class AppController extends \Turtle\Controller
    {
        /**
         * _generateAndStoreCsrfToken
         *
         * @access protected
         * @return void
         */
        protected function _generateAndStoreCsrfToken()
        {
            if (!isset($_SESSION['csrfToken'])) {
                $_SESSION['csrfToken'] = getRandomHash();
            }
        }

        /**
         * _secureServer
         * 
         * @access protected
         * @return void
         */
        protected function _secureServer()
        {
            $role = getRole();
            if ($role === 'dev') {
                $config = getConfig();
                $config = $config['security'][$role];
                $httpAuthBypass = $config['httpAuthBypass'];
                if (!isset($_GET[$httpAuthBypass])) {
                    if (
                        !isset($_SERVER['PHP_AUTH_USER'])
                        ||
                        !(
                            isset($config['httpAuthCombos'][$_SERVER['PHP_AUTH_USER']])
                            && $config['httpAuthCombos'][$_SERVER['PHP_AUTH_USER']] === $_SERVER['PHP_AUTH_PW']
                        )
                    ) {
                        header('WWW-Authenticate: Basic realm="Private Server"');
                        header('HTTP/1.0 401 Unauthorized');
                        throw new Exception('Server requires http auth');
                    }
                }
            }
        }

        /**
         * prepare
         *
         * @access public
         * @return void
         */
        public function prepare()
        {
            // Secure the server
            $this->_secureServer();

            // Pass in the Csrf token
            $this->_generateAndStoreCsrfToken();
            $this->_pass('csrfToken', $_SESSION['csrfToken']);

            // parental guidance :)
            parent::prepare();
        }
    }
