<?php

    // namespaces
    namespace Modules\Users;
    $config = getConfig();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Terms</title>
<?php
    require_once MODULE . '/includes/content/head.inc.php';
?>
        <style type="text/css">
<?php
    require_once MODULE . '/includes/static/css/common.css';
    require_once MODULE . '/includes/static/css/pages/terms.css';
?>
        </style>
<?php
    if ($config['defaults']['css'] !== false):
        $bust = filemtime(WEBROOT . ($config['defaults']['css']));
?>
        <link rel="stylesheet" href="<?= ($config['defaults']['css']) ?>?cache=<?= ($bust) ?>">
<?php
    endif;
?>
        <script type="text/javascript">      
<?php
    require_once MODULE . '/includes/static/js/extend.js';
    require_once MODULE . '/includes/static/js/View.js';
    require_once MODULE . '/includes/static/js/views/Form.js';
    require_once MODULE . '/includes/static/js/views/pages/Terms.js';
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
    <body id="terms">
        <div id="wrapper">
            <header>
                <a href="/">&nbsp;</a>
            </header>
            <div id="body" class="clearfix">
                <div id="content">
                    Terms
                </div>
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
