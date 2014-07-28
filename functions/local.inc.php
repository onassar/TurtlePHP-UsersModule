<?php

    // namespaces
    namespace Modules\Users;

    /**
     * getConfig
     * 
     * @access public
     * @return array
     */
    function getConfig()
    {
        return \Modules\Users::getConfig();
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
