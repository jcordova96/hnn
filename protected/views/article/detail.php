<?php /* @var $this ArticleController */ ?>

<span class="article-info">Originally published <?php echo date("m/d/Y", $data['article']['created']); ?></span>

<h1><?php echo $data['article']['title']; ?></h1>

<?php if (!empty($data['article']['author'])): ?>
	<span class="byline">by <?php echo $data['article']['author'] ?></span>
<?php endif; ?>

<?php if (!empty($data['article']['lead_text'])): ?>
<p class="lead">
    <?php echo $data['article']['lead_text']; ?>
</p>
<?php endif; ?>

<?php echo $data['article']['body']; ?>