<?php namespace App\Http\Controllers\Admin;

use App\Project;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $usersAct = User::all()->count();
        $totalProjects = Project::all()->count();
        return redirect()->route('admin.projects.index');
        return view('admin.dashboard', compact('usersAct', 'totalProjects'));
    }
}
