<?php $__env->startSection('content'); ?>
    <div class="container" id="article-search" id="goTopAnc">	
        <search-article></search-article>
        <div class="goTopBtn">
			<a href="#goTopAnc">Наверх</a>
			<img class="goTopBtn_arrow" src="/public/elements-img/orders-svg/arrow-up.svg" alt="arrow">
		</div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>