<?php

    // namespaces
    namespace Modules\Users;

    // dependencies
    require_once MODULE . '/models/App.class.php';
    require_once MODULE . '/accessors/User.class.php';

    /**
     * UserModel
     *
     * @extends AppModel
     */
    class UserModel extends AppModel
    {
        /**
         * _modelName
         * 
         * @var    string (default: 'User')
         * @access protected
         */
        protected $_modelName = 'User';

        /**
         * _recordType
         * 
         * @var    string (default: 'user')
         * @access protected
         */
        protected $_recordType = 'user';

        /**
         * _tableName
         * 
         * @var    string (default: 'users')
         * @access protected
         */
        protected $_tableName = 'users';

        /**
         * createUser
         *
         * @access public
         * @param  array $details
         * @return UserAccessor
         */
        public function createUser(array $details)
        {
            return $this->_createRecord($details);
        }

        /**
         * getUniquePublicKey
         *
         * @access public
         * @param  integer $iteration (default: 0)
         * @return string
         */
        public function getUniquePublicKey($iteration = 0)
        {
            // Recursion
            if ($iteration >= 1000) {
                throw new \Exception('Something terrible went wrong. Terrible.');
            }
            $publicKey = getRandomHash(16);
            $user = $this->getUserByPublicKey($publicKey);
            if ($user === false) {
                return $publicKey;
            }
            return $this->getUniquePublicKey($iteration + 1);
        }

        /**
         * getUniqueUsername
         *
         * @access public
         * @param  string $username
         * @param  integer $iteration (default: 1)
         * @return string
         */
        public function getUniqueUsername($username, $iteration = 1)
        {
            // Recursion
            if ($iteration >= 1000) {
                throw new \Exception('Something terrible went wrong. Terrible.');
            }
            $handleCheck = $username;
            $pattern = '/[^a-zA-Z0-9\.]/';
            $handleCheck = preg_replace($pattern, '', $handleCheck);
            if ($iteration !== 1) {
                $handleCheck .= '.' . ($iteration);
            }
            $user = $this->getUserByUsername($handleCheck);
            if ($user === false) {
                return $handleCheck;
            }
            return $this->getUniqueUsername(
                $username,
                $iteration + 1
            );
        }

        /**
         * getUserByEmail
         *
         * @access public
         * @param  string $email
         * @return UserAccessor|false
         */
        public function getUserByEmail($email)
        {
            // Query
            $link = \MySQLConnection::getLink();
            $query = (new \Query());
            $query->select('id');
            $query->from('users');
            $query->where('status', 'open');
            $query->andWhere('email', $link->escape_string($email));

            // Retrieve matching records
            $mySQLQuery = (new \MySQLQuery($query->parse()));
            $records = $mySQLQuery->getResults();

            // Not found
            if (empty($records)) {
                return false;
            }

            // Return accessor
            return $this->getUserById($records[0]['id']);
        }

        /**
         * getUserByUsername
         *
         * @access public
         * @param  string $username
         * @return UserAccessor|false
         */
        public function getUserByUsername($username)
        {
            // Query
            $link = \MySQLConnection::getLink();
            $query = (new \Query());
            $query->select('id');
            $query->from('users');
            $query->where('status', 'open');
            $query->andWhere('username', $link->escape_string($username));

            // Retrieve matching records
            $mySQLQuery = (new \MySQLQuery($query->parse()));
            $records = $mySQLQuery->getResults();

            // Not found
            if (empty($records)) {
                return false;
            }

            // Return accessor
            return $this->getUserById($records[0]['id']);
        }

        /**
         * getUserByLoginHash
         *
         * @access public
         * @param  string $loginHash
         * @return UserAccessor|false
         */
        public function getUserByLoginHash($loginHash)
        {
            // Query
            $link = \MySQLConnection::getLink();
            $query = (new \Query());
            $query->select('id');
            $query->from('users');
            $query->where('status', 'open');
            $query->andWhere('loginHash', $link->escape_string($loginHash));

            // Retrieve matching records
            $mySQLQuery = (new \MySQLQuery($query->parse()));
            $records = $mySQLQuery->getResults();

            // Not found
            if (empty($records)) {
                return false;
            }

            // Return accessor
            return $this->getUserById($records[0]['id']);
        }

        /**
         * getUserById
         *
         * @access public
         * @param  string|integer $id
         * @return UserAccessor
         */
        public function getUserById($id)
        {
            return $this->_getAccessorById($id);
        }

        /**
         * getUserByPublicKey
         *
         * @access public
         * @param  string $publicKey
         * @return UserAccessor|false
         */
        public function getUserByPublicKey($publicKey)
        {
            // Query
            $link = \MySQLConnection::getLink();
            $query = (new \Query());
            $query->select('id');
            $query->from('users');
            $query->where('status', 'open');
            $query->andWhere('publicKey', $link->escape_string($publicKey));

            // Retrieve matching records
            $mySQLQuery = (new \MySQLQuery($query->parse()));
            $records = $mySQLQuery->getResults();

            // Not found
            if (empty($records)) {
                return false;
            }

            // Return accessor
            return $this->getUserById($records[0]['id']);
        }

        /**
         * getUsers
         *
         * @access public
         * @param  integer $start
         * @param  integer $limit
         * @param  array $clauses (default: array())
         * @param  boolean $escapeValues (default: true)
         * @return array
         */
        public function getUsers(
            $start,
            $limit,
            $clauses = array(),
            $escapeValues = true
        ) {
            // Query
            $link = \MySQLConnection::getLink();
            $query = (new \Query());
            $query->select('id');
            $query->from('users');
            $query->where('status', 'open');
            if (!empty($clauses)) {
                foreach ($clauses as $clause) {
                    foreach ($clause as $key => $property) {
                        if ($escapeValues === true) {
                            $clause[$key] = $link->escape_string($property);
                        } else {
                            $clause[$key] = $property;
                        }
                    }
                    $query->andWhere($clause);
                }
            }
            $query->limit($limit);
            $query->offset($start);
            $query->orderBy('id', false);

            // Retrieve matching records
            $mySQLQuery = (new \MySQLQuery($query->parse()));
            $records = $mySQLQuery->getResults();

            // Accessors
            $users = array();
            foreach ($records as $record) {
                $users[] = $this->getUserById($record['id']);
            }
            return $users;
        }

        /**
         * getUsersCount
         *
         * @access public
         * @param  array $clauses (default: array());
         * @return integer
         */
        public function getUsersCount($clauses = array())
        {
            // Query
            $link = \MySQLConnection::getLink();
            $query = (new \Query());
            $query->count();
            $query->table('users');
            $query->where('status', 'open');
            if (!empty($clauses)) {
                foreach ($clauses as $clause) {
                    foreach ($clause as $key => $property) {
                        $clause[$key] = $link->escape_string($property);
                    }
                    $query->andWhere($clause);
                }
            }

            // Retrieve matching records
            $mySQLQuery = (new \MySQLQuery($query->parse()));
            $records = $mySQLQuery->getResults();
            return (int) $records[0]['count'];
        }
    }
