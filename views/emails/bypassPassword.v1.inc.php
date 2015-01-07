<?php

    // namespaces
    namespace Modules\Users;
    $changePasswordPath = getConfig('paths', 'changePassword');
?>Hi <?= ($user->firstName) ?>,

Please follow this link to reset your password:
<?= ($user->getAutoLoginUrl($changePasswordPath)) ?>

Thanks,
AccountDock
