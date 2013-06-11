<?php
/* @var $this SiteController */


//echo "<pre>" . print_r($data['recent_articles'], true) . "</pre>";


$this->pageTitle = Yii::app()->name;
?>

<h1 class="invert">Week of June 3rd 2013</h1>

<?php foreach ($data['recent_articles'] as $category => $aData): ?>
    <h1><?php echo $category; ?></h1>
    <div class="article-divider"></div>
    <?php foreach ($aData as $article_data): ?>
        <ul class="thumbnails">
            <li class="span2">
                <div class="thumbnail">
                    <a href="#"><img src="http://placehold.it/260x180" alt=""></a>
                </div>
            </li>
            <li class="span4">
                <span
                    class="article-info">Originally published <?php echo date("m/d/Y", $article_data['created']); ?></span>

                <h3><a href="#"><?php echo $article_data['title']; ?></a></h3>

                <?php if (!empty($article_data['author'])): ?>
                <span class="byline">by <?php echo $article_data['author'] ?></span>
                <?php endif; ?>

                <p><?php echo $article_data['teaser']; ?></p>
            </li>
        </ul>
        <div class="article-divider"></div>
    <?php endforeach; ?>

<?php endforeach; ?>
