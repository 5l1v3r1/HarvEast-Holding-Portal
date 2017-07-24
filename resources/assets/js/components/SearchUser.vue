<template>
<div class="content">
    <main class="news_column news_wrap">
        <div class="searchBox">
          <div class="searchStaff">
              <div class="searchStaff_form">
                  <form name="searchStaff"  @submit.prevent="searchSubmit">
                      <input type="search" name="search" id="search" v-model="form.search" @keyup="dropSearch" @focus="showDrop" autocomplete="off">
                      <div class="search_icon"></div>
                      <button type="submit">Искать</button>
                  </form>
                  <div v-if="is_visible" class="searchStaff_tips">
                      <ul>
                          <li v-for="user in users">
                            <a :href="url+user.id" class="searchStaff_items">
                              {{ user.name }}<span> ({{ user.position.name }}, {{ user.department.name }}, {{ user.city.name }})</span>
                            </a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="find_more find_more__open">
            Расширенный поиск 
          </div>
          <div class="find_more find_more__close">
            Свернуть фильтр 
          </div>
          <div class="searchStaff_more select_row"> 
            <div class="select_col">
              <div class="select_item">
                <div class="form_item">                   
                    <div class="arrow_change">
                      <select id="cusel_position">
                      <option value="Должность">Должность</option>
                      <option v-for:"position in positions" :value="position.id" v-text="position.name"></option>
                      </select>
                    </div>
                </div>
              </div>
              <div class="select_item">
                <div class="form_item"> 
                    <div class="arrow_change">
                    <select id="cusel_departament">
                      <option value="Департамент">Департамент</option>
                      <option v-for:"department in departments" :value="department.id" v-text="department.name"></option>
                      </select>
                    </div>
                </div>
              </div>
            </div>
          
            <div class="select_col">
              <div class="select_item ">
                <div class="form_item"> 
                    <div class="arrow_change">
                    <select id="cusel_city">
                      <option value="Выберите город">Выберите город</option>
                      <option v-for:"city in cities" :value="city.id" v-text="city.name"></option>
                      </select>
                    </div>
                </div>
              </div>
              <div class="reset_item">
                <div class="find_more find_more__clear">
                  Сбросить фильтры  
                </div>
              </div>
            </div>

          </div> <!-- searchStaff_more -->
        </div>
        <!-- searchBox -->
        <div v-for="user in ausers">
          <user-block :user="user"></user-block>
        </div>
    </main>
</div>
</template>

<script>
import UserBlock from './UserBlock.vue';

export default {
  components: { UserBlock },
  name: 'search-user',
  data() {
    return {
        url: '/users/',
        form: new Form({ search: '' }),
        ausers: {},
        users: {},
        is_visible: false,
        departments : [],
        cities : [],
        positions : [],
    };
  },

  methods: {
    dropSearch () {      
    this.form.get('/users/search-bar?search='+this.form.search)
        .then(response => this.users = response);
    },

    searchSubmit(){
      this.form.get('/users/search-submit?search='+this.form.search)
          .then(response => this.ausers = response);
    },
    showDrop(){
      this.is_visible = true;
    },
    hideDrop(){
      this.is_visible = false;
    }
  },
};
</script>

<style lang="css">
</style>