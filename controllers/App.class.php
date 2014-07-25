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
         * prepare
         *
         * @access public
         * @return void
         */
        public function prepare()
        {
            // Pass in the Csrf token
            $this->_generateAndStoreCsrfToken();
            $this->_pass('csrfToken', $_SESSION['csrfToken']);

            // parental guidance :)
            parent::prepare();
        }
    }
