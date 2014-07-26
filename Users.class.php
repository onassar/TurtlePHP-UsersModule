<?php

    // modules namespace
    namespace Modules;

    /**
     * UsersModule
     * 
     * @author   Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Users
    {
        /**
         * addCallback
         * 
         * @access public
         * @static
         * @param  string $name
         * @param  array $callback
         * @return void
         */
        public static function addCallback($name, array $callback)
        {
            $config = \Plugin\Config::retrieve();
            $config = $config['TurtlePHP-UsersModule'];
            array_push($config['callbacks'][$name], $callback);
        }

        /**
         * getConfig
         * 
         * @access public
         * @static
         * @return array
         */
        public static function getConfig()
        {
            // configuration settings
            $config = \Plugin\Config::retrieve();
            $config = $config['TurtlePHP-UsersModule'];
            return $config;
        }

        /**
         * setView
         * 
         * @access public
         * @static
         * @param  string $name
         * @param  string $path
         * @return void
         */
        public static function setView($name, $path)
        {
            $config = \Plugin\Config::retrieve();
            $config = $config['TurtlePHP-UsersModule'];
            $config['views'][$name] = $path;
        }
    }
