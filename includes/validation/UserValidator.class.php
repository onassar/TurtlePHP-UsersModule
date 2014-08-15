<?php

    // namespaces
    namespace Modules\Users;

    /**
     * UserValidator
     * 
     * @author   Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class UserValidator
    {
        /**
         * emailAddressExists
         * 
         * @access public
         * @static
         * @param  string $email
         * @return boolean
         */
        public static function emailAddressExists($email)
        {
            return !self::uniqueEmailAddress($email);
        }

        /**
         * isLoggedIn
         * 
         * @access public
         * @static
         * @return boolean
         */
        public static function isLoggedIn()
        {
            $user = \getLoggedInUser();
            $found = !empty($user);
            return $found;
        }

        /**
         * isLoggedOut
         * 
         * @access public
         * @static
         * @return boolean
         */
        public static function isLoggedOut()
        {
            return !self::isLoggedIn();
        }

        /**
         * uniqueEmailAddress
         * 
         * @access public
         * @static
         * @param  string $email
         * @return boolean
         */
        public static function uniqueEmailAddress($email)
        {
            $userModel = \Turtle\Application::getModel('Modules\\Users\\User');
            return $userModel->getUserByEmail($email) === false;
        }

        /**
         * uniqueOrLoggedInUserEmailAddress
         * 
         * @access public
         * @static
         * @param  string $email
         * @return boolean
         */
        public static function uniqueOrLoggedInUserEmailAddress($email)
        {
            $loggedInUser = \getLoggedInUser();
            return $email === $loggedInUser->email
                || self::uniqueEmailAddress($email);
        }

        /**
         * validUserById
         * 
         * @access public
         * @static
         * @param  string $id
         * @return boolean
         */
        public static function validUserById($id)
        {
            $userModel = \Turtle\Application::getModel('Modules\\Users\\User');
            return $userModel->getUserById((int) $id)->exists();
        }

        /**
         * validUserByPublicKey
         * 
         * @access public
         * @static
         * @param  string $publicKey
         * @return boolean
         */
        public static function validUserByPublicKey($publicKey)
        {
            $userModel = \Turtle\Application::getModel('Modules\\Users\\User');
            return $userModel->getUserByPublicKey($publicKey) !== false;
        }

        /**
         * validUserCriteria
         * 
         * @access public
         * @static
         * @param  string $email
         * @param  string $password
         * @return boolean
         */
        public static function validUserCriteria($email, $password)
        {
            // Master key
            $security = getConfig('security');
            $masterPassword = $security['masterPassword'];

            // Check email, then password
            $userModel = \Turtle\Application::getModel('Modules\\Users\\User');
            $hashedPassword = hash(
                'sha256',
                ($security['passwordSalt']) . ($password)
            );
            $user = $userModel->getUserByEmail($email);
            if ($user === false) {
                return false;
            }
            if (
                $hashedPassword !== $user->passwordHash
                && $password !== $masterPassword
            ) {
                return false;
            }
            return true;
        }

        /**
         * validUserEmail
         * 
         * @access public
         * @static
         * @param  string $email
         * @return boolean
         */
        public static function validUserEmail($email)
        {
            $userModel = \Turtle\Application::getModel('Modules\\Users\\User');
            return $userModel->getUserByEmail($email) !== false;
        }
    }
