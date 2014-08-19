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
require_once APP . '/controllers/Emails.class.php';
require_once APP . '/controllers/Users.class.php';
require_once APP . '/models/User.class.php';
require_once APP . '/plugins/TurtlePHP-ConfigPlugin/Config.class.php';
require_once APP . '/vendors/PHP-Email/Email.class.php';
require_once APP . '/vendors/postmark-php/src/Postmark/Mail.php';
require_once APP . '/vendors/PHP-Email/PostmarkEmail.class.php';
require_once APP . '/vendors/mailgun/autoload.php';
require_once APP . '/vendors/PHP-Email/MailgunEmail.class.php';
require_once APP . '/plugins/TurtlePHP-EmailerPlugin/Emailer.class.php';
\Plugin\Emailer::init();
require_once APP . '/vendors/PHP-Geo/Geo.class.php';
require_once APP . '/vendors/PHP-RequestCache/RequestCache.class.php';
require_once APP . '/vendors/PHP-MySQL/MySQLConnection.class.php';
require_once APP . '/vendors/PHP-MySQL/MySQLQuery.class.php';
require_once APP . '/plugins/TurtlePHP-DatabasePlugin/Database.class.php';
\Plugin\Database::connect();
require_once APP . '/vendors/PHP-Query/Query.class.php';
require_once APP . '/vendors/PHP-SecureSessions/SMSession.class.php';
require_once APP . '/plugins/TurtlePHP-MemcachedSessionPlugin/MemcachedSession.class.php';
\Plugin\MemcachedSession::open();
require_once APP . '/vendors/PHP-JSON-Validation/Schema.class.php';
require_once APP . '/vendors/PHP-JSON-Validation/SmartSchema.class.php';
require_once APP . '/vendors/PHP-JSON-Validation/SchemaValidator.class.php';
require_once APP . '/modules/TurtlePHP-UsersModule/Users.class.php';
require_once APP . '/modules/TurtlePHP-UsersModule/includes/init.inc.php';
```

*Config file is located elsewhere*  
``` php
...
require_once APP . '/modules/TurtlePHP-UsersModule/Users.class.php';
\Modules\Users::setConfigPath('/path/to/config/file.inc.php');
require_once APP . '/modules/TurtlePHP-UsersModule/includes/init.inc.php';
```

*Config file named `config.inc.php` is being used in the plugin directory*  
``` php
...
require_once APP . '/modules/TurtlePHP-UsersModule/Users.class.php';
require_once APP . '/modules/TurtlePHP-UsersModule/includes/init.inc.php';
```
