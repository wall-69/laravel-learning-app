<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserWordPackController extends Controller
{
    public function index(Request $request)
    {
        // $wordPacks = $request->user()->userWordPacks()->with("wordPack")->get()->pluck("wordPack");
        // $paginator = $request->user()->userWordPacks()->search($request->search ?? "")->latest()->paginate(30);
        $user = $request->user();
        $search = $request->search ?? "";

        $paginator = $user->userWordPacks()
            ->whereHas("wordPack", function ($q) use ($search) {
                $q->search($search);
            })
            ->latest()->with("wordPack")->paginate(30);

        // "Pluck" word pack
        $paginator->getCollection()->transform(function ($item) {
            return $item->wordPack;
        });

        return response()->json($paginator);
    }
}
