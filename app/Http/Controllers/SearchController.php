<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function list()
    {
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

        if ($request->has('user')) {
            dd('yes');
        }
    }
}
