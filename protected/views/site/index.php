<?php
/* @var $this SiteController */


//echo "<pre>" . print_r($data['recent_articles'], true) . "</pre>";


$this->pageTitle = Yii::app()->name;
?>

<h1 class="invert">Recent Articles</h1>

<?php foreach ($data['recent_articles'] as $category => $aData): ?>
    <?php if (!empty($aData)): ?>

        <h1><?php echo $category; ?></h1>
        <div class="article-divider"></div>
        <?php foreach ($aData as $article_data): ?>
            <ul class="thumbnails">
                <li class="span2">
                    <?php if (!empty($article_data['tn_img'])): ?>
                        <div class="thumbnail">
                            <a href="/article/detail/<?php echo $article_data['id']; ?>">
                                <img src="<?php echo '/'.$article_data['tn_img']; ?>"
                                     alt="">
                            </a>
                        </div>
                    <?php endif; ?>
                </li>

                <li class="span4">
                    <span
                        class="article-info">Originally published <?php echo date("m/d/Y", $article_data['created']); ?></span>

                    <h3>
                        <a href="/article/detail/<?php echo $article_data['id']; ?>">
                            <?php echo $article_data['title']; ?>
                        </a>
                    </h3>

                    <?php if (!empty($article_data['author'])): ?>
                        <span class="byline">by <?php echo $article_data['author'] ?></span>
                    <?php endif; ?>

                    <p><?php echo $article_data['teaser']; ?></p>
                </li>
            </ul>
            <div class="article-divider"></div>
        <?php endforeach; ?>
    <?php endif; ?>

<?php endforeach; ?>
