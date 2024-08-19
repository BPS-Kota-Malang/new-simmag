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
use App\Models\Apply;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


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
     * update photo profile
     */

    public function updatePhotoProfile(Request $request)
    {
        
        // $request->validate([
        //     'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        // ]);
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $intern = $this->internService->getAuthIntern();
        $month = Carbon::parse($intern->start_date)->format('Ym');

        
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($intern->photo) {
                // Check if the file exists on the disk
                if (Storage::disk('public')->exists($intern->photo)) {
                    Storage::disk('public')->delete($intern->photo);
                } else {
                    Log::warning('Photo not found on disk: ' . $intern->photo);
                }
            }

            $originalName = $request->file('photo')->getClientOriginalName();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filename = $month. '_' . Str::slug($intern->university->name) . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
            $path = $request->file('photo')->storeAs('profile_photos', $filename, 'public');
            // $filename = time()  . $intern->id . '_'  . $intern->name . '.' . $request->file('photo')->extension();
            // $path = $request->file('photo')->storeAs('/public/profile_photos', $filename);
            // dd($path);
            // $intern->file_proposal = $request->file('file_proposal')->store('proposals', 'public');
            $intern->update(['photo' => $path]);
        }

        return redirect()->back()->with('status', 'Profile photo updated successfully!');
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
        /**
         * Validate $request from frontend
         */
        // dd($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'university_id' => 'required',
            'faculty_id' => 'required',
            'department_id' => 'required',
            'phone' => 'required|string|max:20',
            'file_proposal' => 'required|file|mimes:pdf,doc,docx',
            'file_suratpengantar' => 'required|file|mimes:pdf,doc,docx',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
         // Create Carbon instances from the request dates
        $formattedStartDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $formattedEndDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');
        
        // Create and save the intern with formatted dates
        $intern = new Intern();
        $intern->name = $request->input('name');
        $intern->nim = $request->input('nim');
        $intern->phone = $request->input('phone');
        $intern->university_id = $request->input('university_id');
        $intern->faculty_id = $request->input('faculty_id');
        $intern->department_id = $request->input('department_id');
        $intern->start_date = $formattedStartDate;
        $intern->end_date = $formattedEndDate;
        $intern->user_id = Auth::user()->id;
        $intern->work_status = 'on progress';
        $intern->division_id = Division::where('name', 'Sub Bagian Umum')->pluck('id')->first();

        // $intern->save();

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
                'start_date_apply' => $formattedStartDate,
                'end_date_apply' => $formattedEndDate,
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
    public function show($id)
    {
        $intern = $this->internService->getSelectedIntern($id);
        // return $intern;
        return view('intern.profile')->with('intern', $intern);
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
    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'sex' => 'required',
            'phone' => 'nullable|string|max:255',
        ]);

        $intern = Intern::findOrFail($id);
        $intern->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'sex' => $request->input('sex'),
            // Update other fields as needed
        ]);

        return redirect()->back()->with('status', 'Profile updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intern $intern)
    {
        //
    }
}
