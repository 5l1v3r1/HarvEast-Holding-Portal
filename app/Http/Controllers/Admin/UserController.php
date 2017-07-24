<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Department;
use App\Http\Controllers\Controller;
use App\Phone;
use App\Position;
use App\Role;
use App\RoleDepartmentsEmail as RDE;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
    	 $this->validate(request(), [
	        'email' => 'required|unique:users|max:255',
            'name' => 'required',
	        'photo' => 'required',
	    	]);
    	User::add();
    	return redirect('/admin/users')
            ->with([
                'message'    => "Пользователь успешно добавлен",
                'alert-type' => 'success',
            ]);
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {    	
        $this->validate(request(), [
            'email' => 'required|max:255',
            'name' => 'required'
            ]);
    	$user->edit();

    	return redirect()
            ->route("voyager.users.edit", ['id' => $user->id])
            ->with([
                'message'    => "Пользователь успешно обновлен",
                'alert-type' => 'success',
            ]);
    }

    public function destroy(User $user)
    {
        $user->update(['is_active' => 0]);
        return redirect('/admin/users')
            ->with([
                'message'    => "Пользователь успешно удален",
                'alert-type' => 'success',
            ]);
    }

    public function heads()
    {
        $role = Role::where('name', 'head of department')->first();
        return view('admin.roles', [
            'url' => '/admin/heads',
            'role' => $role,
            'emails' => RDE::where('role_id', $role->id)->get(),
            'users' => User::all()
        ]);
    }

    public function hrManagers()
    {
        $role = Role::where('name', 'hr')->first();
        return view('admin.roles', [
            'url' => '/admin/hr_managers',
            'role' => $role,
            'emails' => RDE::where('role_id', $role->id)->get(),
            'users' => User::all()
        ]);
    }

    public function storeRoles()
    {
        User::storeRoles();
        RDE::storeRoleEmails();
        return back()
            ->with([
                'message'    => "Роли успешно обновлены",
                'alert-type' => 'success',
            ]);
    }

    public function dismissed()
    {
        Voyager::canOrFail('browse_dismissed');

        return view('admin.dismissed', [
            'dismissed_users' => User::where('is_active', 0)->get()
        ]);
    }

    public function undismiss(User $user)
    {
        Voyager::canOrFail('browse_dismissed');

        $user->update(['is_active' => 1]);
        return back()
            ->with([
                'message'    => "Пользователь успешно восстановлен",
                'alert-type' => 'success',
            ]);
    }

    public function import()
    {
        return view('admin.users.import');
    }

    public function importHandle(Request $request)
    {
        $directory = 'user_lists';
        \Storage::deleteDirectory($directory);

        $request->file('users')->storeAs($directory, 'users.csv');
        $zip_path = isset($request['photos']) ? $request->file('photos')->storeAs($directory, 'photos.zip') : false;

        if($zip_path)
        {
            extractZipTo($zip_path, $directory);
        }
        
        return redirect('/admin/import-users/step-2');
    }

    public function importStep2()
    {
        $users_path = storage_path('app').'/'.'user_lists/users.csv';
        $csv = parse_csv($users_path);
        $result = flip_csv_array($csv);
        $csv = kill_ufef($csv);
        foreach ($csv as $key => $value) {
            foreach($value as $k => $v)
            {
                $users[$key][$k] = ['value' => $v, 'checked' => 0];
            }
        }
        // dd(array_values(array_unique($result['department'])));
        if(request()->ajax())
        {
            return response()
            ->json([
                'cities' => array_values(array_unique($result['city'])),
                'positions' => array_values(array_unique($result['position'])),
                'departments' => array_values(array_unique($result['department'])),
                'users' => $users
                ]);
        }
        return view('admin.users.step-2');
    }
    public function importStep2Handle()
    {
        $users_path = storage_path('app').'/'.'user_lists/users.csv';
        $users = kill_ufef(parse_csv($users_path));
        $result = request()->result;
        $res = [];
        foreach($result as $key => $structure)
        {
            foreach($structure as $k => $item)
            {
                $name = key($item);
                $equivalent = $item[key($item)];
                if($name && (int)$equivalent === 0)
                {
                    switch ($key) {
                        case 'cities':
                            $city = City::where('name', $name)->first();
                            if(isset($city->id))
                            {
                                $res[$key][$name] = $city->id;
                            }
                            else
                            {
                                $city = City::create(['name' => $name]);
                                $res[$key][$name] = $city->id;                                
                            }
                            break;
                        case 'departments':
                            $department = Department::where('name', $name)->first();
                            if(isset($department->id))
                            {
                                $res[$key][$name] = $department->id;
                            }
                            else
                            {
                                $department = Department::create(['name' => $name]);
                                $res[$key][$name] = $department->id;                                
                            }
                            break;
                        case 'positions':
                            $position = Position::where('name', $name)->first();
                            if(isset($position->id))
                            {
                                $res[$key][$name] = $position->id;
                            }
                            else
                            {
                                $position = Position::create(['name' => $name]);
                                $res[$key][$name] = $position->id;                                
                            }
                            break;
                    }                   
                }
                else
                {
                    $res[$key][$name] = $equivalent;
                }
            }
        }
        foreach($users as $key => $user)
        {
            $users[$key]['city'] = (isset($user['city']) && $user['city']) ? $res['cities'][$user['city']] : 0;
            $users[$key]['department'] = (isset($user['department']) && $user['department']) ? $res['departments'][$user['department']] : 0;
            $users[$key]['position'] = (isset($user['position']) && $user['position']) ? $res['positions'][$user['position']] : 0;
            $existed_user = User::where('email', $user['email'])->first();
            $parts = explode("@", $user['email']);
            if(file_exists(storage_path('app').'/user_lists/'.$parts[0].'.jpg'))
            {
                $path = 'public/users/'.$parts[0].'/'.str_random(10).'.jpg';
                Storage::copy('user_lists/'.$parts[0].'.jpg', $path);
            }
            else
            {
                $path = false;
            }
            $name = isset($user['surname']) ? $user['surname'].' ' : '';
            $name .= isset($user['name']) ? $user['name'] : '';
            if(isset($existed_user->id))
            {
                $existed_user->update([
                    'name' => isset($name) ? $name : $existed_user->name,
                    'city_id' => isset($users[$key]['city']) ? $users[$key]['city'] : $existed_user->city_id,
                    'department_id' => isset($users[$key]['department']) ? $users[$key]['department'] : $existed_user->department_id,
                    'position_id' => isset($users[$key]['position']) ? $users[$key]['position'] : $existed_user->position_id,
                    'email' => isset($user['email']) ? $user['email'] : $existed_user->email,
                    'birthday' => isset($user['birthday']) ? Carbon::parse($user['birthday']) : $existed_user->birthday,
                    'photo' => $path ? '/storage/app/'.$path : $existed_user->photo
                    ]);
                if(!in_array($user['phone'] ,$existed_user->phones->pluck('phone')->toArray()) && isset($user['phone']))
                {
                    Phone::create(['phone' => $user['phone'], 'user_id' => $existed_user->id]);
                }    
            }
            else
            {                
                $password = str_random(10);
                $user['password'] = bcrypt($password);
                $created_user = User::create([
                    'name' => $name,
                    'city_id' => isset($users[$key]['city']) ? $users[$key]['city'] : $existed_user->city_id,
                    'department_id' => isset($users[$key]['department']) ? $users[$key]['department'] : $existed_user->department_id,
                    'position_id' => isset($users[$key]['position']) ? $users[$key]['position'] : $existed_user->position_id,
                    'email' => isset($user['email']) ? $user['email'] : $existed_user->email,
                    'birthday' => isset($user['birthday']) ? Carbon::parse($user['birthday']) : null,
                    'photo' => $path ? '/storage/app/'.$path : '/storage/app/public/users/default.png',
                    'password' => $user['password']
                    ]);  
                if(isset($user['phone']))
                {
                    Phone::create(['phone' => $user['phone'], 'user_id' => $created_user->id]);
                }     
            \Mail::to($created_user->email)->send(new UserRegister($created_user, $password));

            }
        }
        \Storage::deleteDirectory('user_lists');
    }
}