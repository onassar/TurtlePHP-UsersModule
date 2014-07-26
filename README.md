TurtlePHP-UsersModule
======================

### Depdencies
All the submodules listed below, along with Postmark for email integration

### Routes

`/users`  
`GET`  
`POST`  

`/users/login`  
`GET`  
`POST`

`/users/logout`  
`POST`

`/users/changePassword`  
`GET`  
`POST`

`/users/resetPassword`  
`GET`  
`POST`

### Install and init flows

```
cd ~/Sites/domain.com
git submodule add git@github.com:onassar/TurtlePHP-ConfigPlugin.git TurtlePHP/application/plugins/TurtlePHP-ConfigPlugin
git submodule add git@github.com:onassar/PHP-Email.git TurtlePHP/application/vendors/PHP-Email
git clone git@github.com:Znarkus/postmark-php.git TurtlePHP/application/vendors/postmark-php
rm -rf TurtlePHP/application/vendors/postmark-php/.git
git submodule add git@github.com:onassar/PHP-Geo.git TurtlePHP/application/vendors/PHP-Geo
git submodule add git@github.com:onassar/PHP-RequestCache.git TurtlePHP/application/vendors/PHP-RequestCache
git submodule add git@github.com:onassar/PHP-MySQL.git TurtlePHP/application/vendors/PHP-MySQL
git submodule add git@github.com:onassar/PHP-Query.git TurtlePHP/application/vendors/PHP-Query
git submodule add git@github.com:onassar/PHP-SecureSessions.git TurtlePHP/application/vendors/PHP-SecureSessions
git submodule add git@github.com:onassar/PHP-JSON-Validation.git TurtlePHP/application/vendors/PHP-JSON-Validation
git submodule add git@github.com:onassar/TurtlePHP-UsersModule.git TurtlePHP/modules/TurtlePHP-UsersModule
```

``` php
require_once APP . '/plugins/TurtlePHP-ConfigPlugin/Config.class.php';
require_once APP . '/vendors/PHP-Email/Email.class.php';
require_once APP . '/vendors/postmark-php/src/Postmark/Mail.php';
require_once APP . '/vendors/PHP-Email/PostmarkEmail.class.php';
require_once APP . '/vendors/PHP-Geo/Geo.class.php';
require_once APP . '/vendors/PHP-RequestCache/RequestCache.class.php';
require_once APP . '/vendors/PHP-MySQL/MySQLConnection.class.php';
require_once APP . '/vendors/PHP-MySQL/MySQLQuery.class.php';
require_once APP . '/vendors/PHP-Query/Query.class.php';
require_once APP . '/vendors/PHP-SecureSessions/SMSession.class.php';
require_once APP . '/vendors/PHP-JSON-Validation/Schema.class.php';
require_once APP . '/vendors/PHP-JSON-Validation/SmartSchema.class.php';
require_once APP . '/vendors/PHP-JSON-Validation/SchemaValidator.class.php';
#require_once APP . '/helpers/validation/ProjectSchemaValidator.class.php';

require_once APP . '/modules/TurtlePHP-UsersModule/includes/init.inc.php';
```
