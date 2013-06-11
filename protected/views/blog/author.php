<?php
/* @var $this ArticleController */


//echo "<pre>" . print_r($data['recent_articles'], true) . "</pre>";


$this->pageTitle = Yii::app()->name;
?>

<h1 class="invert"><?php echo $data['blog_entries'][0]['author']; ?></h1>

<?php foreach ($data['blog_entries'] as $blog_data): ?>
	<ul class="thumbnails">
		<li class="span2">
			<?php if (!empty($blog_data['tn_img'])): ?>
				<div class="thumbnail">
					<a href="/blog/detail/<?php echo $blog_data['id']; ?>">
						<img src="<?php echo '/'.$blog_data['tn_img']; ?>"
							 alt="">
					</a>
				</div>
			<?php endif; ?>
		</li>

		<li class="span4">
			<span
				class="article-info">Originally published <?php echo date("m/d/Y", $blog_data['created']); ?></span>

			<h3>
				<a href="/blog/detail/<?php echo $blog_data['id']; ?>">
					<?php echo $blog_data['title']; ?>
				</a>
			</h3>

			<?php if (!empty($blog_data['author'])): ?>
				<span class="byline">by <?php echo $blog_data['author'] ?></span>
			<?php endif; ?>

			<p><?php echo $blog_data['teaser']; ?></p>
		</li>
	</ul>
	<div class="article-divider"></div>
<?php endforeach; ?>
