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
<section class="container">

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

    <!-- Left column -->
    <div id="left-column" class="span3 center-content">
        <!-- Twitter -->
        <a class="twitter-timeline" href="https://twitter.com/myHNN" data-widget-id="343410152646524928">Tweets by
            @myHNN</a>
        <script>!function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + "://platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, "script", "twitter-wjs");</script>

        <!-- Blogs -->
        <div id="blog-nav-sidebar">
            <ul class="nav nav-tabs nav-stacked">
                <h1 class="invert">Blogs</h1>

                <?php foreach($blog_authors as $blog_author_id => $blog_author): ?>
                    <li>
                        <a href="/blog/author/<?php echo $blog_author_id; ?>">
                            <?php echo $blog_author; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Newsletter signup -->
        <div class="contact-form-div">
            <form class="well">
                <h4>Join our mailing list</h4>
                <input class="span2" type="email" placeholder="Your email address">
                <span class="help-block">HNN updates for your inbox.</span>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    </div>

    <!-- Center column -->
    <div id="center-column" class="span6">

        <?php echo $content; ?>

    </div>

    <!-- Right column -->
    <div id="right-column" class="span3 center-content">

        <div id="news-widget" class="tabbable">
            <h1 class="invert">News</h1>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#breaking-news-tab" data-toggle="tab">Breaking News</a></li>
                <li><a href="#history-news-tab" data-toggle="tab">History News</a></li>
                <li><a href="http://feeds.feedburner.com/historycoalition" target="_blank">DC</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="breaking-news-tab">

                    <ul>
                        <li><a href="#">Link to story 1</a></li>
                        <li><a href="#">Another headline for the next item, have to see this on ewrap so..</a></li>
                        <li><a href="#">Third article would be going here</a></li>
                        <li><a href="#">Link to story 4</a></li>
                        <li><a href="#">More links to more articles</a></li>
                    </ul>
                </div>
                <div class="tab-pane" id="history-news-tab">
                    <ul>
                        <li><a href="#">Another headline for the next item</a></li>
                        <li><a href="#">Link to story 1</a></li>
                        <li><a href="#">More links to more articles .. </a></li>
                        <li><a href="#">Link to story 4</a></li>
                        <li><a href="#">Third article would be going here</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/ad/historiansrateobama.jpg"/></div>
        <div><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/ad/american-revolution-museum.jpg"/></div>
        <div><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/ad/wiebe-ad.jpg"/></div>
        <div><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/ad/cbmb-book.jpg"/></div>
        <div><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/ad/pipes-hnn.png"/></div>
        <div><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/hnn/ad/aihe-ad-2.jpg"/></div>

    </div>
</section>

<!-- #footer.container -->
<footer id="footer" class="container">

    <!-- .row .clearfix -->
    <div class="row clearfix">

        <!-- .span3 -->
        <div class="span3">

            <h3 class="title">About Us</h3>

            <p>Welcome to George Mason University's History News Network (which is popularly known as HNN).</p>

            <p>Our mission is to help put current events into historical perspective. </p>

        </div>
        <!-- /.span3 -->

        <!-- .span3 -->
        <div class="span3">

            <h3 class="title">Latest Tweets</h3>

            <div class="tweet"></div>

			<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/foot.js"></script>

            <script type="text/javascript">
                $(document).ready(function () {
                    //TWITTER
                    $(".tweet").tweet({
                        join_text: "auto",
                        username: "envato",
                        avatar_size: 0,
                        count: 2,
                        auto_join_text_default: "we said,",
                        auto_join_text_ed: "we",
                        auto_join_text_ing: "we were",
                        auto_join_text_reply: "we replied",
                        auto_join_text_url: "we were checking out",
                        loading_text: "loading tweets..."
                    });
                });
            </script>

        </div>
        <!-- /.span3 -->

        <!-- .span3 -->
        <div class="span3">

            <h3 class="title">Recent Post</h3>

            <ul>
                <li class="first">
                    <span class="date">April 18, 2012</span>
                    <a href="">HNN blog post </a>
                </li>


                <li>
                    <span class="date">April 18, 2012</span>
                    <a href="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ligula mauris.</a>
                </li>
            </ul>

        </div>
        <!-- /.span3 -->

        <!-- .span3 -->
        <div class="span3">

            <h3 class="title">Follow Us</h3>

            <!-- .social -->
            <ul class="social">
                <li class="twitter"><a href="#">twitter</a></li>
                <li class="facebook"><a href="#">facebook</a></li>
                <li class="dribbble"><a href="#">dribbble</a></li>
                <li class="vimeo"><a href="#">vimeo</a></li>
                <li class="flickr"><a href="#">flickr</a></li>
                <li class="pinterest"><a href="#">pinterest</a></li>
            </ul>
            <!-- /.social -->

        </div>
        <!-- /.span3 -->

    </div>
    <!-- /.row .clearfix -->

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