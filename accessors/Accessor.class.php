<?php

    /**
     * Accessor
     *
     */
    class Accessor
    {
        /**
         * _data
         *
         * Stores the record retrieved from MySQL.
         * 
         * @var    array (default: array())
         * @access protected
         */
        protected $_data = array();

        /**
         * _dataLoaded
         * 
         * @var    boolean (default: false)
         * @access protected
         */
        protected $_dataLoaded = false;

        /**
         * _modelName
         * 
         * Stores the model associated with the Accessor to make updating the
         * MySQL record easier.
         * 
         * @var    string
         * @access protected
         */
        protected $_modelName;

        /**
         * _recordType
         * 
         * Used by the __toString method for serialization.
         * 
         * @var    string
         * @access protected
         */
        protected $_recordType;

        /**
         * _tableName
         * 
         * Used to ease the process of updating associated MySQL record.
         * 
         * @var    string
         * @access protected
         */
        protected $_tableName;

        /**
         * __construct
         *
         * @access public
         * @param  integer $id
         * @return void
         */
        public function __construct($id)
        {
            $this->_data['id'] = $id;
        }

        /**
         * __get
         *
         * @throws Exception
         * @access protected
         * @param  string $name
         * @return mixed
         */
        public function __get($name)
        {
            if (array_key_exists($name, $this->_data) === true) {
                return $this->_data[$name];
            }
            if ($this->_dataLoaded === false) {
                $this->_loadData();
                return $this->__get($name);
            }

            // Only use this for debugging
            // el(pr(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), true));
            throw new Exception('Invalid property: ' . ($name));
        }

        /**
         * _getModel
         *
         * Helper method to access a model quickly, from with an Accessor.
         *
         * @access protected
         * @param  string $name
         * @return Model
         */
        protected function _getModel($name)
        {
            return \Turtle\Application::getModel($name);
        }

        /**
         * _loadData
         *
         * @access protected
         * @return void
         */
        protected function _loadData()
        {
            $this->_dataLoaded = true;
            $model = $this->_getModel($this->_modelName);
            $data = $model->getRecordData($this->_data['id']);

            // Only store record data in _data if record data was in fact found
            if ($data !== false) {
                $this->_data = $data[0];
            }
        }

        /**
         * exists
         *
         * @access public
         * @return boolean
         */
        public function exists()
        {
            try {
                $this->status;
                return true;
            } catch (Exception $exception) {
                return false;
            }
        }

        /**
         * getRecordType
         *
         * Returns what time of accessor this is (eg. category, talk, user
         * organization, etc).
         *
         * @access public
         * @return string
         */
        public function getRecordType()
        {
            return $this->_recordType;
        }

        /**
         * update
         * 
         * @access public
         * @param  array $details
         * @return void
         */
        public function update(array $details)
        {
            // Set updated to current time, if not explicitly set
            if (!isset($details['updated'])) {
                $details['updated'] = time();
            }

            // Update MySQL
            $model = $this->_getModel($this->_modelName);
            $model->updateDetails(
                $this->_tableName,
                $this->id,
                $details
            );

            // Ensure data has been accessed
            if ($this->_dataLoaded === false) {
                $this->_loadData();
            }

            // Update accessor details
            foreach ($details as $key => $value) {
                $this->_data{$key} = $value;
            }
        }
    }
