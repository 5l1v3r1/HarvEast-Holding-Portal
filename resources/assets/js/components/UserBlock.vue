<template>
<div class="stuffResult_round">
	<div class="whiteBox stuffResult_wrap space_down">
		<div class="stuffResult_avatar">
	    	<img class="stuffResult_img" :src="user.photo" alt="staff">
	    </div>
	    <div class="userSidebar_col stuffResult_descr">
	        <div class="stuffResult_title">
	            <a :href="'/users/'+user.id">{{user.name}}</a>
	        </div>
	        <div class="stuffResult_content">
	            <span class="stuffResult_post" v-if="user.position">{{ user.position.name }}</span>
	            <span class="stuffResult_departament" v-if="user.department">{{ user.department.name }}</span>
	            <div class="stuffResult_contacts contacts_wrap">
	                <div class="stuffResult_descr">
	                    <span>Контакты:</span>
	                    <p v-if="user.city.name">{{ user.city.name }}</p>
	                    <p v-if="user.email"><a :href="user.email">{{ user.email }}</a></p>
	                    <p v-for="phone in user.phones" v-if="phone.phone">{{ phone.phone }}</p>
	                </div>
	                <div class="contacts_descr" v-if="isValid(user.birthday)">
	                    <span>Дополнительно:</span>
	                    <p>День рождения {{ birthday(user) }}</p>
	                </div>
	            </div>
	        </div>	
	    </div>	
	</div>	
</div>	
</template>

<script>
export default {

  name: 'user-block',
  props: ['user'],

  data () {
    return {
    	
    };  
  },
  methods: {
  	birthday(user)
  	{
  		moment.locale('ru');
  		return moment(user.birthday).format('Do MMMM');
  	}, 
  	isValid(birthday)
  	{
  		return moment(birthday).isValid();
  	}
  },
};
</script>

<style lang="css" scoped>

</style>