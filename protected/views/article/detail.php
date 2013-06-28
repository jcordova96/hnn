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


<br />
<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'hnndev'; // Required - Replace example with your forum shortname
    var disqus_identifier = '<?php echo Comment::getDisqusIdentifier($data['article']['id'], $data['article']['created'], 'article'); ?>';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>


<?php if(!empty($data['legacy_comments'])): ?>
    <hr />
    <h2>More Comments:</h2>
    <?php foreach($data['legacy_comments'] as $comment): ?>
        <hr />
        <div>
            <h3>
                <?php echo $comment['name']; ?> -
                <?php echo date('n/j/Y', $comment['timestamp']); ?>
            </h3>
            <p><?php echo $comment['comment']; ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>