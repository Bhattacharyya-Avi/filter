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
        $keywords_list = DB::table('searches')
        ->select('keyword', DB::raw('count(*) as total'))
        ->groupBy('keyword')
        ->get();
        $users = User::all();
        // $results = Search::all();

        $results = Search::query();
        if (request()->user != null) {
            $results->where('user_id', request()->user);
            // return response()->json($filter_result);
        }

        // only by keyword
        if (request()->keyword != null) {
        $results ->where('keyword', request()->keyword);
        //    dd($filter_result);
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
            $results ->whereBetween('date', [request()->fromdate, request()->todate]);
            // dd($filter_result);
        }
        // dd($search_result->get());
        $results = $results->get();
    // }

        return view('search.index',compact('users','keywords_list','results'));
    }
}
