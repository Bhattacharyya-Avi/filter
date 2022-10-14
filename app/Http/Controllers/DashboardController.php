<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // geting the keywords with number of existence
        $keywords_list = DB::table('searches')
        ->select('keyword', DB::raw('count(*) as total'))
        ->groupBy('keyword')
        ->get();

        // geting all user list
        $users = User::all();

        // filtering start
        $results = Search::query(); // runing the filter if any data passed.
        if (request()->user != null) {
            $results->where('user_id', request()->user);
        }

        // only by keyword
        if (request()->keyword != null) {
        $results ->where('keyword', request()->keyword);
        }

        // only by time
        if (request()->time != null) {
            switch (request()->time) {
                case 'Yesterday':
                    $yesterday = Carbon::yesterday()->format('Y-m-d');
                    $results = Search::where('date', $yesterday);
                    // dd($filter_result);
                    break;

                case 'LastWeek':
                    $previous_week = strtotime("-1 week +1 day");
                    $start_week = strtotime("last sunday midnight",$previous_week);
                    $end_week = strtotime("next saturday",$start_week);
                    $start_week = date("Y-m-d",$start_week);
                    $end_week = date("Y-m-d",$end_week);
                    $results ->whereBetween('date', [$start_week, $end_week]);
                    // dd($filter_result);
                    break;
                    
                case 'LastMonth':
                    $date = \Carbon\Carbon::now();
                    $lastMonth =  $date->subMonth()->format('m');
                    $results ->whereMonth('date', $lastMonth);
                    // dd($filter_result);
                break;

                default:
                    break;
            }
        }

        // only by date range
        if (request()->fromdate != null && request()->todate != null) {
            request()->validate([
                'formdate' => 'required',
                'todate' => 'required|after:formdate',
            ]);

            $results ->whereBetween('date', [request()->fromdate, request()->todate]);
        }
        // filter end
        $results = $results->get(); // geting all data if nothin to filter if any filter data filter the data

        return view('search.index',compact('users','keywords_list','results'));
    }
}
