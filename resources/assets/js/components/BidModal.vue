<template>
<div>
  <a class="order_names" href="" v-on:click.prevent="toggle">
       <slot></slot> 
  </a>
  <div class="orderForm_wrap"  id="myModal" role="dialog" v-if="showModal" v-on:close="toggle">
    <section class="orderForm">
      <div @click="toggle" class="close_icon"></div>
      <article class="orderForm_content">
        <header class="orderForm_header">
          <h2>{{name}}</h2>
        </header>
        <form :action="'/bids/'+id" method="post" enctype="multipart/form-data">
        
            <input type="hidden" name="_token" id="csrf-token" :value="csrf" />
              <div class="form_item" v-for="(field, index) in fields">

                <p class="form_item" v-if="field.field == 'text'">
                  <span class="form_caption">{{field.label}}</span>
                  <input class="name" :name="index" type="text" size="40">
                </p>

                <div  v-if="field.field == 'texts'">
                  <div v-if="field.box_type == 'checkbox'">
                    <span class="form_caption">{{field.label}}</span>
                    <p class="form_checkbox"  v-for="(text, id) in field.texts">   
                      <input class="checkbox_item" :id="index +'check' + id" :type="field.box_type" :name="index" :value="text.text">
                      <label class="order_checkbox" :for="index +'check' + id">{{text.text}}</label>
                    </p>
                  </div>

                  <div v-if="field.box_type == 'radio'">
                    <span class="form_caption">{{field.label}}</span>
                    <div class="form_radio form_item radio_buttons" v-for="(text, id) in field.texts">
                      <input type="radio" :id="index +'check' + id" :name="index" :value="text.text">
                      <label :for="index +'check' + id">{{text.text}}</label>
                      <div class="check"></div>
                    </div>
                  </div>                 
                </div>

                <div v-if="field.field == 'files'">

                  <div v-if="field.box_type == 'checkbox'">
                    <span class="form_caption">{{field.label}}</span>                  
                    <p class="form_checkbox"  v-for="(file, id) in field.files">   
                      <input class="checkbox_item" :id="index +'check' + id" :type="field.box_type" :name="index+'[]'" :value="id">
                      <label class="order_checkbox" :for="index +'check' + id">
                        <img :src="file.src" style="width: 300px"/>
                      </label>
                    </p>
                  </div>

                  <div v-if="field.box_type == 'radio'">
                    <span class="form_caption">{{field.label}}</span>
                    <div class="form_radio form_item radio_buttons" v-for="(file, id) in field.files">
                      <input type="radio" :id="index +'rad' + id" :name="index+'[]'" :value="id">
                       <label :for="index +'rad' + id">
                        <img :src="file.src" style="width: 300px"/>
                       </label>                        
                      <div class="check"></div>
                    </div>
                  </div>

                </div>

                <div v-if="field.field == 'dropdown'">
                  <span class="form_caption">{{field.label}}</span>
                  <div class="arrow_change">
                    <select>
                      <option v-for="(text, index) in field.texts" :value="index">{{text.text}}</option>
                    </select>
                  </div>
                </div>

                <div v-if="field.field == 'textarea'">
                  <span class="form_caption" :for="index">{{field.label}}</span>                  
                  <textarea :name="index" cols="40" rows="10"></textarea>
                </div>

                <div v-if="field.field == 'number'">
                  <label class="form_caption" :for="index">{{field.label}}</label>
                  <input class="arrow_change number_select" type="number" :name="index" :min="field.min" :max="field.max" :value="field.min" :step="field.step">
                </div>

                <div v-if="field.field == 'upload'">
                  <label class="form_caption" :for="index">{{field.label}}</label>
                  <input type="file" :name="index+'[]'" multiple>
                </div>                
            </div>
            <div class="footer_btn">
              <input type="submit" value="Отправить">
            </div>
        </form>
      </article>
    </section>
  </div>
</div>
</template>

<script>
export default {
  props: ['id','csrf', 'name'],
  name: 'BidModal',

  data () {
    return {
      fields: {},
      showModal: false 
    };
  },
  methods: {
    toggle() {
      this.showModal = !this.showModal;
    }
  },
  created(){
    axios.get('/bids/'+this.id)
          .then(response => this.fields = response.data);
  },
  ready(){
    $(function() {
      $('input[type="number"], select').styler();
    }); 
  }
};
</script>

<style lang="css" scoped>
</style>