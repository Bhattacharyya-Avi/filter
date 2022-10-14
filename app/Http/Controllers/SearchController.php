<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function list()
    {
        
        // if (request()->has('user') || request()->has('keyword') || request()->has('time') || request()->has('fromdate')) {
            $search_result = Search::query();
            if (request()->user != null) {
                $search_result->where('user_id', request()->user);
                // return response()->json($filter_result);
            }

            // only by keyword
            if (request()->keyword != null) {
            $search_result ->where('keyword', request()->keyword);
            //    dd($filter_result);
            }

            // only by time
            if (request()->time != null) {
                switch (request()->time) {
                    case 'Yesterday':
                        $yesterday = Carbon::yesterday()->format('Y-m-d');
                        $search_result = Search::where('date', $yesterday);
                        // dd($filter_result);
                        break;

                    case 'LastWeek':
                        $previous_week = strtotime("-1 week +1 day");
                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);
                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        $search_result ->whereBetween('date', [$start_week, $end_week]);
                        // dd($filter_result);
                        break;
                        
                    case 'LastMonth':
                        $date = \Carbon\Carbon::now();
                        $lastMonth =  $date->subMonth()->format('m');
                        $search_result ->whereMonth('date', $lastMonth);
                        // dd($filter_result);
                    break;

                    default:
                        break;
                }
            }

            // only by date range
            if (request()->fromdate != null && request()->todate != null) {
                $search_result ->whereBetween('date', [request()->fromdate, request()->todate]);
                // dd($filter_result);
            }
            // dd($search_result->get());
            // return response()->json($search_result->get());
        // }
        
        $keywords_list = DB::table('searches')
        ->select('keyword', DB::raw('count(*) as total'))
        ->groupBy('keyword')
        ->get();
        $users = User::all();
        return view('search.index',compact('users','keywords_list'));
    }

    public function filter(Request $request)
    {
        // dd($request->all());
        // $filter_result = 0;
        // only by user id
        // if ($request->has('user')) {
        //     $filter_result = Search::where('user_id', $request->user)->get();
        //     dd($filter_result);
        //     return response()->json($filter_result);
        // }

        // // only by keyword
        // if ($request->has('keyword')) {
        //    $filter_result = Search::where('keyword', $request->keyword)->get();
        //    dd($filter_result);
        // }

        // // only by time
        // if ($request->has('time')) {
        //     switch ($request->time) {
        //         case 'Yesterday':
        //             $yesterday = Carbon::yesterday()->format('Y-m-d');
        //             $filter_result = Search::where('date', $yesterday)->get();
        //             dd($filter_result);
        //             break;

        //         case 'LastWeek':
        //             $previous_week = strtotime("-1 week +1 day");
        //             $start_week = strtotime("last sunday midnight",$previous_week);
        //             $end_week = strtotime("next saturday",$start_week);
        //             $start_week = date("Y-m-d",$start_week);
        //             $end_week = date("Y-m-d",$end_week);
        //             $filter_result = Search::whereBetween('date', [$start_week, $end_week])->get();
        //             dd($filter_result);
        //             break;
                    
        //         case 'LastMonth':
        //             $date = \Carbon\Carbon::now();
        //             $lastMonth =  $date->subMonth()->format('m');
        //             $filter_result = Search::whereMonth('date', $lastMonth)->get();
        //             dd($filter_result);
        //         break;

        //         default:
        //             break;
        //     }
        // }

        // // only by date range
        // if ($request->has('fromdate') && $request->has('todate')) {
        //     $filter_result = Search::whereBetween('date', [$request->fromdate, $request->todate])->get();
        //     dd($filter_result);
        // }
    }
}
