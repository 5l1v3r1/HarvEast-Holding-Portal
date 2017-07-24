<?php $__env->startSection('content'); ?>
<main id="single_article" class="news_column homeWrap">
			<div class="news_wrap">

				<div class="returnBox">
					<a class="returnNews_button" href="/articles">
						<i class="fa fa-angle-double-left fa_button">
						</i>Вернутся к новостям
					</a>
					
				</div>
				<section  class="whiteBox">
					
					<article>
						<span class="sectionInfo">
							
						</span>
						<div class="allNews_title">
							<h1><?php echo e($article->name); ?></h1>
						</div>
						<div class="mainNews_content">
							<?php echo $article->body; ?>

						</div>
						<div class="news_tags">
			           		<?php $__currentLoopData = $article->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                	<a href="/articles/?tag=<?php echo e($tag->name); ?>" class="tags_item"><?php echo e($tag->name); ?></a>
			                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			            </div>
						<div class="comments_wrap">
						<?php $__currentLoopData = $comments['comments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="comment_created comment_divider first_commentDivider">
								<div class="comment_avatar">
									<img class="stuffResult_img" src="<?php echo e($comment->user->photo); ?>" alt="staff">
								</div>
								<div class="comment_content">
									<div class="comment_title">
										<div class="user_name"><a href="/users/<?php echo e($comment->user->id); ?>"><?php echo e($comment->user->name); ?></a></div>
										<div class="sectionInfo"><?php echo e($comment->created_at->diffForHumans()); ?></div>
									</div>
									<div class="comment_descr">
										<p><?php echo e($comment->body); ?></p>
									</div>
									<div class="comment_answer" @click="answerTo(<?php echo e($comment->id); ?>)">Ответить</div>
								</div>
							</div>
							<?php $__currentLoopData = $comments['sub_comments'][$id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($sub_comment): ?>
									<div class="comment_created comment_divider answerComment">
									<div class="comment_avatar">
										<img class="stuffResult_img" src="<?php echo e($sub_comment->user->photo); ?>" alt="staff">
									</div>
									<div class="comment_content">
										<div class="comment_title">
											<div class="user_name"><a href=""><?php echo e($sub_comment->user->name); ?></a></div>
											<div class="sectionInfo"><?php echo e($sub_comment->created_at->diffForHumans()); ?></div>
										</div>
										<div class="comment_descr">
											<p><?php echo e($sub_comment->body); ?></p>
										</div>
										<div class="comment_answer" @click="answerTo(<?php echo e($comment->id); ?>)">Ответить</div>										
									</div>
								</div>
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<div class="comment_creatingForm comment_divider">
								<div class="comment_avatar">
									<img class="stuffResult_img" src="<?php echo e($user->photo); ?>" alt="staff">
								</div>
								<div class="comment_content">
									<form class="comment_form" name="comment" method="post" action="/articles/<?php echo e($article->slug); ?>/comment">
											<input type="hidden" name="parent_id" :value="parent_id">
											<?php echo e(csrf_field()); ?>

											<textarea class="comment_bClick" id="comment" name="body" cols="75" rows="1" placeholder="Написать комментарий"></textarea>
											<input class="btn_addComment" type="submit" value="Отправить">
									</form>
								</div>
							</div>

						</div>
					</article>
				</section>
				<div class="returnBox">
					<a class="returnNews_button" href="/articles">
						<i class="fa fa-angle-double-left fa_button">
						</i>Вернутся к новостям
					</a>
				</div>
			</div>			
	</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>