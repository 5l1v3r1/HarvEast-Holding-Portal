<?php $__env->startSection('content'); ?>
<style>
    .active{
        color: #126429;
        font-weight: bold;
    }
</style>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="import-users" class="panel panel-bordered">
                    <div v-if="cities.length" class="panel-body">
                        <div>Выберите город соответствующий городу <span style="font-weight: bold">{{cities[0]}}</span>:</div>
                        <div class="form-group">
                            <div class="col-md-10">
                                <select name="city" id="city" v-model="selected_city" class="form-control" style="margin: 5px 0" required="required">
                                    <option value="0">Нет в списке</option>                                
                                    <?php $__currentLoopData = App\City::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">    
                                <button @click="associateCity" type="button"  class="form-control btn btn-info">Отправить (ещё {{cities.length }})</button>
                            </div>
                        </div>
                    </div>
                    <div v-if="departments.length" class="panel-body">                  
                        <div>Выберите департамент соответствующий департаменту: <span style="font-weight: bold">{{departments[0]}}</span>:</div>
                        <div class="form-group">
                            <div class="col-md-10">
                                <select id="department" v-model="selected_department" name="department" class="form-control" style="margin: 5px 0" required="required">
                                    <option value="0">Нет в списке</option>                                
                                    <?php $__currentLoopData = App\Department::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">    
                                <button @click="associateDepartment" type="button"  class="form-control btn btn-info">Отправить (ещё {{departments.length }})</button>
                            </div>
                        </div>                        
                    </div>
                    <div v-if="positions.length" class="panel-body"> 
                        <div>Выберите должность соответствующий должности <span style="font-weight: bold">{{positions[0]}}</span>:</div>
                        <div class="form-group">
                            <div class="col-md-10">
                                <select id="position" v-model="selected_position" name="position" class="form-control" style="margin: 5px 0" required="required">
                                    <option value="0">Нет в списке</option>                                
                                    <?php $__currentLoopData = App\Position::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($position->id); ?>"><?php echo e($position->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">    
                                <button @click="associatePosition" type="button"  class="form-control btn btn-info">Отправить (ещё {{positions.length }})</button>
                            </div>
                        </div>    
                    </div> 
                    <div v-if="!positions.length && !cities.length && !departments.length && !finished" class="panel-body">
                        <button @click="sendResult">Сохранить пользователей</button>
                    </div> 
                    <div v-if="finished">
                        Сотрудники сохранены, <a href="/admin/users"> вернутся к сотрудникам.</a>
                    </div>
                     <table class="table table-hover">
                        <thead>
                            <tr>                          
                                <th>Фамилия</th>
                                <th>Имя</th>                            
                                <th>E-mail</th>
                                <th>Департамент</th>
                                <th>Город</th>
                                <th>Должность</th>
                                <th>День Рождения</th>
                                <th>Телефон</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users">                                       
                                <td><span v-if="isset(user.surname)">{{user.surname.value}}</span></td>
                                <td><span v-if="isset(user.name)">{{user.name.value}}</span></td>                         
                                <td><span v-if="isset(user.email)">{{user.email.value}}</span></td>                          
                                <td :class="{active: user.department.checked}"><span v-if="isset(user.department)">{{user.department.value}}</span></td>                          
                                <td :class="{active: user.city.checked}"><span v-if="isset(user.city)">{{user.city.value}}</span></td>                          
                                <td :class="{active: user.position.checked}"><span v-if="isset(user.position)">{{user.position.value}}</span></td>                          
                                <td><span v-if="isset(user.birthday)">{{user.birthday.value}}</span></td>                          
                                <td><span v-if="isset(user.phone)">{{user.phone.value}}</span></td>                          
                            </tr>
                        </tbody>
                    </table>                 
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
    new Vue({
        el: '#import-users',
        data() {
            return {
                cities: {},
                selected_city: '',
                departments: {},
                selected_department: '',
                positions: {},
                selected_position: '',
                result: {
                    cities: [],
                    positions: [],
                    departments: []
                },
                users: {},
                finished: false
            };
        },
        methods: {
            associateCity(){
                this.result.cities.push({[this.cities[0]]: this.selected_city});
                
                let city_name = $("#city").find(':selected').text();
                for(var user in this.users)
                {
                    if(this.users[user].city.value  === this.selected_city)
                    {
                        this.users[user].city.value = city_name;
                        this.users[user].city.checked = 1;
                    }
                    else if(this.users[user].city.value === this.cities[0])
                    {             
                        this.users[user].city.value = city_name;           
                        this.users[user].city.checked = 1;
                    }

                }
                this.cities.splice(0,1);
            },
            associateDepartment(){
                this.result.departments.push({[this.departments[0]]: this.selected_department});
                let department_name = $("#department").find(':selected').text();
                for(var user in this.users)
                {
                    if(this.users[user].department.value === this.selected_department)
                    {
                        this.users[user].department.value = department_name;
                        this.users[user].department.checked = 1;
                    }
                    else if(this.users[user].department.value === this.departments[0])
                    {                        
                        this.users[user].department.value = department_name;                        
                        this.users[user].department.checked = 1;
                    }

                }
                this.departments.splice(0,1);

            },
            associatePosition(){
                this.result.positions.push({[this.positions[0]]:this.selected_position});
                let position_name = $("#position").find(':selected').text();
                for(var user in this.users)
                {
                    if(this.users[user].position.value === this.selected_position)
                    {
                        this.users[user].position.value = position_name;                        
                        this.users[user].position.checked = 1;
                    }
                    else if(this.users[user].position.value === this.positions[0])
                    {                        
                        this.users[user].position.value = position_name;                        
                        this.users[user].position.checked = 1;
                    }

                }
                this.positions.splice(0,1) ;
            },
            sendResult()
            {
                axios.post(window.location, {'_token': '<?php echo e(csrf_token()); ?>', 'result': this.result});
                this.finished = true;
            },
            isset(item)
            {
                return typeof item !== 'undefined';
            }
        },
        created(){
            axios.get(window.location)
                 .then(response => {
                    this.cities = response.data.cities;
                    this.departments = response.data.departments;
                    this.positions = response.data.positions;
                    this.users = response.data.users;
                 });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>