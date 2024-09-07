<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{   
    // Display email form with list of interns
    public function index()
    {
        $interns = Intern::all();
        return view('superadmin-email.index', compact('interns'));
    }

    // Handle the form submission and send emails
    public function send(Request $request)
    {
        $request->validate([
            'interns' => 'required|array',
            'content' => 'required',
        ]);

        $interns = Intern::whereIn('id', $request->interns)->get();

        foreach ($interns as $intern) {
            Mail::raw($request->content, function ($content) use ($intern) {
                $content->to($intern->user->email)
                        ->subject('Notification for Intern');
            });
        }

        return redirect()->back()->with('success', 'Email(s) sent successfully.');
    }
}
