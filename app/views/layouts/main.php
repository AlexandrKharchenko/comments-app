<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Comments application</title>
    <meta name="description" content="Comments application">
    <meta name="author" content="SitePoint">

    <link href="/assets/packages/bootstrap/dist/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="/assets/packages/tether/dist/css/tether.min.css" type="text/css" rel="stylesheet" />
    <link href="/assets/packages/components-font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/app.css" type="text/css" rel="stylesheet" />

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>

<body>
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Comments</a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
        </ul>

        <ul class="navbar-nav  pull-right">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo \Core\Router::getUrlByName('auth.login') ?>">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo \Core\Router::getUrlByName('auth.register') ?>">Sign up</a>
            </li>
        </ul>



    </div>
</nav>

<div id="comments-app">
    <?php echo $content; ?>
</div>




<script src="/assets/packages/jquery/dist/jquery.min.js"></script>
<script src="/assets/packages/tether/dist/js/tether.min.js"></script>

<script src="/assets/packages/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/js/vue.app.js"></script>
</body>
</html>