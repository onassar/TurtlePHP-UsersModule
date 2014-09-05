<?php

    // namespaces
    namespace Modules\Users;
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Register</title>
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript">
        //<![CDATA[
            var start=(new Date).getTime(),booted=[],included=false,required=[],js=function(e,t){if(arguments.length===0){t=function(){};e=[]}else if(arguments.length===1){t=e;e=[]}var n=function(e,t){var n=document.createElement("script"),r=document.getElementsByTagName("script"),s=r.length,o=function(){try{t&&t()}catch(e){i(e)}};n.setAttribute("type","text/javascript");n.setAttribute("charset","utf-8");if(n.readyState){n.onreadystatechange=function(){if(n.readyState==="loaded"||n.readyState==="complete"){n.onreadystatechange=null;o()}}}else{n.onload=o}n.setAttribute("src",e);document.body.insertBefore(n,r[s-1].nextSibling)},r=function(e,t){for(var n=0,r=e.length;n<r;++n){if(e[n]===t){return true}}return false},i=function(e){log("Caught Exception:");log(e.stack);log("")};if(included===false){if(typeof e==="string"){e=[e]}e=e.concat(required);included=true}if(typeof e==="string"){if(r(booted,e)){t()}else{booted.push(e);n(e,t)}}else if(e.constructor===Array){if(e.length!==0){js(e.shift(),function(){js(e,t)})}else{try{t&&t()}catch(s){i(s)}}}},log=function(){if(typeof console!=="undefined"&&console&&console.log){var e=arguments.length>1?arguments:arguments[0];console.log(e)}},queue=function(){var e=[];return{push:function(t){e.push(t)},process:function(){var t;while(t=e.shift()){t()}},unshift:function(t){e.unshift(t)}}}(),ready=function(e){var t=false,n=true,r=window.document,i=r.documentElement,s=r.addEventListener?"addEventListener":"attachEvent",o=r.addEventListener?"removeEventListener":"detachEvent",u=r.addEventListener?"":"on",a=function(n){if(n.type==="readystatechange"&&r.readyState!=="complete"){return}(n.type==="load"?window:r)[o](u+n.type,a,false);if(!t&&(t=true)){e()}},f=function(){try{i.doScroll("left")}catch(e){setTimeout(f,50);return}a("poll")};if(r.readyState==="complete"){e.call(window,"lazy")}else{if(r.createEventObject&&i.doScroll){try{n=!window.frameElement}catch(l){}if(n){f()}}r[s](u+"DOMContentLoaded",a,false);r[s](u+"readystatechange",a,false);window[s](u+"load",a,false)}},require=function(e){if(typeof e==="string"){e=[e]}required=required.concat(e)}
        //]]>
        </script>
        <link href="//fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <style type="text/css">
<?php
    require_once MODULE . '/includes/static/css/common.css';
    require_once MODULE . '/includes/static/css/pages/register.css';
?>
        </style>
        <script type="text/javascript">      
<?php
    require_once MODULE . '/includes/static/js/extend.js';
    require_once MODULE . '/includes/static/js/View.js';
    require_once MODULE . '/includes/static/js/views/Form.js';
    require_once MODULE . '/includes/static/js/views/pages/Register.js';
?>
        </script>
        <script type="text/javascript">
            queue.push(function() {
                (new RegisterPageView($('body').first()));
            });
        </script>
    </head>
    <body id="register">
        <div id="wrapper">
            <header>
                <a href="/">&nbsp;</a>
            </header>
            <div id="body" class="clearfix">
                <form action="<?= getConfig('paths', 'register') ?>" method="post">
                    <div class="callout errors hidden">
                        <p>{message}</p>
                    </div>
                    <input type="hidden" name="csrfToken" value="<?= ($csrfToken) ?>" />
                    <div class="wrapper">
                        <label for="firstName">First name</label>
                        <input type="text" name="firstName" id="firstName" />
                    </div>
                    <div class="wrapper">
                        <label for="lastName">Last name</label>
                        <input type="text" name="lastName" id="lastName" />
                    </div>
                    <div class="wrapper">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" />
                    </div>
                    <div class="wrapper">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" />
                    </div>
                    <div class="wrapper">
                        <label for="passwordConfirmation">Re-enter password</label>
                        <input type="password" name="passwordConfirmation" id="passwordConfirmation" />
                    </div>
                    <?php if (getConfig('defaults', 'stripeCheckout') === true && isset($_GET['planId'])): ?>
                        <input type="hidden" name="planId" value="<?= ((int) $_GET['planId']) ?>" />
                        <div class="container">
                            <div class="wrapper">
                                <label for="ccNumber">Credit card number</label>
                                <input type="text" name="ccNumber" id="ccNumber" />
                            </div>
                            <div class="aux">
                                <div class="wrapper left">
                                    <label for="cvc">CVC</label>
                                    <input type="password" name="cvc" id="cvc" />
                                </div>
                                <div class="wrapper left">
                                    <label for="expiry">Expiry date</label>
                                    <input type="text" name="expiry" id="expiry" placeholder="MM/YY" />
                                </div>
                            </div>
                            <?php
                                if (
                                    getConfig('defaults', 'stripeCheckout') === true
                                    && \getConfig('TurtlePHP-StripeModule', 'applyTaxes') === true
                                ):
                            ?>
                                <div class="location">
                                    <div class="wrapper left">
                                        <label for="country">Do you live in Canada?</label>
                                        
                                    </div>
                                    <div class="wrapper left">
                                        <label for="country">Provinces</label>
                                        <select name="province">
                                            <?php
                                                $provinces = \getConfig('TurtlePHP-StripeModule', 'provinces');
                                                foreach ($provinces as $province):
                                            ?>
                                                <option value="<?= ($province['handle']) ?>"><?= ($province['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php
                                if (
                                    getConfig('defaults', 'stripeCheckout') === true
                                    && \getConfig('TurtlePHP-StripeModule', 'frequencyToggle') === true
                                ):
                            ?>
                                <div class="frequency">
                                    Monthly / yearly toggle
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php
                        $checked = 1;
                        if (\Geo::getCountry() === 'CA') {
                            $checked = 0;
                        }
                    ?>
                    <div class="wrapper clearfix">
                        <input type="checkbox" name="receiveNewsletters" id="receiveNewsletters" value="1" <?= ($checked === 1 ? 'checked="checked" ' : '') ?>/>
                        <label for="receiveNewsletters">Get updates on new features &amp; promos</label>
                    </div>
                    <div class="wrapper clearfix" id="termsWrapper">
                        <input type="checkbox" name="terms" id="terms" value="1" />
                        <label for="terms">I agree to the&nbsp;</label>
                        <a href="<?= getConfig('paths', 'terms') ?>">terms of service</a>
                    </div>
                    <button type="submit">Register</button>
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
