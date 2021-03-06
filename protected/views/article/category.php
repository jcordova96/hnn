<?php
/* @var $this ArticleController */


//echo "<pre>" . print_r($data['recent_articles'], true) . "</pre>";


$this->pageTitle = Yii::app()->name;
?>

<h1 class="invert"><?php echo $data['category']; ?></h1>

<?php foreach ($data['articles'] as $article_data): ?>
	<ul class="thumbnails">
		<li class="span2">
			<?php if (!empty($article_data['tn_img'])): ?>
				<div class="thumbnail">
					<a href="/article/<?php echo $article_data['id']; ?>">
						<img src="<?php echo '/'.$article_data['tn_img']; ?>"
							 alt="">
					</a>
				</div>
			<?php endif; ?>
		</li>

		<li class="span4">

            <?php if(isset($article_data['category'])): ?>
                <a href='/article/category/<?php echo $article_data['category_id']; ?>'>
                    <?php echo $article_data['category']; ?>
                </a><br /><br />
            <?php endif; ?>

			<span class="article-info">
                Originally published <?php echo date("m/d/Y", $article_data['created']); ?>
            </span>

			<h3>
				<a href="/article/<?php echo $article_data['id']; ?>">
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
