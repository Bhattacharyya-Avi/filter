<?php

namespace App\Http\Controllers;

use App\Models\Search;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function list()
    {
        $search_result = Search::with('user')->get();
        return response()->json($search_result);
    }

    public function filter(Request $request)
    {
        // dd($request->all());

        if ($request->has('user')) {
            dd('yes');
        }
    }
}
