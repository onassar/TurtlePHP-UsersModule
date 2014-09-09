<?php

    // namespaces
    namespace Modules\Users;
    $config = getConfig();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login</title>
<?php
    require_once MODULE . '/includes/content/head.inc.php';
?>
        <style type="text/css">
<?php
    require_once MODULE . '/includes/static/css/common.css';
    require_once MODULE . '/includes/static/css/pages/login.css';
?>
        </style>
        <script type="text/javascript">      
<?php
    require_once MODULE . '/includes/static/js/extend.js';
    require_once MODULE . '/includes/static/js/View.js';
    require_once MODULE . '/includes/static/js/views/Form.js';
    require_once MODULE . '/includes/static/js/views/pages/Login.js';
?>
        </script>
        <script type="text/javascript">
            queue.push(function() {
                (new LoginPageView(
                    $('body').first()
                ));
            });
        </script>
    </head>
    <body id="login">
        <div id="wrapper">
            <header>
                <a href="/">&nbsp;</a>
            </header>
            <div id="body" class="clearfix">
                <form action="<?= ($config['paths']['login']) ?>" method="post">
                    <div class="callout errors hidden">
                        <p>{message}</p>
                    </div>
                    <?php
                        $successCalloutClasses = array('callout', 'success', 'hidden');
                        $message = '{message}';
                        if (isset($_GET['reset'])) {
                            $successCalloutClasses = array('callout', 'success');
                            $message = 'A temporary password has been sent ' .
                                'to your email';
                        }
                    ?>
                    <div class="<?= implode(' ', $successCalloutClasses) ?>">
                        <p><?= ($message) ?></p>
                    </div>
                    <input type="hidden" name="csrfToken" value="<?= ($csrfToken) ?>" />
                    <?php
                        $emailValue = '';
                        if (isset($_COOKIE['email'])) {
                            $emailValue = rawurldecode($_COOKIE['email']);
                        }
                    ?>
                    <div class="wrapper">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= ($emailValue) ?>" />
                    </div>
                    <div class="wrapper">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" />
                    </div>
                    <div class="wrapper clearfix">
                        <?php
                            $checked = $config['defaults']['rememberMe'];
                        ?>
                        <input type="checkbox" name="rememberMe" id="rememberMe" value="1" <?= ($checked === true ? 'checked="checked" ' : '') ?>/>
                        <label for="rememberMe">Remember me</a>
                    </div>
                    <button type="submit" data-submit="true">Login</button>
                    <?php
                        $passwordPath = getConfig(
                            'paths',
                            $config['defaults']['accountRecoveryMethod']
                        );
                    ?>
                </form>
                <p>
                    <a href="<?= ($passwordPath) ?>">Forgot your password?</a>
                </p>
                <p>
                    <a href="<?= ($config['paths']['register']) ?>">Create an account</a>
                </p>
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
