<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    //

    public function store_dish(Request $request)
    {
        $credentials = $request->validate([
            'dish_name' => 'required',
            'slug'=>'required',
            'dish_ingredient' => 'required',
            'dish_recette' => 'required',
            'preparation' => 'required',
            'cuissons' => 'required',
            'temps_total' => 'required',
            'id_category' => 'required'
        ]);

        $is_exist = Dish::where('slug', $credentials['slug'])->first();

        if($is_exist) return response()->json(["message"=>"Ce plat existe déjà !"]);

        Dish::create($credentials);
    }


    // supprimer un plat
    public function delete_dish(Request $request){
        $request->validate(['slug'=>'required']);
        $slug = $request->input('slug');

        $dish = Dish::where('slug', $slug)->first();

        try {
            $dish->delete();
            return response()->json(["message"=>"Plat supprimé !", "status"=>200]);
        } catch (\Throwable $th) {
            return response()->json(["message"=>"Une erreur est survenue !", "status"=>500]);
        }
    }
}
