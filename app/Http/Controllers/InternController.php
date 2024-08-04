<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\University;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;
use App\Services\UniversityService;
use App\Services\InternService;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Models\Apply;
use App\Models\Division;


class InternController extends Controller
{   

    protected $universityService;
    protected $internService;

    // Inject the service via the constructor
    public function __construct(UniversityService $universityService, InternService $internService)
    {
        $this->universityService = $universityService;
        $this->internService = $internService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $intern = $this->internService->getAuthIntern();
        // return $intern;
        return view('intern.profile')->with('intern', $intern);
    }

    public function statusIntern ($user)
    {   
        $user->assignRole('Intern');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Use the service to get universities
        $universities = $this->universityService->getUniversities();

        $user = Auth::user();
        
        return view('intern.apply', compact('user', 'universities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $tatausaha = Division::where('name', 'Sub Bagian Umum')
                                ->pluck('id')                        
                                ->first();

       
        /**
         * Validate $request from frontend
         */
        $request->validate([
            'nim' => 'required|string|max:20',
            'name' => 'required|string|max:50',
            'university' => 'required|string|max:100',
            'faculty' => 'required|string|max:100',
            'courses' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'file_proposal' => 'required|file|mimes:pdf|max:2048',
            'file_suratpengantar' => 'required|file|mimes:pdf|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            // 'user_id' => 'required|exists:users,id',
            // 'work_status' => 'required|in:accepted,on progress,rejected',
        ]);

        $request->merge([
            'user_id' => $user->id,
            'work_status' => 'on progress',
            'division_id' => $tatausaha,
        ]);

        $intern = new Intern($request->all());

        // dd($intern);
        if ($request->hasFile('file_proposal')) {
            $intern->file_proposal = $request->file('file_proposal')->store('proposals', 'public');
        }

        if ($request->hasFile('file_suratpengantar')) {
            $intern->file_suratpengantar = $request->file('file_suratpengantar')->store('suratpengantar', 'public');
        }

        $intern->save();

        /**
         *  Create New Apply Record
         */
        $applies = Apply::create(
            [
                'intern_id' => $intern->id,
                'start_date_apply' => $request->start_date,
                'end_date_apply' => $request->end_date,
            ]
        );
        
        // $internData = Intern::find($)
        // $user->drop
        $user->assignRole("Applicant");

        // dd ($intern); 
        return redirect()->route('dashboard')
            ->with('success', 'Applicant created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Intern $intern)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Intern $intern)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intern $intern)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intern $intern)
    {
        //
    }
}
