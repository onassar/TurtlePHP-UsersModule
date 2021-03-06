<?php
    namespace Modules\Users;
    $config = getConfig();
?>
        <script type="text/javascript">
        //<![CDATA[
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?= ($config['defaults']['gACode']) ?>']);
            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        //]]>
        </script>

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript">
        //<![CDATA[
            var start=(new Date).getTime(),booted=[],included=false,required=[],js=function(e,t){if(arguments.length===0){t=function(){};e=[]}else if(arguments.length===1){t=e;e=[]}var n=function(e,t){var n=document.createElement("script"),r=document.getElementsByTagName("script"),s=r.length,o=function(){try{t&&t()}catch(e){i(e)}};n.setAttribute("type","text/javascript");n.setAttribute("charset","utf-8");if(n.readyState){n.onreadystatechange=function(){if(n.readyState==="loaded"||n.readyState==="complete"){n.onreadystatechange=null;o()}}}else{n.onload=o}n.setAttribute("src",e);document.body.insertBefore(n,r[s-1].nextSibling)},r=function(e,t){for(var n=0,r=e.length;n<r;++n){if(e[n]===t){return true}}return false},i=function(e){log("Caught Exception:");log(e.stack);log("")};if(included===false){if(typeof e==="string"){e=[e]}e=e.concat(required);included=true}if(typeof e==="string"){if(r(booted,e)){t()}else{booted.push(e);n(e,t)}}else if(e.constructor===Array){if(e.length!==0){js(e.shift(),function(){js(e,t)})}else{try{t&&t()}catch(s){i(s)}}}},log=function(){if(typeof console!=="undefined"&&console&&console.log){var e=arguments.length>1?arguments:arguments[0];console.log(e)}},queue=function(){var e=[];return{push:function(t){e.push(t)},process:function(){var t;while(t=e.shift()){t()}},unshift:function(t){e.unshift(t)}}}(),ready=function(e){var t=false,n=true,r=window.document,i=r.documentElement,s=r.addEventListener?"addEventListener":"attachEvent",o=r.addEventListener?"removeEventListener":"detachEvent",u=r.addEventListener?"":"on",a=function(n){if(n.type==="readystatechange"&&r.readyState!=="complete"){return}(n.type==="load"?window:r)[o](u+n.type,a,false);if(!t&&(t=true)){e()}},f=function(){try{i.doScroll("left")}catch(e){setTimeout(f,50);return}a("poll")};if(r.readyState==="complete"){e.call(window,"lazy")}else{if(r.createEventObject&&i.doScroll){try{n=!window.frameElement}catch(l){}if(n){f()}}r[s](u+"DOMContentLoaded",a,false);r[s](u+"readystatechange",a,false);window[s](u+"load",a,false)}},require=function(e){if(typeof e==="string"){e=[e]}required=required.concat(e)}
        //]]>
        </script>
        <link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900|Raleway:400,300,600,700|Handlee" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
