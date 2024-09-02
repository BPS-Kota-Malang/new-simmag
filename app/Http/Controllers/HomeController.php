<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Services\AttendanceService;
use App\Services\InternService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{   
    /**
     * INject Service
     */
    protected $internService;
    protected $attendanceService;

    public function __construct(InternService $internService, AttendanceService $attendanceService)
    {
        $this->internService = $internService;
        $this->attendanceService = $attendanceService;
    }

    function index ()
    {  

        $user = Auth::user();
        $role = $user->getRoleNames()->first(); // Assuming a user has a single role

        switch ($role) {
            case 'Super Admin':
                $activeInterns = $this->internService->getAllActiveInterns();
                $countActiveInterns = count($this->internService->getAllActiveInterns());
                $countUniversity= $activeInterns->pluck('university_id')->unique()->count();
               
                $countMen = $activeInterns->where('sex', 'man')->count();
                $countWomen = $activeInterns->where('sex', 'woman')->count();

                return view('superadmin.dashboard')
                    ->with('countUniversity', $countUniversity)
                    ->with('countMen', $countMen)
                    ->with('countWomen', $countWomen)
                    ->with('countActiveInterns', $countActiveInterns);
                    
            case 'Subbag Umum':
                $activeInterns = $this->internService->getAllActiveInterns();
                $countActiveInterns = count($this->internService->getAllActiveInterns());
                $countUniversity= $activeInterns->pluck('university_id')->unique()->count();
               
                $countMen = $activeInterns->where('sex', 'man')->count();
                $countWomen = $activeInterns->where('sex', 'woman')->count();

                return view('superadmin.dashboard')
                    ->with('countUniversity', $countUniversity)
                    ->with('countMen', $countMen)
                    ->with('countWomen', $countWomen)
                    ->with('countActiveInterns', $countActiveInterns);
            case 'Intern':
                    $intern = $user->intern;
                    $apply = $intern->apply->last();
                    return view('intern.dashboard-intern')->with('intern', $intern)->with('apply', $apply);
            case 'Applicant':
                    $intern = $user->intern;
                    $apply = $intern->apply->last();
                    return view('intern.dashboard-applicant')
                            ->with('user', $user)
                            ->with('apply', $apply)
                            ->with('intern', $intern);
            case 'User':
                return view('intern.dashboard-user')->with('user', $user);
            default:
                abort(403, 'Unauthorized action.');
        }


    }
}
