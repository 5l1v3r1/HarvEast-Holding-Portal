<template>
<div style="margin-bottom:30px">
	<div v-bind:class="{selected_wrap: article.is_highlighted}">
        <div class="selected_header" v-if="article.is_highlighted">
            <div class="star_icon"></div>
        </div>
        <section class="whiteBox">
            <article>
                <span class="sectionInfo">{{ postedOn(article) }}</span>
                <div class="mainNews_title">
                    <h1>{{article.name}}</h1>
                </div>
                <div class="mainNews_content" v-html="article.body">
                   {{ article.body | truncate}}
                </div>
                <div class="readMore">
                    <a class="readMore_button" :href="'/articles/'+article.slug">Читать дальше</a>
                </div>
                <div class="mainNews_photo" v-html="article.media"></div>
                <div class="news_tags">
                    <a v-for="tag in article.tags" :href="'/articles/?tag='+tag.name" class="tags_item" >{{tag.name}}</a>
                </div>
            </article>
        </section>
	</div>
</div>
</template>

<script>
import moment from 'moment';
export default {

  name: 'article-block',
  props: {
  	article: {}
  },

  data () {
    return {	
    	img: false,
    	video: false,
    };
  },

  methods: {
  	postedOn(article)
  	{
  		moment.locale('ru');
  		return moment(article.created_at).calendar();
  	}
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
.highlight
{
	background: black;
}
</style>