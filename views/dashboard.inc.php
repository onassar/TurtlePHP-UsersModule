<?php

    // namespaces
    namespace Modules\Users;
    $config = getConfig();
?>
<a href="<?= ($loggedInUser->getLogoutPath()) ?>">Logout</a>
