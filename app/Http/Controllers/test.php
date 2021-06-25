<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Http\Resources\EmployeeResource;
use App\Mail\activeAccountEmail;
use App\Mail\sendEmailToUser;
use App\User;
use App\model\Admin\Admin;
use App\model\Ship;
use App\model\Task;
use App\model\Trip;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Config;

class AdminController extends Controller
{
    /**
     * retun last 7 days from today with day name [e.g: SAT] and Day no [e.g: 17]
     *
     * @return array
     */
    function __construct()
    {
        //Auth::shouldUse('admin_api');
    }

    //  public function __construct()
    // {
    //     $this->admin = new Admin;
    //     $this->user = new User;
    //     // We set the guard api as default driver
    //     //auth()->setDefaultDriver('admin_api');
    // }




    public function adminlogin(Request $request)
    {

        $credentials = $request->only(['email', 'password']);

       if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }


    public function getLastSevenDays(){
        $d_array = array();
        for ($i=0; $i<=6; $i++) {
           $posts_dates[] = Carbon::now()->subDays($i)->format('Y-m-d');
        }
        foreach ( $posts_dates as $date ) {
            $date = new \DateTime( $date);
            $d_no = $date->format( 'd' );
            $d_name = $date->format( 'D' );
            $d_array[ $d_no ] = $d_name;
        }
        return $d_array;
    }

    /**
     * return number  of trip post according to a day
     *
     * @return array
     */

    public function getDailyCompletedTrips( $day ) {
        $daily_completed_trip = Trip::whereDay( 'created_at', $day )->get()->count();
        return $daily_completed_trip;
    }

    public function getDailyCompletedShipments( $day ) {
        $daily_completed_ships = Ship::whereDay( 'created_at', $day )->get()->count();
        return $daily_completed_ships;
    }

    public function getDailyCompletedTasks( $day ) {
        $daily_completed_tasks = Task::whereDay( 'created_at', $day )->get()->count();
        return $daily_completed_tasks;
    }


    public function getAllPostsAnalytics()
    {
        $tripPosts=array();
        $totalactivetrip=0;
        $totalcompletedtrip=0;
        $totaldisputedtrip=0;
        $totalarchivedtrip=0;

        $totalactiveship=0;
        $totalcompletedship=0;
        $totaldisputedship=0;
        $totalarchivedship=0;

        $totalactivetask=0;
        $totalcompletedtask=0;
        $totaldisputedtask=0;
        $totalarchivedtask=0;

        $totalgivetrip=0;
        $totalgettrip=0;
        $totalshipments=0;
        $totalsendpackage=0;
        $totalcarrypackage=0;
        $totaltasks=0;
        $totaloffertask=0;
        $totalseektask=0;
        $trip=Trip::all();
        foreach ($trip as $key => $value) {
            $totalactivetrip=$value->where('status','active')->count();
            $totalcompletedtrip=$value->where('status','completed')->count();
            $totaldisputedtrip=$value->where('status','disputed')->count();
            $totalarchivedtrip=$value->where('status','archived')->count();
            $totalgivetrip=$value->where('post_type','offer')->count();
            $totalgettrip=$value->where('post_type','seek')->count();
        };
        $ship=Ship::all();
        foreach ($ship as $key => $ship) {
            $totalactiveship=$ship->where('status','active')->count();
            $totalcompletedship=$ship->where('status','completed')->count();
            $totaldisputedship=$ship->where('status','disputed')->count();
            $totalarchivedship=$ship->where('status','archived')->count();
            $totalsendpackage=$ship->where('post_type','send_package')->count();
            $totalcarrypackage=$ship->where('post_type','carry_package')->count();
        };
        $task=Task::all();
        foreach ($task as $key => $task) {
            $totalactivetask=$task->where('status','active')->count();
            $totalcompletedtask=$task->where('status','completed')->count();
            $totaldisputedtask=$task->where('status','disputed')->count();
            $totalarchivedtask=$task->where('status','archived')->count();
            $totaloffertask=$task->where('post_type','offer')->count();
            $totalseektask=$task->where('post_type','seek')->count();
        };
        $tripPosts = array(
            'total_active_posts' => $totalactivetrip+$totalactiveship+$totalactivetask,
            'total_completed_posts' => $totalcompletedtrip+$totalcompletedship+$totalcompletedtask,
            'total_disputed_posts' => $totaldisputedtrip+$totaldisputedship+$totaldisputedtask,
            'total_archived_posts' => $totalarchivedtrip+$totalarchivedship+$totalarchivedtask,
            'total_trip_posts'=>$totalgivetrip+$totalgettrip,
            'total_givetrips' => $totalgivetrip,
            'total_gettrips' => $totalgettrip,
            'total_completed_trips' => $totalcompletedtrip,
            'total_ship_posts'=>$totalsendpackage+$totalcarrypackage,
            'total_sendpackage' => $totalsendpackage,
            'total_carrypackage' => $totalcarrypackage,
            'total_completed_ships' => $totalcompletedship,
            'total_task_posts'=>$totaloffertask+$totalseektask,
            'total_offertasks' => $totaloffertask,
            'total_seektasks' => $totalseektask,
            'total_completed_tasks' => $totalcompletedtask,
        );

        return $tripPosts;
    }


    public function index(){
        $daily_trip_count_array = array();
        $daily_ships_count_array = array();
        $daily_tasks_count_array = array();
        $days_array = $this->getLastSevenDays();
        $days_name_array = array();
        if ( ! empty( $days_array ) ) {
            foreach ( $days_array as $d_no => $d_name ){
                $daily_completed_trip = $this->getDailyCompletedTrips( $d_no );
                $daily_completed_ships = $this->getDailyCompletedShipments( $d_no );
                $daily_completed_tasks = $this->getDailyCompletedTasks( $d_no );
                array_push( $daily_trip_count_array, $daily_completed_trip );
                array_push( $daily_ships_count_array, $daily_completed_ships );
                array_push( $daily_tasks_count_array, $daily_completed_tasks );
                array_push( $days_name_array, $d_name );
            }
        }
        $daily_post_data_array = array(
            'days' => $days_name_array,
            'daily_completed_trips' => $daily_trip_count_array,
            'daily_completed_ships' => $daily_ships_count_array,
            'daily_completed_tasks' => $daily_tasks_count_array,
            'post_count'=>$this->getAllPostsAnalytics()
        );
        return response()->json(["data"=>$daily_post_data_array],200);

    }



}

