<?php

    // namespaces
    namespace Modules\Users;
    $config = getConfig();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Change Password</title>
<?php
    require_once MODULE . '/includes/content/head.inc.php';
?>
        <style type="text/css">
<?php
    require_once MODULE . '/includes/static/css/common.css';
    require_once MODULE . '/includes/static/css/pages/changePassword.css';
?>
        </style>
        <script type="text/javascript">      
<?php
    require_once MODULE . '/includes/static/js/extend.js';
    require_once MODULE . '/includes/static/js/View.js';
    require_once MODULE . '/includes/static/js/views/Form.js';
    require_once MODULE . '/includes/static/js/views/pages/ChangePassword.js';
?>
        </script>
        <script type="text/javascript">
            queue.push(function() {
                (new ChangePasswordPageView(
                    $('body').first()
                ));
            });
        </script>
    </head>
    <body id="changePassword">
        <div id="wrapper">
            <header>
                <a href="/">&nbsp;</a>
            </header>
            <div id="body" class="clearfix">
                <form action="<?= ($config['paths']['changePassword']) ?>" method="post">
                    <div class="callout errors hidden">
                        <p>{message}</p>
                    </div>
                    <?php
                        $successCalloutClasses = array('callout', 'success', 'hidden');
                        $message = '{message}';
                        if (isset($_GET['saved'])) {
                            $successCalloutClasses = array('callout', 'success');
                            $message = 'Your password has been saved';
                        }
                    ?>
                    <div class="<?= implode(' ', $successCalloutClasses) ?>">
                        <p><?= ($message) ?></p>
                    </div>
                    <input type="hidden" name="csrfToken" value="<?= ($csrfToken) ?>" />
                    <div class="wrapper">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" />
                    </div>
                    <div class="wrapper">
                        <label for="passwordConfirmation">Re-enter password</label>
                        <input type="password" name="passwordConfirmation" id="passwordConfirmation" />
                    </div>
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        //<![CDATA[
            ready(
                function() {
                    js(
                        function() {
                            log('pre: ', (new Date()).getTime() - start);
                            queue.process();
                            log('post: ', (new Date()).getTime() - start);
                        }
                    );
                }
            );
        //]]>
        </script>
    </body>
</html>
