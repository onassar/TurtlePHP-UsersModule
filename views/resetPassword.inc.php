<?php

    // namespaces
    namespace Modules\Users;
    $config = getConfig();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Reset Password</title>
<?php
    require_once MODULE . '/includes/content/head.inc.php';
?>
        <style type="text/css">
<?php
    require_once MODULE . '/includes/static/css/common.css';
    require_once MODULE . '/includes/static/css/pages/resetPassword.css';
    if ($config['defaults']['css'] !== false):
        $bust = filemtime(WEBROOT . ($config['defaults']['css']));
?>
    <link rel="stylesheet" href="<?= ($config['defaults']['css']) ?>?cache=<?= ($bust) ?>">
<?php
    endif;
?>
        </style>
        <script type="text/javascript">      
<?php
    require_once MODULE . '/includes/static/js/extend.js';
    require_once MODULE . '/includes/static/js/View.js';
    require_once MODULE . '/includes/static/js/views/Form.js';
    require_once MODULE . '/includes/static/js/views/pages/ResetPassword.js';
?>
        </script>
        <script type="text/javascript">
            queue.push(function() {
                (new ResetPasswordPageView(
                    $('body').first()
                ));
            });
        </script>
    </head>
    <body id="resetPassword">
        <div id="wrapper">
            <header>
                <a href="/">&nbsp;</a>
            </header>
            <div id="body" class="clearfix">
                <p>
                    Enter your email below and we’ll send you a new temporary
                    password, which you can change after logging in.
                </p>
                <form action="<?= getConfig('paths', 'resetPassword') ?>" method="post">
                    <input type="hidden" name="successRedirectPath" value="<?= getConfig('paths', 'login') ?>?reset" />
                    <div class="callout errors hidden">
                        <p>{message}</p>
                    </div>
                    <input type="hidden" name="csrfToken" value="<?= ($csrfToken) ?>" />
                    <div class="wrapper">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" placeholder="example@whatever.com" />
                    </div>
                    <button type="submit">Reset Password</button>
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
