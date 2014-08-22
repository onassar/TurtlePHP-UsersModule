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
         * addToCmList
         *
         * @access public
         * @param  string $listKey
         * @return CS_REST_Wrapper_Result|false
         */
        public function addToCmList($listKey)
        {
            $data = array(
                'email' => $this->email
            );
            try {
                $data['firstName'] = $this->firstName;
            } catch (\Exception $exception) {}
            try {
                $data['lastName'] = $this->lastName;
            } catch (\Exception $exception) {}
            try {
                $data['name'] = $this->name;
            } catch (\Exception $exception) {}
            return \Plugin\CampaignMonitor::add($listKey, $data);
        }

        /**
         * getAutoLoginUrl
         *
         * @access public
         * @param  string $path
         * @return string
         */
        public function getAutoLoginUrl($path)
        {
            $host = $_SERVER['HTTP_HOST'];
            $protocol = 'http://';
            if (HTTPS) {
                $protocol = 'https://';
            }
            // $query = http_build_query()
            return ($protocol) . ($host) . ($path) . '?loginHash=' .
                ($this->loginHash);
        }

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
                time() - (2 * 365 * 24 * 60 * 60),
                '/',
                $_SERVER['HTTP_HOST'],
                HTTPS,
                true
            );
            setcookie(
                'loginHash',
                '',
                time() - (2 * 365 * 24 * 60 * 60),
                '/',
                $_SERVER['HTTP_HOST'],
                HTTPS,
                true
            );
        }

        /**
         * removeFromCmList
         *
         * @access public
         * @param  string $listKey
         * @return CS_REST_Wrapper_Result|false
         */
        public function removeFromCmList($listKey)
        {
            return \Plugin\CampaignMonitor::remove($listKey, $this->email);
        }

        /**
         * resetLoginHash
         *
         * Chooses a random string for a new login hash.
         * Should I be updating it each time? I remember there was a problem
         * when I did this back in the day
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
         * sendBypassPasswordEmail
         *
         * @access public
         * @return array
         */
        public function sendBypassPasswordEmail()
        {
            // Path
            $path = getConfig('paths', 'emails', 'bypassPassword');

            // Subrequest
            $path = ($path) .
                '?userId=' . ($this->id);
            $response = \Turtle\Application::getPath($path);

            // Respond
            return json_decode($response, true);
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
            $path = getConfig('paths', 'emails', 'resetPassword');

            // Subrequest
            $path = ($path) .
                '?userId=' . ($this->id) .
                '&randomPassword=' . ($randomPassword);
            $response = \Turtle\Application::getPath($path);

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
            $path = getConfig('paths', 'emails', 'welcome');

            // Subrequest
            $path = ($path) .
                '?userId=' . ($this->id);
            $response = \Turtle\Application::getPath($path);

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
            $passwordSalt = getConfig('security', 'passwordSalt');
            $this->update(array(
                'passwordHash' => hash(
                    'sha256',
                    ($passwordSalt) . ($password)
                )
            ));
        }
    }
