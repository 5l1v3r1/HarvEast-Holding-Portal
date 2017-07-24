<template>
<div>
	<select class="selectfieldofform" name="select[]" v-model="selected">
    	<option v-for="option in fields" :value="option.name" :key="option.name"> {{ option.text }} </option>	
	</select>

	<div class="cc">
	<component v-bind:is="component()" name="comp[]" :index="index"></component>
	</div>
</div>
</template>

<script>
export default {
  name: "BidElement",
  props: ['index'],

  data () {
    return {
      fields: [
	      { name: 'text', text: 'строка', component: 'description' },
        { name: 'textarea', text: 'текст', component: 'description' },
        { name: 'number', text: 'количество', component: 'number' }, 
        { name: 'upload', text: 'загрузка файлов', component: 'description' },
        { name: 'files', text: 'выбор файлов', component: 'files' },
        { name: 'texts', text: 'выбор текста', component: 'texts' },
        { name: 'dropdown', text: 'выпадающий список', component: 'dropdown' },
      ],
	    selected: 'text',
      id: -1
    }
  },
  methods: {
    component(){
      return this.fields.find(i => i.name === this.selected).component;
    }
  },
  components: {
    description: { props: ['index'],
    template:`
      <div class="starter-block">
		    <input class="textfield-inp" type="text" :name="'label-'+index" placeholder="Название поля" required>
        <input id="checkbox-box1" type="checkbox" value="required" :name="'required-'+index" hidden>
        <label for="checkbox-box1">Обязательное поле</label>
      </div>
    `},
    files: { props: ['index'],
    template:`
    <div>
    	<input class="textfield-inp" type="text" :name="'label-'+index" placeholder="Название поля" required>
      <select :name="'box_type-'+index" class="filesoption">
        <option value="radio">одиночный выбор</option>
        <option value="checkbox">множественный выбор</option>
      </select>
		<div class="box">
			<input type="file" :name="'files-'+index+'[]'" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple accept="image/*"/>
		</div>
    ` },
    texts: {props: ['index'],
    template:`
    <div>
      <input class="textfield-inp" type="text" :name="'label-'+index" placeholder="Название поля" required>
      <select :name="'box_type-'+index" class="filesoption">
        <option value="radio">одиночный выбор</option>
        <option value="checkbox">множественный выбор</option>
      </select>
      <input class="textfield-inp" type="text" :name="'texts-'+index" placeholder="Перечислите варианты через &quot;;&quot;">
    </div>
    ` },
    number: { props: ['index'],
     template:`
    <div>
    	<input class="textfield-inp" type="text" placeholder="Название поля" :name="'label-'+index" required>
    	<input class="textfield-inp" type="text" placeholder="Минимальное число" :name="'min-'+index">
    	<input class="textfield-inp" type="text" placeholder="Максимальное число" :name="'max-'+index">
    	<input class="textfield-inp" type="text" placeholder="Шаг" :name="'step-'+index">
        <input id="checkbox-box4" type="checkbox" value="required" :name="'required-'+index" hidden />
        <label for="checkbox-box4">Обязательное поле</label>
    </div>
    `},
    dropdown: {props: ['index'],
     template:`
      <div>
        <input class="textfield-inp" type="text" :name="'label-'+index" placeholder="Название поля" required>
        <input class="textfield-inp" type="text" :name="'texts-'+index" placeholder="Перечислите варианты через &quot;;&quot;">
        <input id="checkbox-box5" type="checkbox" value="required" :name="'required-'+index" hidden />
        <label for="checkbox-box5">Обязательное поле</label>
      </div>
    `},
  }, 
  created: function() {
    	this.selected = this.fields.find(i => i.name === this.selected).name;
      this.id = this._uid;
  }
};
(function ( document, window, index ) {
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		// Firefox bug fix
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
	});
}( document, window, 0 ));
</script>

<style lang="css">
	.box {
		background-color: transparent;
		padding: 0;
	}
/*	.inputfile {
		width: 0.1px;
		height: 0.1px;
		opacity: 0;
		overflow: hidden;
		position: absolute;
		z-index: -1;
	}*/
	.inputfile-1 + label {
		color: #ffffff;
		background-color: #16b43b;
	}
	.inputfile + label svg {
		width: 1em;
		height: 1em;
		vertical-align: middle;
		fill: currentColor;
		margin-top: -0.25em;
		margin-right: 0.25em;
	}
	.inputfile + label {
		max-width: 80%;
		text-overflow: ellipsis;
		white-space: nowrap;
		font-weight:300;
		cursor: pointer;
		display: inline-block;
		overflow: hidden;
		padding: 0.625rem 1.25rem;
	}
	input[type="checkbox"] {
		display:none;            
	}
	input[type="checkbox"] + label {
		color: #444;
	    cursor: pointer;
	}
	input[type="checkbox"] + label::before{
		content: "";
		display: inline-block;
		height: 18px;
		width: 18px;
		margin: 0 5px 0 0;
		background-repeat: no-repeat;
	}
	input[type="checkbox"] + label::before {
		content: " ";
		background-color: #fff;
		border: 1px solid #ccc;
		border-radius: 3px;  
		margin: 0 5px 0 0;		
	}
	input[type="checkbox"]:checked + label::before {
		content:" ";
		background-image: url("https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/checkmark-24-20.png");
		background-size:100%;
		background-position:center;
		background-repeat:no-repeat;
		background-color: #fff;
		border: 1px solid #ccc;
		border-radius: 3px; 
		margin: 0 5px 0 0;
		overflow: hidden;
	}
	.filesoption {
		margin: 0.6rem 0 !important;
		border: 2px solid #d2e4ea !important;
		padding: 2px;
		border-radius: 3px;
	}
	.selectfieldofform {
		padding: 0.3rem 1rem 0.3rem 0.1rem;
		margin: 1rem 0;
		border: 3px solid rgba(185, 226, 192, 0.66);
		border-radius: 5px;
	}
	.textfield-inp {
		padding: 0 5px;
		margin: 0.6rem 0 !important;
		border:2px solid #d2e4ea !important;
		width: 50% !important;
		border-radius: 3px !important;
	}
	input{
		margin: 0;
		border: 2px solid #f9f9f9;
		border-radius: 3px !important;
	}
	.input-group {
		border-bottom: 2px solid #fff;
	}
	@media screen and (max-width:767px) {
		.textfield-inp {
			margin: 5px 0;
			border: 2px solid #afdab7 !important;
			width: 100% !important;
			border-radius: 3px !important;
		}
	}
</style>