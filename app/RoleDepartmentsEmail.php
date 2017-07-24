<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleDepartmentsEmail extends Model
{
    protected $fillable = ['email', 'department_id', 'city_id', 'role_id'];

    public static function storeRoleEmails()
    {
        foreach (request()->email as $city => $department_emails) 
        {
        	foreach ($department_emails as $department => $email) 
        	{
        		if(!is_null($email))
        		{
	        		$previous = self::where('city_id', $city)->where('department_id', $department)->where('role_id', request()->role)->first();
	        		if(isset($previous))
	        		{
	        			$previous->update(['email' => request()->email[$city][$department]]);
	        		}
	        		else
	        		{
	        			self::create([
	        				'email' => $email,
	        				'department_id' => $department,
	        				'role_id' => request()->role,
	        				'city_id' => $city
	        				]);
	        		}
        		}
        		
        	}
        }            
    }

    public static function exists($city_id, $department_id, $role_id)
    {
    	$email = self::where('city_id', $city_id)
    		->where('department_id', $department_id)
    		->where('role_id', $role_id)
    		->first();
    	return isset($email) ? $email->email : false;
    }
}
