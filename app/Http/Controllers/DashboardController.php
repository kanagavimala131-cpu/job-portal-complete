<?php

namespace App\Http\Controllers;

use App\Models\UserPersonalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
{
    $userDetails = UserPersonalDetail::where('user_id', Auth::id())->first();
    
    if (!$userDetails) {
        $userDetails = UserPersonalDetail::create([
            'user_id' => Auth::id(),
            'fullname' => Auth::user()->email,
            'email' => Auth::user()->email,
            // Add default values for ALL required fields
            'date_of_birth' => '2000-01-01',
            'gender' => 'female',
            'work_status' => 'experience',
            'total_experience_years' => 0,
            'total_experience_months' => 0,
            'current_salary' => 0,
            'notice_period' => 'Notice Required',
            'phone' => '0000000000',
            'current_city' => 'City',
            'current_area' => 'Area'
        ]);
    }

    return view('dashboard.index', compact('userDetails'));
}

   public function update(Request $request)
{
    $request->validate([
        'fullname' => 'required|string|max:255',
        'dob' => 'required|date',
        'gender' => 'required|in:male,female,transgender',
        'work_status' => 'required|in:fresher,experience',
        'experience_years' => 'required|integer|min:0|max:15',
        'experience_months' => 'required|integer|min:0|max:11',
        'current_salary' => 'required|numeric|min:0',
        'notice_period' => 'required|string|max:255',
        'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
        'city' => 'required|string|max:255',
        'area' => 'required|string|max:255',
        'facebook' => 'nullable|string|max:255',
        'twitter' => 'nullable|string|max:255',
        'linkedin' => 'nullable|string|max:255',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
    ]);

    $userDetails = UserPersonalDetail::where('user_id', Auth::id())->first();

    if ($request->hasFile('profile_photo')) {
        if ($userDetails->profile_photo && Storage::disk('public')->exists($userDetails->profile_photo)) {
            Storage::disk('public')->delete($userDetails->profile_photo);
        }

        $file = $request->file('profile_photo');
        $filename = 'user_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('profile-photos', $filename, 'public');
        $userDetails->profile_photo = $path;
    }

    // Update all fields - ALL required now
    $userDetails->fullname = $request->fullname;
    $userDetails->date_of_birth = $request->dob;
    $userDetails->gender = $request->gender;
    $userDetails->work_status = $request->work_status;
    $userDetails->total_experience_years = $request->experience_years;
    $userDetails->total_experience_months = $request->experience_months;
    $userDetails->current_salary = $request->current_salary;
    $userDetails->notice_period = $request->notice_period;
    $userDetails->phone = $request->phone;
    $userDetails->current_city = $request->city;
    $userDetails->current_area = $request->area;
    $userDetails->facebook_url = $request->facebook;
    $userDetails->twitter_url = $request->twitter;
    $userDetails->linkedin_url = $request->linkedin;
    
    $userDetails->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}
}