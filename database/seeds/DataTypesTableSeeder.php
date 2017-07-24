<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;

class DataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $dataType = $this->dataType('slug', 'users');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'users',
                'display_name_singular' => 'User',
                'display_name_plural'   => 'Users',
                'icon'                  => 'voyager-person',
                'model_name'            => 'TCG\\Voyager\\Models\\User',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'menus');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural'   => 'Menus',
                'icon'                  => 'voyager-list',
                'model_name'            => 'TCG\\Voyager\\Models\\Menu',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'roles');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural'   => 'Roles',
                'icon'                  => 'voyager-lock',
                'model_name'            => 'TCG\\Voyager\\Models\\Role',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }


$this->add('articles','articles','Article','Articles','voyager-helm','App\\Article','','',1);
$this->add('cities','cities','City','Cities','','App\\City','','',1);
$this->add('departments','departments','Department','Departments','','App\\Department','','',1);
$this->add('users','users','User','Users','','App\\User','','',1);
$this->add('infos','infos','Info','Infos','','App\\Info','','',1);
$this->add('document_categories','document-categories','Document Category','Document Categories','','App\\DocumentCategory','','',1);
$this->add('documents','documents','Document','Documents','','App\\Document','','',1);
$this->add('positions','positions','Position','Positions','','App\\Position','','',1);
$this->add('polls','polls','Опрос','Опросы','','App\\Poll','','',1);
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }

    public function add($type, $name, $display_name_singular, $display_name_plural, $icon, $model_name, $controller, $description, 
        $generate_permissions)
    {
        $dataType = $this->dataType('slug', $type);
        if (!$dataType->exists) {
            $dataType->fill(
                compact('name', 'display_name_singular' ,'display_name_plural' , 'icon', 'model_name', 'controller', 
                        'generate_permissions', 'description')
            )->save();
        }
    }
}
