<template>
	<div>
		<div class="panel panel-default whity block">
			<div class="panel-body block-body">
				{{ article.created_at }}
				<div style="font-weight: bold;">{{article.name}}</div>
				<div>
				{{ article.body | truncate}}
				</div>
				<a :href="url+article.slug">Читать дальше</a>
				<div>
					<img class="art_photo" :src="article.media"/>
				</div>		
				<span v-for="tag in article.tags" class="tag"><a :href="url+'?tag='+tag.name">{{tag.name}}</a></span>
			</div>
		</div>
	</div>
</template>

<script>
export default {

  name: 'main-article-block',

  data () {
    return {
    	article: {},
    };
  },

  methods: {
    exists () {
      return this.article.length > 0 ? true : false;
    }
  },

  created() {
  	axios.get('/articles/anchored')
        .then(response => this.article = response.data);
  },

    filters: {
	  	truncate: function(value)
	  	{
			if(value.length < 1000)
			{
				return value;
			}
	  		return value.substring(0, 997) + '...';
		}
	}
};
</script>

<style lang="css" scoped>
</style>