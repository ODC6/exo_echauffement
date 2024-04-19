<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    public function store_category(Request $request)
    {
        $category = $request->validate(['category_name' => 'required']);

        $create = Category::create($category);

        if (!$create) return response()->json(["message" => "Une erreur est survenue !", "status" => 500]);

        return response()->json(["message" => "Categorie enregistrée !", "status" => 200]);
    }


    public function delete_category(Request $request)
    {
        $request->validate(["id_category" => "required"]);
        $id_category = $request->input('id_category');
        $category = Category::findOrFail($id_category);

        try {
            $category->delete();
            return response()->json(["message" => "La catégorie a été supprimé !", "status" => 200]);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Une erreur est survenue !", "status" => 500]);
        }
    }
}
