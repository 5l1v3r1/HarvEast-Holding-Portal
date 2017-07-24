<?php if($article = App\Article::anchored()): ?>
	<section class="mainNews whiteBox">
        <article>
            <span class="sectionInfo">
				Главная новость
			</span>
            <div class="mainNews_title">
                <h1><a href="/articles/<?php echo e($article->slug); ?>"><?php echo e($article->name); ?></a></h1>
            </div>
            <div class="mainNews_content">
               <?php echo str_limit(mediaLess($article->body), 1000, '...'); ?>

            </div>
            <div class="readMore">
                <a class="readMore_button" href="/articles/<?php echo e($article->slug); ?>">Читать дальше</a>
            </div>
            <?php if($article->media): ?>
	            <div class="mainNews_photo">
	            	<?php echo $article->media; ?>

	            </div>
	        <?php endif; ?>
            <div class="news_tags">
           		<?php $__currentLoopData = $article->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                	<a href="/articles/?tag=<?php echo e($tag->name); ?>" class="tags_item"><?php echo e($tag->name); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </article>
    </section>
<?php endif; ?>