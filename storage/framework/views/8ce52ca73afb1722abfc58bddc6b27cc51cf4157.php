<?php 
	$articles = App\Article::relevant(5);
 ?>
<?php if($articles->count()): ?>
<div class="asideBox">
	<?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<article class="aside_section">
		<span class="sectionInfo">
			<?php echo e($article->created_at->diffForHumans()); ?>

		</span>
		<div class="secondaryNews">
		    <a class="secondaryNews_title" href="/articles/<?php echo e($article->slug); ?>"><h2><?php echo e($article->name); ?></h2></a>
		</div>
		<div class="secondaryNews_content">
		    <p><?php echo e(str_limit(strip_tags($article->body), 160, '...')); ?></p>
		</div>
		<div class="readMore">
		    <a class="readMoreS_button"href="/articles/<?php echo e($article->slug); ?>">Читать дальше</a>
		</div>
		<div class="news_tags">
			<?php $__currentLoopData = $article->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		    	<a class="tags_item" href="/articles/?tag=<?php echo e($tag->name); ?>"><?php echo e($tag->name); ?></a>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</article>
	<div class="divider"></div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<article class="aside_section">
        <div class="readNews">
            <a class="readNews_button" href="/articles">Все новости</a>
        </div>
    </article>
</div>
<?php endif; ?>