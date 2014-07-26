<?php

    // namespaces
    namespace Modules\Users;

    /**
     * ProjectSchemaValidator
     * 
     * Manages the validation of a schema against it's defined rules.
     * 
     * @author  Oliver Nassar <onassar@gmail.com>
     * @extends SchemaValidator
     * @example https://github.com/onassar/PHP-JSON-Validation/tree/master/example
     */
    class ProjectSchemaValidator extends \SchemaValidator
    {
        /**
         * __construct
         * 
         * @access public
         * @param  Schema $schema
         * @param  Turtle/Request $request
         * @param  array $data (default: array())
         * @return void
         */
        public function __construct(
            \Schema $schema,
            \Turtle\Request $request,
            array $data = array())
        {
            $this->_libraries = array(
                APP . '/vendors/PHP-JSON-Validation/DataValidator.class.php',
                APP . '/vendors/PHP-JSON-Validation/StringValidator.class.php',
                MODULE . '/includes/validation/SecurityValidator.class.php',
                MODULE . '/includes/validation/UserValidator.class.php'
            );
            parent::__construct($schema, $data);

            // request-based $_GET
            $_get = $request->getController()->getGet();
            $this->_data['__get__'] = $_get;
            $this->_data['__request__'] = $request;
        }
    }
