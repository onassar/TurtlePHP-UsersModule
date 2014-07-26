<?php

    // namespaces
    namespace Modules\Users;

    /**
     * getLoggedInUser
     * 
     * @note   Exception thrown if invalid id
     * @access public
     * @return false|UserAccessor
     */
    function getLoggedInUser()
    {
        if (!isset($_SESSION['userId'])) {
            return false;
        }
        $userModel = Turtle\Application::getModel('User');
        return $userModel->getUserById($_SESSION['userId']);
    }

    /**
     * getRandomHash
     * 
     * @access public
     * @param  integer $limit (default: 32)
     * @return string
     */
    function getRandomHash($limit = 32)
    {
        return substr(md5(uniqid(mt_rand(), true)), 0, $limit);
    }
