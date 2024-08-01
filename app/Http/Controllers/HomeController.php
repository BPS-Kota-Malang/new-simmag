<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    function index ()
    {  

        $user = Auth::user();
        $role = $user->getRoleNames()->first(); // Assuming a user has a single role

        switch ($role) {
            case 'Super Admin':
                return view('superadmin.dashboard');
            case 'Intern':
                    $intern = $user->intern;
                    $apply = $intern->apply->last();
                    return view('intern.dashboard-intern')->with('intern', $intern)->with('apply', $apply);
            case 'Applicant':
                return view('intern.dashboard-applicant')->with('user', $user);
            case 'User':
                return view('intern.dashboard-user')->with('user', $user);
            default:
                abort(403, 'Unauthorized action.');
        }


    }
}
