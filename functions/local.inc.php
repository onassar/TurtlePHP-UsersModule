<?php

    // namespaces
    namespace Modules\Users;

    /**
     * getConfig
     * 
     * @access public
     * @return mixed
     */
    function getConfig()
    {
        $args = func_get_args();
        return call_user_func_array(
            array('\Modules\Users', 'getConfig'),
            $args
        );
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
