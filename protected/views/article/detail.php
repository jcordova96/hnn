<?php /* @var $this ArticleController */ ?>

<span class="article-info">Originally published <?php echo $data['article']['created']; ?></span>

<h1><?php echo $data['article']['title']; ?></h1>
<span class="byline">by <?php echo $data['article']['author']; ?></span>

<p class="lead">
    <?php echo $data['article']['lead_text']; ?>
</p>

<div class="article-image center-content">
    <img src="<?php echo $data['article']['img_src']; ?>"/>
</div>

<?php echo $data['article']['description']; ?>