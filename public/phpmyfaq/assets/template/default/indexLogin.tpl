<!doctype html>
<!--[if lt IE 7 ]> <html lang="{metaLanguage}" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]> <html lang="{metaLanguage}" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="{metaLanguage}" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="{metaLanguage}" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="{metaLanguage}" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>{title}</title>
    <base href="{baseHref}" />

    <meta name="description" content="{metaDescription}">
    <meta name="keywords" content="{metaKeywords}">
    <meta name="author" content="{metaPublisher}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="application-name" content="phpMyFAQ {phpmyfaqversion}">
    <meta name="robots" content="INDEX, FOLLOW">
    <meta name="revisit-after" content="7 days">

    <!-- Share on Facebook -->
    <meta property="og:title" content="{title}" />
    <meta property="og:description" content="{metaDescription}" />
    <meta property="og:image" content="" />

    <link rel="stylesheet" href="{baseHref}assets/template/{tplSetName}/css/{stylesheet}.min.css?v=1">
    <link rel="shortcut icon" href="{baseHref}assets/template/{tplSetName}/favicon.ico">
    <link rel="apple-touch-icon" href="{baseHref}assets/template/{tplSetName}/apple-touch-icon.png">
    <link rel="canonical" href="{currentPageUrl}">

    <script src="{baseHref}assets/js/libs/modernizr.min.js"></script>
    <script src="{baseHref}assets/js/phpmyfaq.min.js"></script>

    <link rel="alternate" title="News RSS Feed" type="application/rss+xml" href="{baseHref}feed/news/rss.php">
    <link rel="alternate" title="TopTen RSS Feed" type="application/rss+xml" href="{baseHref}feed/topten/rss.php">
    <link rel="alternate" title="Latest FAQ Records RSS Feed" type="application/rss+xml" href="{baseHref}feed/latest/rss.php">
    <link rel="alternate" title="Open Questions RSS Feed" type="application/rss+xml" href="{baseHref}feed/openquestions/rss.php">
    <link rel="search" type="application/opensearchdescription+xml" title="{metaTitle}" href="{opensearch}">

    <style> html{display:none;} </style>
</head>
<body dir="{dir}">

<!--[if lt IE 8 ]>
<div class="internet-explorer-error">
    Did you know that your Internet Explorer is out of date?<br/>
    Please use Internet Explorer 8+, Mozilla Firefox 4+, Google Chrome, Apple Safari 5+ or Opera 11+
</div>
 <![endif]-->

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="brand" title="{header}" href="{faqHome}">{header}</a>
        </div>
    </div>
</div>

<section id="content">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span3" id="leftContent">
            </div>
            <div class="span6" id="mainContent">
                <section>
                    <header>
                        <h2>{loginHeader}</h2>
                    </header>

                    {loginMessage}

                    <form class="form-horizontal" action="{writeLoginPath}" method="post" accept-charset="utf-8">
                        <input type="hidden" name="faqloginaction" value="{faqloginaction}"/>

                        <div class="control-group">
                            <label class="control-label" for="faqusername">{username}</label>
                            <div class="controls">
                                <input type="text" name="faqusername" id="faqusername" required="required" autofocus="autofocus">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="faqpassword">{password}</label>
                            <div class="controls">
                                <input type="password" name="faqpassword" id="faqpassword" required="required">
                                <p class="help-block">{sendPassword}</p>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <label class="checkbox">
                                    <input type="checkbox" id="faqrememberme" name="faqrememberme" value="rememberMe">
                                {rememberMe}
                                </label>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary btn-large" type="submit">
                                {loginHeader}
                            </button>
                        </div>
                    </form>

                </section>
            </div>
            <div class="span3" id="rightContent">
            </div>
        </div>
    </div>
</section>

<footer id="footer" class="container-fluid">
    <div class="row-fluid">
        <div class="span6">
            <ul class="footer-menu">
                <li>{showSitemap}</li>
                <li>{msgContact}</li>
                <li>{msgGlossary}</li>
            </ul>
        </div>
        <div class="span6">
            <form action="{writeLangAdress}" method="post" class="pull-right" accept-charset="utf-8">
            {switchLanguages}
                <input type="hidden" name="action" value="" />
            </form>
        </div>
    </div>
    <div class="row">
        <p class="copyright pull-right">
        {copyright}
        </p>
    </div>
</footer>

{debugMessages}

</body>
</html>