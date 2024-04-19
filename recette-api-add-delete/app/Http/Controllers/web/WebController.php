<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;

class WebController extends Controller
{
    //

    public function index()
    {
        return view('index');
    }

    public function category()
    {
        return view('categories');
    }

    public function dish()
    {
        $categories = Category::all();
        return view('plats', ['categories' => $categories]);
    }

    public function reviews(){
        return view('reviews');
    }


    private function validateDataRequest(Request $request){
        return $request->validate([
            'dish_name' => 'required',
            'slug'=>'required',
            'dish_ingredient' => 'required',
            'dish_recette' => 'required',
            'preparation' => 'required',
            'cuissons' => 'required',
            'temps_total' => 'required',
            'id_category' => 'required'
        ]);
    }

    // enregistrer & modifier
    public function save_dish(Request $request){
        $credentials = $this->validateDataRequest($request);

        $is_exist = Dish::where('slug', $credentials['slug'])->first();

        if($is_exist) return response()->json(["message"=>"Ce plat existe déjà !"]);

        Dish::create($credentials);

        return back()->with('successMessage', 'Plat enregistré !');
    }


    public function update_dish(Request $request, $id){
        $credentials = $this->validateDataRequest($request);

        $is_exist = Dish::findOrFail($id);

        $is_exist->update($credentials);
        
        return back()->with('successMessage', 'Plat enregistré !');
    }
}
