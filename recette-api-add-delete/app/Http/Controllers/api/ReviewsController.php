<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Reviews;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    // enregistrer un commentaire
    public function store_reviews(Request $request)
    {
        $credentials = $request->validate([
            'user_id' => 'required',
            'mark' => 'required',
            'comment' => 'required'
        ]);

        if (!User::find('user_id')) return response()->json(["message" => "L'utilisateur n'existe pas, donc vous ne pouvez commenter", "status" => 200]);

        Reviews::create($credentials);

        return response()->json(["message" => "Commentaire envoyé !", "status" => 200]);
    }


    public function delete_reviews(Request $request)
    {
        $request->validate([
            'comment_id' => 'request'
        ]);
        $comment = Reviews::findOrFail($request->input('comment_id'));
        $comment->delete();


        return response()->json(["message"=>"Commentaire supprimé !", "status"=>200]);
    }
}
