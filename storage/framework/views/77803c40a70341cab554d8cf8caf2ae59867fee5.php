<header>
    <div class="head_menu">
        <div class="main_column head_items">
            <div class="logo_wrap">

                <a href="/">
                    <!-- <img src="/public/elements-img/logo/harveast-logo-new.svg" alt=""> -->
                    <!-- <div class="logo" > -->
                    <!-- </div> -->
                    Главная
                </a>
            </div>
            <nav class="menu_wrap">
                <ul class="menu">
                    <li class="menu_item"><a href="<?php echo e(url('/articles')); ?>">Новости</a></li>
                    <li class="menu_item"><a href="<?php echo e(url('/users')); ?>">Сотрудники</a></li>
                    <li class="menu_item"><a href="<?php echo e(url('/documents')); ?>">Документы</a></li>
                    
                </ul>

                <ul class="menu">
                    <li class="menu_item"><a href="/bids">Заявки</a></li>
                    <?php if(Voyager::can('browse_admin')): ?>
                        <li class="menu_item"><a href="<?php echo e(url('/admin')); ?>">Админ&#160;Панель</a></li>
                    <?php endif; ?>
                    <li class="menu_item sub"><span><i class="fa fa-user"></i></span>
                        
                        <div class="subMenu">
                            <div class="menu_item"><a href="/users/<?php echo e(Auth::id()); ?>">Мой&#160;профиль</a></div>
                            <div class="menu_item"><a href="/logout">Выйти</a></div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>