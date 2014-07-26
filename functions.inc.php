<?php

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
