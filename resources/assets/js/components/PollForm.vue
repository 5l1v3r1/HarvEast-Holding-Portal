<template>
  <div class="quiz-builder">    
    <div>
      <div class="group">
        <input type="text" class="form-control noBorRadLeft input_BButton" name="name" v-model="question.text" placeholder="Название опроса">
        <span class="BButtom">
          <button class="btn btn-secondary btn_custom add-field" type="button" @click="addOption()">Добавить вариант</button>
        </span>
      </div>
      </br>
      <div class="group" v-for="(option, index) in question.options" style="margin-bottom: 20px">
        <input type="text" class="form-control noBorRadLeft input_SButtom" name="options[]" v-model="option.text" placeholder="Введите вариант ответа">
        <span class="SButtom">
          <button class="btn btn-danger btn_custom" type="button" @click="removeOption(option)">X</button>
        </span>
      </div></br>
    </div>
  </div>
</template>

<script>
const createNewOption = () => { 
      return {
        text: '',
      }
    }
export default {

  name: 'PollForm',

  data () {
    return {
      question:  { text: '', options: [createNewOption()] },
      showQuestions: false,
    }
  },
  methods: {
    addOption () {
      this.question.options.push(createNewOption())
    },
    removeOption (option) {
      var index = this.question.options.indexOf(option);
      if (index > -1) {
          this.question.options.splice(index, 1);
      }
    }
  },
  mounted(){
    let els = window.location.pathname.split('/');
    if(els.pop() === 'edit')
    {
      axios.get('/api/polls/'+els.pop())
           .then(response => {;
            this.question.text = response.data.text;
            this.question.options = response.data.options;
          });
    }
  }
};
</script>

<style lang="css" scoped>
.btn_custom {
  margin: 0;
}
.input_BButton {
  padding: 0px 160px 0px 12px;
}
.input_SButtom {
  padding: 0px 50px 0px 12px;
}
.group {
    position: relative;
    width: 100%;
    overflow: hidden;
    border-radius: 3px;
}
.BButtom {
    position: absolute;
    top: 0;
    right: 0px;
}
.SButtom {
    position: absolute;
    top: 0;
    right: 0px;
}
.noBorRadLeft {
    border-radius: 3px 0px 0px 3px !important;
}
.add-field {
  margin-top: 1px;
  margin-left: 10px !important;
  padding: 0.3rem;
  border: 1px solid #25b43e;
  border-radius: 3px !important;
  background-color: #16b43b;
  color: #fff;
}
</style>




