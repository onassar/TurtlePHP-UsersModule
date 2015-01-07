<?php

    // namespaces
    namespace Modules\Users;
    $config = getConfig();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Account Recovery</title>
<?php
    require_once MODULE . '/includes/content/head.inc.php';
?>
        <style type="text/css">
<?php
    require_once MODULE . '/includes/static/css/common.css';
    require_once MODULE . '/includes/static/css/pages/bypassPassword.css';
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
    require_once MODULE . '/includes/static/js/views/pages/BypassPassword.js';
?>
        </script>
        <script type="text/javascript">
            queue.push(function() {
                (new BypassPasswordPageView(
                    $('body').first()
                ));
            });
        </script>
    </head>
    <body id="bypassPassword">
        <div id="wrapper">
            <header>
                <a href="/">&nbsp;</a>
            </header>
            <div id="body" class="clearfix">
                <?php if (isset($_GET['sent'])): ?>
                    <form action="<?= getConfig('paths', 'bypassPassword') ?>" method="post">
                        <div class="callout success">
                            <p>
                                Check your email for a link to login and change your
                                password
                            </p>
                        </div>
                    </form>
                <?php else: ?>
                    <p>
                        Enter your email below and we’ll send you a link to update
                        your password
                    </p>
                    <form action="<?= getConfig('paths', 'bypassPassword') ?>" method="post">
                        <div class="callout errors hidden">
                            <p>{message}</p>
                        </div>
                        <input type="hidden" name="csrfToken" value="<?= ($csrfToken) ?>" />
                        <div class="wrapper">
                            <input type="text" name="email" id="email" placeholder="example@whatever.com" />
                        </div>
                        <button type="submit">Send Recovery Email</button>
                    </form>
                <?php endif; ?>
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
