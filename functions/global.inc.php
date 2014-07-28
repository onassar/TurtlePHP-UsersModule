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
        // if (!isset($_SESSION['userId'])) {
        //     return false;
        // }
        $id = 1;
        $userModel = Turtle\Application::getModel('Modules\Users\User');
        return $userModel->getUserById($id);
        return $userModel->getUserById($_SESSION['userId']);
    }
