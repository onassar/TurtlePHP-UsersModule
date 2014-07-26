<?php

    // namespaces
    namespace Modules\Users;

    /**
     * SecurityValidator
     * 
     * @author   Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class SecurityValidator
    {
        /**
         * requestIsSubRequest
         * 
         * @access public
         * @static
         * @param  Turtle\Request $request
         * @return boolean
         */
        public static function requestIsSubRequest(Turtle\Request $request)
        {
            return $request->isSubRequest() === true;
        }

        /**
         * validCsrfToken
         * 
         * csrfToken is not currently being unset. This is to prevent opening
         * of multiple tabs and having it break. Not sure if this is secure
         * enough longterm, but it good-enough for now.
         * 
         * @access public
         * @static
         * @param  string $csrfToken
         * @return boolean
         */
        public static function validCsrfToken($csrfToken)
        {
            return $_SESSION['csrfToken'] === $csrfToken;
        }
    }
