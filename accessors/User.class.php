<?php

    // namespaces
    namespace Modules\Users;

    // dependencies
    require_once MODULE . '/accessors/Accessor.class.php';

    /**
     * UserAccessor
     *
     * @extends Accessor
     */
    class UserAccessor extends Accessor
    {
        /**
         * _modelName
         * 
         * @var    string (default: 'User')
         * @access protected
         */
        protected $_modelName = 'User';

        /**
         * _recordType
         * 
         * @var    string (default: 'user')
         * @access protected
         */
        protected $_recordType = 'user';

        /**
         * _tableName
         * 
         * @var    string (default: 'users')
         * @access protected
         */
        protected $_tableName = 'users';

        /**
         * getPublicData
         *
         * @access public
         * @return array
         */
        public function getPublicData()
        {
            $this->status;// Needed to ensure data is retrieved from store
            $data = $this->_data;
            unset($data['passwordHash']);
            unset($data['loginHash']);
            return $data;
        }

        /**
         * login
         *
         * @access public
         * @param  integer $expire
         * @return void
         */
        public function login($expire)
        {
            $_SESSION['userId'] = $this->id;
            $this->resetLoginHash();
            setcookie(
                'isLoggedIn',
                '1',
                $expire,
                '/',
                $_SERVER['HTTP_HOST'],
                HTTPS,
                true
            );
            setcookie(
                'loginHash',
                $this->loginHash,
                $expire,
                '/',
                $_SERVER['HTTP_HOST'],
                HTTPS,
                true
            );

            // Track email
            setcookie(
                'email',
                $this->email,
                $expire,
                '/',
                $_SERVER['HTTP_HOST'],
                HTTPS,
                true
            );
        }

        /**
         * logout
         *
         * @access public
         * @return void
         */
        public function logout()
        {
            // Close session
            $GLOBALS['SMSession']->destroy();
            setcookie(
                'isLoggedIn',
                '',
                time() - (365 * 24 * 60 * 60),
                '/',
                $_SERVER['HTTP_HOST'],
                HTTPS,
                true
            );
            setcookie(
                'loginHash',
                '',
                time() - (365 * 24 * 60 * 60),
                '/',
                $_SERVER['HTTP_HOST'],
                HTTPS,
                true
            );
        }

        /**
         * resetLoginHash
         *
         * Chooses a random string for a new login hash.
         *
         * @access public
         * @return void
         */
        public function resetLoginHash()
        {
            if ($this->loginHash === '') {
                $this->update(array(
                    'loginHash' => getRandomHash()
                ));
            }
        }

        /**
         * sendResetPasswordEmail
         *
         * @access public
         * @param  string $randomPassword
         * @return array
         */
        public function sendResetPasswordEmail($randomPassword)
        {
            // Path
            $config = getConfig();
            $path = $config['paths']['emails']['resetPassword'];

            // Subrequest
            $path = ($path) .
                '?userId=' . ($this->id) .
                '&randomPassword=' . ($randomPassword);
            $subrequest = (new \Turtle\Request($path));
            $subrequest->route();
            $subrequest->generate();
            $response = $subrequest->getResponse();

            // Respond
            return json_decode($response, true);
        }


        /**
         * sendWelcomeEmail
         *
         * @access public
         * @return array
         */
        public function sendWelcomeEmail()
        {
            // Path
            $config = getConfig();
            $path = $config['paths']['emails']['welcome'];

            // Subrequest
            $path = ($path) .
                '?userId=' . ($this->id);
            $subrequest = (new \Turtle\Request($path));
            $subrequest->route();
            $subrequest->generate();
            $response = $subrequest->getResponse();

            // Response
            $response = json_decode($response, true);
            if ($response['success'] === true) {
                $this->update(
                    array(
                        'hasReceivedWelcomeEmail' => 1
                    )
                );
            }

            // Done
            return $response;
        }

        /**
         * setPassword
         *
         * @access public
         * @param  string $password
         * @return void
         */
        public function setPassword($password)
        {
            $config = getConfig();
            $security = $config['security'];
            $this->update(array(
                'passwordHash' => hash(
                    'sha256',
                    ($security['passwordSalt']) . ($password)
                )
            ));
        }
    }
