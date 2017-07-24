<template>
<div class="comments_wrap">
	<div class="comment_created comment_divider first_commentDivider">
		<div class="comment_avatar">
			<img class="stuffResult_img" src="assets/img/staff/1.png" alt="staff">
		</div>
		<div class="comment_content">
			<div class="comment_title">
				<div class="user_name"><a href="">Иваненко Анастасия</a></div>
				<div class="sectionInfo">7 апреля 20:25</div>
			</div>
			<div class="comment_descr">
				<p>Основные направления деятельности холдинга: растениеводство (выращивание пшеницы, подсолнечника, ячменя, многолетних трав, кукурузы) и молочное животноводство.</p>
			</div>
			<div class="comment_answer">Ответить</div>
		</div>
	</div>	
<!-- форма показа комментариев -->
	<div class="showComments">
		<span class="showComments_caption" href="">Показать еще 5 комментариев</span>
	</div>
<!-- форма показа комментариев -->
	<div class="comment_collapsed">
		<div class="comment_created comment_divider">
			<div class="comment_avatar">
				<img class="stuffResult_img" src="assets/img/staff/1.png" alt="staff">
			</div>
			<div class="comment_content">
				<div class="comment_title">
					<div class="user_name"><a href="">Иваненко Анастасия</a></div>
					<div class="sectionInfo">7 апреля 20:25</div>
				</div>
				<div class="comment_descr">
					<p>Основные направления деятельности холдинга: растениеводство (выращивание пшеницы, подсолнечника, ячменя, многолетних трав, кукурузы) и молочное животноводство.</p>
				</div>
				<div class="comment_answer">Ответить</div>
			</div>
		</div>	
		<div class="comment_creatingForm comment_divider">
			<div class="comment_avatar">
				<img class="stuffResult_img" src="assets/img/staff/1.png" alt="staff">
			</div>
			<div class="comment_content">
				<form class="comment_form" name="comment" method="post" action="">
						<textarea class="comment_bClick" name="comment" cols="75" rows="1" placeholder="Написать комментарий"></textarea>
						<p class="btn_addComment">
							<input type="submit" value="Отправить">
						</p>
				</form>
			</div>
		</div>
	</div>
</div>
</template>

<script>
export default {

  name: 'CommentBlock',

  data () {
    return {

    };
  }
};
</script>

<style lang="css" scoped>
</style>