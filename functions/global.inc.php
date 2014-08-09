<?php

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
        $userModel = Turtle\Application::getModel('Modules\Users\User');
        return $userModel->getUserById($_SESSION['userId']);
    }
