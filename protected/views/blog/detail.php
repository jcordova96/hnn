<?php /* @var $this BlogController */ ?>

<span class="blog-info">Originally published <?php echo date("m/d/Y", $data['blog']['created']); ?></span>

<h1><?php echo $data['blog']['title']; ?></h1>

<?php if (!empty($data['blog']['author'])): ?>
	<span class="byline">by <?php echo $data['blog']['author'] ?></span>
<?php endif; ?>

<?php if (!empty($data['blog']['lead_text'])): ?>
<p class="lead">
    <?php echo $data['blog']['lead_text']; ?>
</p>
<?php endif; ?>

<?php echo $data['blog']['body']; ?>