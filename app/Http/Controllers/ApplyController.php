<?php

namespace App\Http\Controllers;

use App\Models\Apply;
use App\Models\Intern;
use App\Http\Requests\StoreApplyRequest;
use App\Http\Requests\UpdateApplyRequest;
use App\Mail\ApplicantMail;
use App\Mail\RegistrationMail;
use App\Models\University;
use App\Services\InternService;
use App\Services\UniversityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ApplyController extends Controller
{   
    protected $universityService;
    protected $internService;

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
        $applies = Apply::all();
        return view('superadmin-apply.index')
                    ->with('apply', $applies);
    }

    public function getData()
    {
        $applies = Apply::all();
                
        return DataTables::of($applies)
        ->addColumn('intern_name', function($apply) {
            // return $apply->intern->name;
            return 
            '<a href="'.route('interns.show', $apply->intern->id).'" class="text-blue-500 hover:underline">'
                .$apply->intern->name.
            '</a>';
        })
        ->addColumn('status', function($apply) {
            // return $apply->intern->work_status;
            $status = $apply->intern->work_status;
            $class = '';

            switch ($status) {
                case 'accepted':
                    $class = 'text-green-800 bg-green-100';
                    break;
                case 'rejected':
                    $class = 'text-red-800 bg-red-100';
                    break;
                case 'on progress':
                    $class = 'text-blue-800 bg-blue-100';
                    break;
                default:
                    $class = 'text-gray-800 bg-gray-100';
                    break;
            }

            return '<span class="inline-block px-2 py-1 rounded ' . $class . '">' . ucfirst($status) . '</span>';
        
        })
        ->addColumn('university', function($apply) {
            return $apply->intern->university->name;
        })
        ->addColumn('faculty', function($apply) {
            return $apply->intern->faculty->name;
        })
        ->addColumn('department', function($apply) {
            return $apply->intern->department->name;
        })
        ->addColumn('proposal', function($apply) {
            return 
                '<a href="'.Storage::url($apply->intern->file_proposal).'" target="_blank" class="text-blue-500 hover:underline">
                    Open Proposal
                </a>';
        })
        ->addColumn('pengantar', function($apply) {
            return 
                '<a href="'.Storage::url($apply->intern->file_suratpengantar).'" target="_blank" class="text-blue-500 hover:underline">
                    Open Surat Pengantar
                </a>';
        })
        ->addColumn('registration_date', function($apply) {
            return Carbon::parse($apply->created_at)->format('Y-m-d');
            
        })
        ->addColumn('apply_date', function($apply) {
            return $apply->start_date_apply . ' s.d. ' . $apply->end_date_apply;
        })
        ->addColumn('answer_date', function($apply) {
            if($apply->start_date_answer && $apply->end_date_answer){
                return $apply->start_date_answer . ' s.d. ' . $apply->end_date_answer;
            } 
            else{
                return '-';
            }
        })
        ->addColumn('actions', function($apply) {
            return '
                <td class="px-6 py-4 text-center">
                    <a href="#" data-id="'.$apply->id.'" data-start-date-answer="'.$apply->start_date_answer.'" data-end-date-answer="'.$apply->end_date_answer.'" class="text-blue-600 hover:text-blue-800 edit-btn" data-modal-target="edit-date-modal">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="'.route('apply.accepted', ['id' => $apply->intern->id]).'" class="mx-2 text-green-600 hover:text-green-800">
                        <i class="fa fa-check-square"></i>
                    </a>
                    <a href="#" data-id="'.$apply->id.'" class="text-red-600 hover:text-red-800 reject-btn" data-modal-target="reject-modal">
                        <i class="fa fa-close"></i>
                    </a>
                </td>';
        })
        ->rawColumns(['intern_name','status','actions','pengantar', 'proposal'])
        ->make(true);
        // ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Use the service to get universities
        $universities = $this->universityService->getUniversities();

        $user = Auth::user();
        
        return view('apply.create')
                ->with('user', $user)
                ->with('universities', $universities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplyRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Apply $apply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $apply = Apply::findOrFail($id);  // Fetch a single record by ID
        return view('superadmin.apply', compact('apply'));  // Pass the single record to the view
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apply $apply)
    {   
        
        $validatedData = $request->validate([
            'start_date_answer' => 'required|date',
            'end_date_answer' => 'required|date',
        ]);

        // dd($validatedData);

        $intern = $apply->intern;

        if ($intern->work_status != "on progress")
        {
            $intern->update(
                [
                    'work_status' => 'on progress'
                ]
            );
        }
        $apply->update($validatedData);

        $this->sentChangesDateEmail($apply);

        return redirect()->route('apply.index')->with('success', 'Apply updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apply $apply)
    {
        //
    }

    public function answerDate( $id)
    {
        $apply = Apply::find($id);
        
        return $apply;
    }

    public function accepted (Request $request)
    {
        $intern = Intern::find($request->id);
        
        // return $intern;
        $intern->update(
            [
                'work_status' => 'accepted'
            ]
        );

        $intern->user->removeRole('Applicant');
        $intern->user->assignRole('Intern');

        return redirect()->route('dashboard')->with('success', 'Status updated successfully!');
        
    }

    public function rejected (Request $request, Apply $apply)
    {
        $validatedData = $request->validate([
            'causes' => 'required',
        ]);
        // dd($apply);
        $intern = $apply->intern;

        if ($intern->work_status != "rejected")
        {
            $intern->update(
                [
                    'work_status' => 'rejected'
                ]
            );
        }
        $apply->update($validatedData);

        /**
         * remove Roles From Intern back to User
         * User can register again with another applies
         */

        $intern->user->removeRole('Intern');
        $intern->user->assignRole('User');

        $this->sentChangesDateEmail($apply);

        return redirect()->back()->with('success', 'Status updated successfully!');

    }

    public function sentChangesDateEmail (Apply $apply)
    {
        // Send email notification
        Mail::to($apply->intern->user->email)->send(new ApplicantMail($apply));
    }
}
