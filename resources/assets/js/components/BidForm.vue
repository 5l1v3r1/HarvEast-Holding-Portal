<template>
  <div class="quiz-builder container">  
	<div class="row">
	<div class="col-md-4 col-xs-12">
		<div class="col-md-12 statusblock1">
			<p>Выбрать категорию заявки:</p>
			<select name="category_id" class="col-md-12 field1">
				<option v-for="option in categories" :value="option.id" :key="option.name"> {{ option.name }} </option>	
			</select>	
		</div>
	  <div class="col-md-12 statusblock1">
			<p>Статус заявки:</p>
			<input id="published" type="checkbox" name="published" checked>
			<label for="published">Опубликовано</label> 	
		</div>
	</div>
    <div class="fieldsform col-md-8 col-xs-12" v-for="(question, index) in questions">
      <div class="input-group">
        <input type="text" class="form-control" name="name" v-model="question.text" placeholder="Название заявки" required>
        <span class="input-group-btn">
          <button class="btn btn-secondary add-field" type="button" @click="addOption(question)">Добавить поле</button>
        </span>
		    <span class="input-group-btn">
          <button class="btn btn-close" type="button" @click="removeOption(0)">Убрать поле</button>
        </span>
      </div>
      <br>
      <div class="input-group" v-for="(option, index) in question.options" style="margin-bottom: 20px">
        <bid-element :index="index"></bid-element>
      </div><br>
    </div> 

	</div>
  </div>
</template>

<script>
import BidElement from './BidElement.vue';

const createNewOption = () => { 
      return {
        text: '',
      }
    }

const createNewQuestion = () => {
  return {
    text: '',
    options: [createNewOption()]
  }
}

export default {
  components: {BidElement},
  name: 'BidForm',
  data () {
    return {
      questions: [createNewQuestion()],
      showQuestions: false,
      categories: {},
    }
  },
  methods: {
    addOption (question) {
      question.options.push(createNewOption())
    },
    removeOption (question) {
      question.options.pop();
	  }
  },
  created() {
  	axios.get('/admin/bid-categories')
        .then(response => this.categories = response.data);
  },
};
</script>

<style lang="css" scoped>
	.fieldsform {
	    background-color: #f9f9f9 !important;
		border: 1px solid #dcdcdc !important;
		padding: 1rem !important;
		border-radius: 5px !important;
	}
	.quiz-builder {
		display: flex;
		flex-wrap: wrap;
		flex-direction: column;
		justify-content: center;
		margin:3rem;
	}
	.field1 {
		border: 2px solid #e4eaec;
		border-radius: 5px;
		padding: 0.3rem 0.7rem;
	}
	.btn-close {
		margin-top: 1px;
    padding: 0.3rem;
    border: 1px solid dark-red;

    border-radius: 3px !important;
    background-color: red;
    color: #fff;
	}
	.btn-close:hover {
		background-color:#2196F3;
		color:#fff;
		transition: all 0.5s;
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
	.add-field:hover {
		background-color: #fff;
		color: #16b43b;
		transition:all 0.5s;
	}
	.category-type-text {
		margin-left: 1.5rem;
	}
	.crebidclass {
		padding:2rem;
	}
	.selectfieldofform {
		padding: 0.3rem 1rem 0.3rem 0.1rem;
		margin: 1rem 0;
		border: 3px solid #e4eaec;
		border-radius: 5px;
	}
	.textfield-zayavka {
		margin: 0.6rem 0 !important;
		border: 3px solid #afdab7 !important;
		width: 95% !important;
		border-radius: 3px !important;
	}
	.statusblock1 {
		border: 1px solid #e4eaec !important;
		margin-bottom: 2rem !important;
		border-radius: 5px !important;
		background-color: #fff !important;
		padding: 1rem !important;
	}
	@media screen and (max-width:767px) {
		.quiz-builder {
			margin:0;
		}
		.selectfieldofform {
			width: 100%;
		}
		.field1 {
			width:100%;
		}
	}
</style>