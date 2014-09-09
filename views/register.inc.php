<?php

    // namespaces
    namespace Modules\Users;
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Register</title>
<?php
    require_once MODULE . '/includes/content/head.inc.php';
?>
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
                (new RegisterPageView(
                    $('body').first(),
                    function(response) {
                        if (response.success === true) {
                            location.href = '/welcome';
                        }
                    }
                ));
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
                    <div class="wrapper clearfix" id="nameWrapper">
                        <label for="firstName">Name</label>
                        <input type="text" name="firstName" id="firstName" placeholder="First" />
                        <input type="text" name="lastName" id="lastName" placeholder="Last" />
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
