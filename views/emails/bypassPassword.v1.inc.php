<?php

    // namespaces
    namespace Modules\Users;
    $changePasswordPath = getConfig('paths', 'changePassword');
?>Hi <?= ($user->firstName) ?>,<br /><br />

Please follow this link to reset your password:<br />
<?= ($user->getAutoLoginUrl($changePasswordPath)) ?><br /><br />

Thanks,<br />
AccountDock
