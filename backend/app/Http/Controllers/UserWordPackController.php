<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserWordPackController extends Controller
{
    public function index(Request $request)
    {
        $wordPacks = $request->user()->userWordPacks()->with("wordPack")->get()->pluck("wordPack");

        return response()->json($wordPacks);
    }
}
