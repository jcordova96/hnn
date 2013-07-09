<?php
    $blog_authors = BlogAuthor::getAuthors();
?>


<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" class="no-js"><!--<![endif]-->

<head>

    <!-- BEGIN: basic page needs -->
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;"/>
    <title>History News Network</title>
    <!-- END: basic page needs -->

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/style.css" rel="stylesheet" type="text/css"/>

	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/head.js"></script>

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!-- END: js -->

</head>

<body>

<!-- .container -->
<section class="container top-gradient">

<!-- #header .row -->
<header id="header">
    <div class="row">

        <!-- .span3.logo -->
        <div class="span6 logo">
            <a href="/"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/hnn-logo-new.gif" alt="Logo"/></a>
        </div>
        <!-- /.span3.logo -->

        <!-- .span9 -->
        <nav class="span6">

            <!-- #menu -->
            <ul id="menu">
                <li><a href="#">HNN Information</a>
                    <ul>
                        <li><a href="#">Submissions</a></li>
                        <li><a href="#">Advertising</a></li>
                        <li><a href="#">Donations</a></li>
                        <li><a href="#">Archives</a></li>
                        <li><a href="#">Internships</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </li>
            </ul>
            <!-- /#menu -->

        </nav>
        <!-- .span9-->

    </div>
</header>
<!-- /#header .row -->

<!-- div.navbar -->
<div class="navbar">
    <div class="navbar-inner">

        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <a class="brand" href="#">Departments</a>

        <div class="nav-collapse">
            <ul class="nav">
                <li class="active"><a href="#">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">News <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/article/category/55">Breaking News</a></li>
                        <li><a href="/article/category/26">News Archives</a></li>
                        <li><a href="http://feeds.feedburner.com/historycoalition" target="_blank">DC News</a></li>
                    </ul>
                </li>
                <li><a href="/article/category/3">At Home</a></li>
                <li><a href="/article/category/10">Abroad</a></li>
                <li><a href="/article/category/4">History</a></li>
                <li><a href="/article/category/15">Features</a></li>
                <li><a href="/article/group/3">Books</a></li>
                <li><a href="/article/group/2">Roundup</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Blogs <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php foreach($blog_authors as $blog_author_id => $blog_author): ?>
                            <li>
                                <a href="/blog/author/<?php echo $blog_author_id; ?>">
                                    <?php echo $blog_author; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
            <form class="navbar-search pull-right" action="/search" method="get">
                <input name="q" type="text" class="search-query span2" placeholder="Search">
            </form>
        </div>
        <!-- /.nav-collapse -->

    </div>
    <!-- /navbar-inner -->
</div>
<!-- /div.navbar -->

<!-- div#ad-top -->
<div id="ad-top" class="row">
    <div class="span3 center-content">
        <a href="http://chnm.gmu.edu/donate/" target="_blank"><img
                src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/ad/chmm-donate-black1.png"></a>
    </div>
    <div class="span6 center-content">
        <a href="http://129.174.131.239/ad/redirect/138489/t151?url=home" target="_blank"><img
                src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/ad/history-channel-long-banner.jpg"></a>
    </div>
    <div class="span3 center-content">
        <a href="http://www.americanheritage.com/" target="_blank"><img
                src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/ad/american-heritage.jpg"></a>
    </div>
</div>
<!-- /div#ad-top -->

<div class="divider-top"></div>

<section id="main-container" class="row">

  <?php echo $content; ?>

</section>

<!-- #footer.container -->
<footer id="footer" class="container">

    <!-- #copyright.clearfix -->
    <div id="copyright" class="clearfix">

        <p>Copyright <?php echo date('Y'); ?>. All rights reserved.</p>

        <!-- #footer-menu -->
        <nav id="footer-menu">
            <ul class="clearfix">
                <li><a href="#" class="current" data-description="Home Page">Newsletter</a>
                </li>
                <li><a href="#">Submissions</a></li>
                <li><a href="#">Advertising</a></li>
                <li><a href="#">Donations</a></li>
                <li><a href="#">Archives</a></li>
                <li><a href="#">Internships</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </nav>
        <!-- /#footer-menu -->

    </div>
    <!-- /#copyright .clearfix -->

</footer>
<!-- /#footer .container -->

</section>
<!-- /.container -->

</body>
</html>