<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/hnn-main-1'); ?>
<?php
$blog_authors = BlogAuthor::getAuthors();
?>

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
                    <?php foreach(Article::getBreakingNews() as $article): ?>
                        <li>
                            <a href="articles/<?php echo $article['id']; ?>">
                                <?php echo $article['title']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="tab-pane" id="history-news-tab">
                <ul>
                    <?php foreach(Article::getHistoryNews() as $article): ?>
                        <li>
                            <a href="articles/<?php echo $article['id']; ?>">
                                <?php echo $article['title']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
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

<?php $this->endContent(); ?>