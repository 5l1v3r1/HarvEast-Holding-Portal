@extends('layouts.app')

@section('content') 
        	<div id="u-search" class="content" id="goTopAnc">
			    <main class="news_column news_wrap">
			        <div class="megaSearchBox">
			          	<div class="searchStaff">
			              	<div class="searchStaff_form">
			                  	<form name="searchStaff"  @submit.prevent="searchSubmit">
				                  	<div class="searchField">
				                      	<input type="search" name="search" id="search" v-model="form.search" @blur="hideDrop" @keyup="dropSearch" @focus="showDrop" autocomplete="off">
				                      	<div class="search_icon"></div>
				                      	<button type="submit">Искать</button>
		                      	  	</div>
		                      		<div v-if="is_visible" class="searchStaff_tips">
			                     		<ul>
			                          		<li v-for="user in users">
			                            		<a :href="url+user.id" @mousedown.prevent="" class="searchStaff_items" v-text="user.name + ' '+ user.position.name + ' ' + user.city.name">
			                            		</a>
			                          		</li>
			                      		</ul>
			                  		</div>
			                    	<div v-if="!selects_visible" class="find_more find_more__open">
								        <div class="find_space" @click="toggleSelects">Расширенный поиск 
								        </div>
								    </div>
								    <div v-if="selects_visible" class="find_more find_more__close">
								        <div class="find_space" @click="toggleSelects">Свернуть фильтр
								        </div>	          
									    <div class="searchStaff_more select_row"> 
									        <div class="select_col">
									            <div class="select_item">
									                <div class="form_item">                   
									                    <div class="arrow_change">
									                      	<select id="cusel_position" v-model="form.position" name="position">
									                      	<option value="" disabled>Должность
									                      	</option>
									                      	@foreach(App\Position::all() as $position)
									                      	<option value="{{$position->id}}">{{$position->name}}
									                      	</option>
									                      	@endforeach
									                      	</select>
									                    </div>
									                </div>
									            </div>
									            <div class="select_item">
									                <div class="form_item"> 
									                    <div class="arrow_change">
										                    <select id="cusel_departament" v-model="form.department" name="department">
										                    	<option value="" disabled>Департамент
										                    	</option>
										                    	@foreach(App\Department::all() as $department)
										                    	<option value="{{$department->id}}">{{$department->name}}
										                    	</option>
										                      	@endforeach
										                    </select>
									                    </div>
									                </div>
									            </div>
									        </div>
									        <div class="select_col">
									            <div class="select_item">
									               	<div class="form_item"> 
									                    <div class="arrow_change">
											                <select id="cusel_city" v-model="form.city" name="city">
											                    <option value="" disabled>Выберите город
											                    </option>
											                      	@foreach(App\City::all() as $city)
											                    <option value="{{$city->id}}">{{$city->name}}
											                    </option>
											                      	@endforeach
											                </select>
									                  	</div>
									                </div>
									            </div>
										        <div class="reset_item">
										           	<div @click="clearSelects" class="find_more find_more__clear">
										                Сбросить фильтры  
										            </div>
										        </div>
									        </div>
										</div>
								    </div> <!-- searchStaff_more -->
		                  		</form>			                  
		              		</div>
		          		</div>
			        </div>  
			        <!-- searchBox -->
			        <div v-for="user in ausers">
			          <user-block :user="user"></user-block>
			        </div>
			        
			    </main>
			    <div class="goTopBtn">
					<a href="#goTopAnc">Наверх</a>
					<img class="goTopBtn_arrow" src="/public/elements-img/orders-svg/arrow-up.svg" alt="arrow">
				</div>
			</div>          
@endsection