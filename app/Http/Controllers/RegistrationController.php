<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\Role;

class RegistrationController extends Controller
{
    public function register(Request $request) {

    	$user = Sentinel::registerAndActivate($request->all());
        $roleTable = Role::all();
        $admin = false;

        if(count($roleTable) == 0) {
            $roles = new Role;
            $roles->slug = 'admin';
            $roles->name = 'Admin';
            $roles->save();

            $admin = true;
        } elseif(count($roleTable) == 1) {
            $roles = new Role;
            $roles->slug = 'user';
            $roles->name = 'User';
            $roles->save();

            $admin = false;
        }

    	$userRole = Sentinel::findRoleBySlug('user');
        $adminRole = Sentinel::findRoleBySlug('admin');

    	if($admin == true) {
    		$adminRole->users()->attach($user);
    	} else {
            $userRole->users()->attach($user);
        }
    	
    	return redirect('/');
    }
}
