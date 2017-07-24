<template>
<main class="news_column homeWrap">
  <div class="news_wrap">
    <div class="searchBox">
      <div class="news_header">
          <h1 v-if="!tags_visible">Новости компании</h1>
          <div v-if="tags_visible" class="returnBox">
              <a class="returnNews_button" href="/articles">
                <i class="fa fa-angle-double-left fa_button"/>
                Вернутся к новостям
              </a>
          </div>
      </div>
      <div class="search">
          <!-- search_form -->
          <div v-if="!is_visible" @click="is_visible = !is_visible" class="search_iconMain"></div>
          <div v-if="is_visible" class="search_form">
              <form name="search" @submit.prevent="searchSubmit">
                  <input type="search" name="search" id="search" v-model="form.search" @keyup="dropSearch" @blur="novis" autocomplete="off" @focus="list_visible = true" placeholder="Поиск по сайту" v-focus.lazy="true">
                  <div class="search_icon"></div>
              </form>
              <div v-if="form.search" class="tips_block">
                  <a @click.prevent="searchSubmit" class="tips_header">Показать все результаты</a>
                  <ul>
                      <li v-for="article in articles"><a :href="'/articles/'+article.slug" class="tips_items">{{ article.name }}</a></li>
                  </ul>
              </div>
          </div>
      </div>
          <!-- search_form -->
    </div>
    <div v-for="(article, index) in aarticles">
      <article-block :article="article"></article-block>
    </div>
   <infinite-loading :on-infinite="onInfinite" ref="infiniteLoading">
    <span slot="no-more"></span>
    <span slot="no-results"></span>
  </infinite-loading>
  </div>
</main>
</template>

<script>
import ArticleBlock from './ArticleBlock.vue';
import InfiniteLoading from 'vue-infinite-loading';
import { focus } from 'vue-focus';

export default {
  components: { ArticleBlock, InfiniteLoading},
  directives: { focus: focus },

  name: 'search-article',

  data(){
    return {
        form: new Form({ search: '' }),
        articles: {},
        aarticles: {},
        hasPermission: false,
        checked: false,
        is_visible: false,
        list_visible: false,
        tags_visible: false,
        page: 1
    };
  },

  methods: {
    dropSearch () {      
    this.form.get('/articles/search-bar?search='+this.form.search + '&'+ window.location.search.slice(1))
        .then(response => this.articles = response);
    },
    searchSubmit(){
      this.form.get('/articles/search-submit?search=' + this.form.search + '&'+ window.location.search.slice(1))
          .then(response => {
            this.aarticles = response;
            this.list_visible = false;
            this.is_visible = false;
          });
    },
    showDrop(){
      this.is_visible = true;
    },
    hideDrop(){
      this.is_visible = false;
    },
    novis(){
      if(!this.form.search)
      {        
        this.is_visible = false;
      }
    },
    onInfinite() {
      axios.get('/articles/search-submit?' + window.location.search.slice(1), {
        params: {
          page: ++this.page,
          search: this.form.search
        },
      }).then((res) => {
        if (res.data) {
          this.aarticles = this.aarticles.concat(res.data);
          this.$refs.infiniteLoading.$emit('$InfiniteLoading:loaded');
        } else {
          this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
        }
      });
    },
  },
  created(){
    if(window.location.search.indexOf('tag=') > 0)
    {
      console.log(window.location.search.indexOf('tag='));
      this.tags_visible = true;
    }
  	this.form.get('/articles/search-submit' + window.location.search)
          .then(response => this.aarticles = response);
  }
};
</script>

<style lang="css" scoped>
.search-list{
  position: absolute;
  z-index: 15;
  width: 686px;
}
</style>