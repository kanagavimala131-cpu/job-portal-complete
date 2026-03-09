<?php

namespace App\Http\Controllers;

use App\Models\UserPersonalDetail;
use App\Models\ShortlistedJob;
use App\Models\AppliedJob;
use App\Models\JobAlert;
use App\Models\CvFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function profile()
    {
        $userDetails = UserPersonalDetail::where('user_id', Auth::id())->first();
        return view('pages.profile', compact('userDetails'));
    }

    public function shortlisted()
    {
        $userDetails = UserPersonalDetail::where('user_id', Auth::id())->first();
        $shortlistedJobs = ShortlistedJob::where('user_id', Auth::id())
            ->orderBy('shortlisted_date', 'desc')
            ->get();
        
        return view('pages.shortlisted', compact('userDetails', 'shortlistedJobs'));
    }

    public function applied()
    {
        $userDetails = UserPersonalDetail::where('user_id', Auth::id())->first();
        $appliedJobs = AppliedJob::where('user_id', Auth::id())
            ->orderBy('applied_date', 'desc')
            ->get();
        
        return view('pages.applied', compact('userDetails', 'appliedJobs'));
    }

    public function alerts()
    {
        $userDetails = UserPersonalDetail::where('user_id', Auth::id())->first();
        $jobAlerts = JobAlert::where('user_id', Auth::id())->get();
        
        return view('pages.alerts', compact('userDetails', 'jobAlerts'));
    }

    public function cv()
    {
        $userDetails = UserPersonalDetail::where('user_id', Auth::id())->first();
        $cvFiles = CvFile::where('user_id', Auth::id())->get();
        
        return view('pages.cv', compact('userDetails', 'cvFiles'));
    }

    public function changePassword()
    {
        $userDetails = UserPersonalDetail::where('user_id', Auth::id())->first();
        return view('pages.change-password', compact('userDetails'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully');
    }

    public function addToShortlist(Request $request)
    {
        $shortlisted = ShortlistedJob::create([
            'user_id' => Auth::id(),
            'job_title' => $request->job_title,
            'company' => $request->company,
            'location' => $request->location,
            'salary' => $request->salary,
            'job_type' => $request->job_type,
            'shortlisted_date' => now()
        ]);

        return response()->json(['success' => true, 'data' => $shortlisted]);
    }

    public function removeFromShortlist($id)
    {
        ShortlistedJob::where('user_id', Auth::id())->where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    public function applyJob(Request $request)
    {
        $applied = AppliedJob::create([
            'user_id' => Auth::id(),
            'job_title' => $request->job_title,
            'company' => $request->company,
            'location' => $request->location,
            'salary' => $request->salary,
            'status' => 'Applied',
            'applied_date' => now()
        ]);

        return response()->json(['success' => true, 'data' => $applied]);
    }

    public function withdrawApplication($id)
    {
        AppliedJob::where('user_id', Auth::id())->where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    public function createAlert(Request $request)
    {
        $alert = JobAlert::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'keywords' => $request->keywords,
            'frequency' => $request->frequency,
            'location' => $request->location,
            'min_salary' => $request->min_salary,
            'is_active' => true
        ]);

        return response()->json(['success' => true, 'data' => $alert]);
    }

    public function deleteAlert($id)
    {
        JobAlert::where('user_id', Auth::id())->where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    public function toggleAlert($id)
    {
        $alert = JobAlert::where('user_id', Auth::id())->where('id', $id)->first();
        $alert->is_active = !$alert->is_active;
        $alert->save();
        return response()->json(['success' => true, 'is_active' => $alert->is_active]);
    }

    public function uploadCV(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120'
        ]);

        $file = $request->file('cv_file');
        $filename = 'cv_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('cvs', $filename, 'public');

        CvFile::create([
            'user_id' => Auth::id(),
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $file->getSize()
        ]);

        return response()->json(['success' => true]);
    }

    public function downloadCV($id)
    {
        $cv = CvFile::where('user_id', Auth::id())->where('id', $id)->first();
        return Storage::disk('public')->download($cv->file_path, $cv->original_name);
    }

    public function deleteCV($id)
    {
        $cv = CvFile::where('user_id', Auth::id())->where('id', $id)->first();
        Storage::disk('public')->delete($cv->file_path);
        $cv->delete();
        return response()->json(['success' => true]);
    }

    public function uploadCoverLetter(Request $request)
    {
        $request->validate([
            'cover_letter_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'company' => 'nullable|string',
            'position' => 'nullable|string'
        ]);

        if ($request->hasFile('cover_letter_file')) {
            $file = $request->file('cover_letter_file');
            $filename = 'cover_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('cover-letters', $filename, 'public');

            return response()->json([
                'success' => true,
                'message' => 'Cover letter uploaded successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Upload failed'
        ], 400);
    }

    public function deleteCoverLetter($id)
    {
        // Implement if you have cover_letters table
        return response()->json(['success' => true]);
    }
}