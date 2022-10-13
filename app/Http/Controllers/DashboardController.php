<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Search;
use Illuminate\Http\Request;
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
        return view('search.index',compact('users','keywords_list'));
    }
}
