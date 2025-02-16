<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = Admin::get();

        return view('dashboard.admins.index' , compact('admins'));
    }


    public function create()
    {
        $roles=Role::all();
        return view('dashboard.admins.create' , compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'password'  => 'required|min:8',
            'image'     => 'nullable|mimes:jpg,png,jpeg',
            'role_id'   => 'required|exists:roles,id'
        ]);
        $userData = $request->except(['role_id']);

        $userData['password'] = bcrypt($userData['password']);

        if ($request->has('image'))
            $userData['image'] = image_uploader_with_resize($userData['image'],200,200);

        $admin=Admin::create($userData);
        $admin->assignRole($request->input('role_id'));


        return to_route('dashboard.admins.index')->with(['success'=>'تم الإضافة بنجاح !']);
    }

    public function edit(admin $admin)
    {
        $roles = Role::all();
        $adminRole = $admin->roles->first();
        return view('dashboard.admins.edit' , compact('admin' , 'roles' , 'adminRole'));
    }


    public function update(Request $request, Admin $admin)
    {
         $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'password'  => 'nullable|min:8',
            'image'     => 'nullable|image|mimes:jpg,png,jpeg',
            'role_id'   => 'required|exists:roles,id'
        ]);

        $userData = $request->except(['password' , 'image' , 'role_id']);

        if ($request->password)
            $userData['password'] = bcrypt($request->password);

        if ($request->hasFile('image'))
            $userData['image'] = image_uploader_with_resize($request->file('image'),200,200);

        $admin->update($userData);
        DB::table('model_has_roles')->where('model_id',$admin->id)->delete();
        $admin->assignRole($request->input('role_id'));

        return to_route('dashboard.admins.index')->with(['success'=>'تم التعديل بنجاح !']);
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return to_route('dashboard.admins.index')->with(['success'=>'تم الحذف بنجاح !']);
    }
}
