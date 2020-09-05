<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\EmpDetail;
use App\EmpAttendance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if ( Auth::user()->role == "admin" ) {

            $date = date('Y-m-d');
            $date = date('Y-m-d', strtotime( $date ));

            $presentUserIds = EmpAttendance::where('present_date', $date)->pluck('user_id')->toArray();
            // dd($presentUserIds);
            $users = User::where('role','employee')->get();

            if (count($users) > 0) {

                $presentPercentage = count($presentUserIds) / count($users);
                $presentPercentage = $presentPercentage * 100;

            } else {

                $presentPercentage = "invalid";

            }

            return view('home', compact('users','presentUserIds','date','presentPercentage'));

        } else {

            $present = EmpAttendance::where('user_id', Auth::user()->id)->where('present_date', date('Y-m-d'))->get();

            if (count($present) >= 1) {

                $present = true;

            } else {

                $present = false;

            }
            return view('home', compact('present'));

        }
        
    }

    /**
     * This function is for creating employee and their details
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addEmployee(Request $request) {

        if ( Auth::user()->role == 'employee' ) {

            return abort(404);

        }

        $validatedData = $request->validate([
            'email' => 'unique:users,email',
            'password' => 'required',
            'salary' => 'required'
        ]);

        $user = User::create([
            'name' => $request['email'],
            'email' => $request['email'],
            'role' => 'employee',
            'password' => bcrypt($request['password'])
        ]);

        $userId = $user->id;

        $empDetails = EmpDetail::create([

            'user_id' => $userId,
            'salary' => $request['salary']

        ]);

        if ($user && $empDetails) {
            
            return redirect()->back()->with('message-success', 'Employee has been added.');
        
        } else {

            return redirect()->back()->with('message-danger', 'Something went wrong');

        }

        
    }


    public function updateEmpProfile(Request $request) {

        if ( Auth::user()->role == 'admin' ) {

            return abort(404);
            
        }

        $userId = Auth::user()->id;
        $userName = is_null($request['name']) ? Auth::user()->email : $request['name'] ;

        $empDetails = EmpDetail::where('user_id', $userId)->update([
            
            'name'=> $request['name'],
            'DOB'=> date('Y-m-d', strtotime( $request['DOB'] )),
            'designation'=> $request['designation']

        ]);

        $user = User::where('id', $userId)->update([

            'name' => $userName
        ]);


        if ($user && $empDetails) {
            
            return redirect()->back()->with('message-success', 'Profile has updated');
        
        } else {

            return redirect()->back()->with('message-danger', 'Something went wrong');

        }

    }


    public function markPresent() {

        if ( Auth::user()->role == 'admin' ) {

            return abort(404);
            
        }

        $checkAttend = EmpAttendance::where('user_id', Auth::user()->id)->where('present_date', date('Y-m-d'))->get();

        if( count($checkAttend) < 1 ) {
            $present = EmpAttendance::create([

                'user_id' => Auth::user()->id,
                'present_date' => date('Y-m-d')

            ]);

        }

        return redirect('/home');
        
    }


    public function getAttendance() {

        if ( Auth::user()->role == 'employee' ) {

            return abort(404);
            
        }

        $date = request()->date;
        $date = date('Y-m-d', strtotime( $date ));

        $presentUserIds = EmpAttendance::where('present_date', $date)->pluck('user_id')->toArray();
        // dd($presentUserIds);
        $users = User::where('role','employee')->get();
        if (count($users) > 0) {

            $presentPercentage = count($presentUserIds) / count($users);
            $presentPercentage = $presentPercentage * 100;

        } else {

            $presentPercentage = "invalid";

        }

        return view('home', compact('users','presentUserIds','date','presentPercentage'));

    }




}
