<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();

        $roles = Role::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('role_name', 'like', '%'.$search.'%');
            })
            ->orderBy('id_role')
            ->paginate(10)
            ->withQueryString();

        return view('features.roles.index', compact('roles', 'search'));
    }
}
