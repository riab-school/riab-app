<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterMenu;
use App\Models\MasterMenuChildren;
use App\Models\User;
use App\Models\UserHasMenuPermission;
use Illuminate\Http\Request;


class MenuController extends Controller
{
    public function menuListPage()
    {
        $menu = MasterMenu::with('children')->get();
        $data = [
            'menus' => $menu
        ];
        return view('app.admin.manage-menus.list', $data);
    }

    // Parent
    public function storeParentMenuPage(Request $request)
    {
        if($request->has('id')){
            $data = [
                'menu' => MasterMenu::findOrFail($request->id)
            ];
            return view('app.admin.manage-menus.store-parent', $data);
        }
        $data['menu'] = NULL;
        return view('app.admin.manage-menus.store-parent', $data);
    }

    public function handleStoreParentMenu(Request $request)
    {
        $request->validate([
            'title'     => 'required',
            'icon'      => 'required',
            'order'     => 'required',
            'level'     => 'required|in:staff,admin',
        ]);

        try {
            MasterMenu::updateOrCreate([
                'id'        => $request->id ?? null,
            ],[
                'title'     => $request->title,
                'icon'      => $request->icon,
                'order'     => $request->order,
                'level'     => $request->level,
                'is_active' => 1
            ]);
            appLog(auth()->user()->id, 'success', 'Berhasil menambah atau merubah menu : '.$request->title);
            return redirect()->route('admin.manage-menu')->with([
                'status'    => 'success',
                'message'   => 'Menu has been saved'
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal menambah atau merubah menu : '.$request->title);
            return redirect()->back()->withInput()->with([
                'status'    => 'error',
                'message'   => 'Menu failed to save'
            ]);
        }
    }

    public function ajaxSetStatusParent(Request $request)
    {
        if($request->ajax()){
            $menu = MasterMenu::findOrFail($request->id);
            if($menu->is_active == true){
                $menu->is_active = false;
            } else {
                $menu->is_active = true;
            }
            $menu->save();
            appLog(auth()->user()->id, 'success', "Berhasil memperbarui status menu : $menu->title menjadi $menu->is_active");
            return response()->json([
                'status'    => 'success',
                'message'   => 'Menu status has been updated'
            ]);
        }
    }

    public function ajaxDeleteParentMenu(Request $request)
    {
        if($request->ajax()){
            $menu = MasterMenu::findOrFail($request->id);
            $menu->delete();
            appLog(auth()->user()->id, 'success', 'Berhasil menghapus menu : '.$menu->title);
            return response()->json([
                'status'    => 'success',
                'message'   => 'Menu status has been deleted'
            ]);
        }
    }

    // Child
    public function storeChildMenuPage(Request $request)
    {
        $data['menu'] = NULL;
        if($request->has('id')){
            $data = [
                'menu' => MasterMenuChildren::findOrFail($request->id),
            ];
        }
        $data['parent_id']  = $request->parent_id;

        return view('app.admin.manage-menus.store-child', $data);
    }

    public function handleStoreChildMenu(Request $request)
    {
        $request->validate([
            'title'     => 'required',
            'route'     => 'required',
            'order'     => 'required',
        ]);

        try {
            MasterMenuChildren::updateOrCreate([
                'id'        => $request->id ?? null,
            ],[
                'menu_id'   => $request->menu_id,
                'title'     => $request->title,
                'route'     => $request->route,
                'order'     => $request->order,
                'is_active' => 1
            ]);
            appLog(auth()->user()->id, 'success', 'Berhasil menambah atau merubah anak menu : '.$request->title);
            return redirect()->route('admin.manage-menu')->with([
                'status'    => 'success',
                'message'   => 'Child Menu has been saved'
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal menambah atau merubah anak menu : '.$request->title);
            return redirect()->back()->withInput()->with([
                'status'    => 'error',
                'message'   => 'Child Menu failed to save'
            ]);
        }
    }

    public function ajaxSetStatusChild(Request $request)
    {
        if($request->ajax()){
            $menu = MasterMenuChildren::findOrFail($request->id);
            if($menu->is_active == true){
                $menu->is_active = false;
            } else {
                $menu->is_active = true;
            }
            $menu->save();
            appLog(auth()->user()->id, 'success', "Berhasil memperbarui status anak menu : $menu->title menjadi $menu->is_active");
            return response()->json([
                'status'    => 'success',
                'message'   => 'Child Menu status has been updated'
            ]);
        }
    }

    public function ajaxDeleteChildMenu(Request $request)
    {
        if($request->ajax()){
            $menu = MasterMenuChildren::findOrFail($request->id);
            $menu->delete();
            return response()->json([
                'status'    => 'success',
                'message'   => 'Child Menu status has been deleted'
            ]);
        }
    }

    // Child Permission
    public function setPermissionPage(Request $request)
    {
        if($request->has('child_id')){
            $data = [
                'permissions' => UserHasMenuPermission::where('menu_children_id', $request->child_id)->with(['childMenuDetail', 'userDetail'])->get(),
                'childMenu'   => MasterMenuChildren::findOrFail($request->child_id),
                'userList'    => User::where('user_level', 'staff')->get()
            ];
            return view('app.admin.manage-menus.store-permission-per-child', $data);
        } elseif($request->has('menu_id')){
            $data = [
                'permissions' => UserHasMenuPermission::whereHas('childMenuDetail', function($q) use ($request){
                    $q->where('menu_id', $request->menu_id);
                })->with(['childMenuDetail', 'userDetail'])->get(),
                'menu'        => MasterMenu::findOrFail($request->menu_id),
                'userList'    => User::where('user_level', 'staff')->get()
            ];
            return view('app.admin.manage-menus.store-permission-per-menu', $data);
        } else {
            $data = [
                'permissions' => UserHasMenuPermission::whereHas('childMenuDetail')->with(['childMenuDetail', 'userDetail'])->get(),
                'userList'    => User::where('user_level', 'staff')->get()
            ];
            return view('app.admin.manage-menus.store-permission-all', $data);

        }
    }

    public function handleSetPermission(Request $request)
    {
        $request->validate([
            'user_id'           => 'required',
        ]);
        try {
            if($request->has('child_id')){
                UserHasMenuPermission::updateOrCreate([
                    'user_id'               => $request->user_id,
                    'menu_children_id'      => $request->child_id,
                ],[
                    'assigned_at'           => now(),
                    'is_permanent_access'   => $request->permited_start_at == null ? 1 : 0,
                    'permited_start_at'     => $request->permited_start_at ?? null,
                    'permited_end_at'       => $request->permited_end_at ?? null,
                ]);
            } elseif($request->has('menu_id')){
                //Get all child menu
                $childMenu = MasterMenuChildren::where('menu_id', $request->menu_id)->get();
                foreach ($childMenu as $key => $value) {
                    UserHasMenuPermission::updateOrCreate([
                        'user_id'               => $request->user_id,
                        'menu_children_id'      => $value->id,
                    ],[
                        'assigned_at'           => now(),
                        'is_permanent_access'   => $request->permited_start_at == null ? 1 : 0,
                        'permited_start_at'     => $request->permited_start_at ?? null,
                        'permited_end_at'       => $request->permited_end_at ?? null,
                    ]);
                }
            } else {
                // Give all menu permission
                $childMenu = MasterMenuChildren::all();
                foreach ($childMenu as $key => $value) {
                    UserHasMenuPermission::updateOrCreate([
                        'user_id'               => $request->user_id,
                        'menu_children_id'      => $value->id,
                    ],[
                        'assigned_at'           => now(),
                        'is_permanent_access'   => $request->permited_start_at == null ? 1 : 0,
                        'permited_start_at'     => $request->permited_start_at ?? null,
                        'permited_end_at'       => $request->permited_end_at ?? null,
                    ]);
                }
            }
            appLog(auth()->user()->id, 'success', 'Berhasil menambahkan izin menu ke user : '.$request->user_id);
            return redirect()->back()->with([
                'status'    => 'success',
                'message'   => 'Permission has been saved'
            ]);
        } catch (\Throwable $th) {
            appLog(auth()->user()->id, 'error', 'Gagal menambahkan izin menu ke user : '.$request->user_id);
            return redirect()->back()->with([
                'status'    => 'error',
                'message'   => 'Permission failed to save'
            ]);
        }
    }

    public function ajaxDeletePermission(Request $request)
    {
        if($request->ajax()){
            $menu = UserHasMenuPermission::findOrFail($request->id);
            $menu->delete();
            appLog(auth()->user()->id, 'success', 'Berhasil menghapus izin menu untuk user : '.$menu->user_id);
            return response()->json([
                'status'    => 'success',
                'message'   => 'Permission to user has been deleted'
            ]);
        }
    }
}
