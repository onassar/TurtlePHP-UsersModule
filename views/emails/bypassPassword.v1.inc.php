<?php

    // namespaces
    namespace Modules\Users;
    $changePasswordPath = getConfig('paths', 'changePassword');
?>login bypass v1
<?= ($user->getAutoLoginUrl($changePasswordPath)) ?>
