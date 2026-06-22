<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(25);
        return view('admin.users.index', compact('users'));
    }
}
