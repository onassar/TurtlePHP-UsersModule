<?php

    // namespaces
    namespace Modules\Users;

    /**
     * AppModel
     *
     * @extends \UserModel
     */
    class AppModel extends \UserModel
    {
        /**
         * _cache
         * 
         * @var    boolean (default: false)
         * @access protected
         */
        protected $_cache = false;

        /**
         * _modelName
         * 
         * @var    string
         * @access protected
         */
        protected $_modelName;

        /**
         * _recordType
         * 
         * @var    string
         * @access protected
         */
        protected $_recordType;

        /**
         * _tableName
         * 
         * @var    string
         * @access protected
         */
        protected $_tableName;

        /**
         * _cacheAccessor
         *
         * @access protected
         * @param  \Accessor $accessor
         * @return void
         */
        protected function _cacheAccessor(\Accessor $accessor)
        {
            \RequestCache::simpleWrite(
                'accessor'.
                $accessor->getRecordType().
                $accessor->id,
                $accessor
            );
        }

        /**
         * _createRecord
         *
         * @note   Could potentially perform write-through caching below,
         *         instead of retrieving accessor natively
         * @access protected
         * @param  array $details
         * @return Accessor
         */
        protected function _createRecord(array $details)
        {
            // overwrite defaults with potential passed values
            $defaults = array(
                'created' => time(),
                'status' => 'open'
            );
            $details = array_merge($defaults, $details);

            // parse details
            $parsed = $this->_parse($details);

            // insert
            (new \MySQLQuery(
                'INSERT INTO `' . ($this->_tableName) . '` ' .
                    '(`' . implode('`, `', $parsed['columns']) . '`) ' .
                'VALUES ' .
                    '(' . implode(', ', $parsed['values']) . ')'
            ));

            // return record
            $id = \MySQLConnection::getInsertedId();
            return call_user_func_array(
                array($this, 'get' . ($this->_modelName) . 'ById'),
                array($id)
            );
        }

        /**
         * _getAccessorById
         *
         * @access protected
         * @param  string $id
         * @return Accessor
         */
        protected function _getAccessorById($id)
        {
            // Cached accessor check
            $accessor = $this->_getCachedAccessor($this->_recordType, $id);
            if (!is_null($accessor)) {
                return $accessor;
            }

            // Return accessor
            $accessorName = ($this->_modelName) . 'Accessor';
            $accessorName = 'Modules\Users\\' . ($accessorName);
            $accessor = (new $accessorName($id));
            $this->_cacheAccessor($accessor);
            return $accessor;
        }

        /**
         * _getCachedAccessor
         *
         * @todo   Give key proper formatting
         * @access protected
         * @param  string $accessorType
         * @param  integer $id
         * @return null|Accessor
         */
        protected function _getCachedAccessor($accessorType, $id)
        {
            $accessor = \RequestCache::simpleRead(
                'accessor' . ($accessorType) . ($id)
            );
            if ($accessor === null) {
                return null;
            }
            return $accessor;
        }

        /**
         * _parse
         *
         * @access protected
         * @param  array $details
         * @return string
         */
        protected function _parse(array $details)
        {
            // query setup
            $columns = array();
            $values = array();

            // loop through supplied details
            $link = \MySQLConnection::getLink();
            foreach ($details as $column => $value) {

                // Single quote wrappers
                array_push($columns, $column);
                $value = '\'' . ($link->escape_string($value)) . '\'';
                array_push($values, $value);
            }

            // columns/values response
            return array(
                'columns' => $columns,
                'values' => $values
            );
        }

        /**
         * getRecordData
         *
         * @access public
         * @param  string|integer $id
         * @param  boolean $renew (default: false)
         * @return false|Accessor
         */
        public function getRecordData($id, $renew = false)
        {
            // Cache lookup
            if (
                $this->_cache === true
                && $renew === false
            ) {
                $key = implode(
                    ' / ',
                    array(
                        $this->_tableName,
                        (int) $id
                    )
                );
                $lookup = \MemcachedCache::read($key);
                if ($lookup !== null) {
                    return $lookup;
                }
            }

            // Query
            $query = (new \Query());
            $query->select('*');
            $query->from($this->_tableName);
            $query->where('status', 'open');
            $query->andWhere('id', (int) $id, false);
            $query->limit(false);

            // Retrieve matching records; cache them
            $mySQLQuery = (new \MySQLQuery($query->parse()));
            $records = $mySQLQuery->getResults();

            // Cache writing
            if ($this->_cache === true) {
                $key = implode(
                    ' / ',
                    array(
                        $this->_tableName,
                        (int) $id
                    )
                );
                \MemcachedCache::write($key, $records);
            }

            // Not found
            if (empty($records)) {
                return false;
            }
            return $records;
        }

        /**
         * updateDetails
         *
         * @access public
         * @param  string $table
         * @param  integer $id
         * @param  array $details
         * @return void
         */
        public function updateDetails($table, $id, array $details)
        {
            // parse details
            $parsed = $this->_parse($details);
            $changes = array();

            // loop through parsed to create update query
            foreach ($parsed['columns'] as $offset => $column) {

                // change statement
                $change = '`' . ($column) . '` = ' .
                    ($parsed['values'][$offset]);
                array_push($changes, $change);
            }

            // perform update
            (new \MySQLQuery(
                'UPDATE `' . ($table) . '` ' .
                    'SET ' . implode(', ', $changes) . ' ' .
                'WHERE ' .
                    'id = ' . ($id)
            ));

            // Cache updates
            if ($this->_cache === true) {
                $this->getRecordData($id, true);
            }
        }
    }
