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

        return view('search.index',compact('users','keywords_list'));
    }
}
