<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealCreateRequest;
use App\Http\Requests\MealEditRequest;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class postController extends Controller
{
    public function Meals(){
        $posts = Meal::all();
        foreach($posts as $post){
            $post -> recipie = decrypt($post -> recipie);
        }
        //$likedPosts = User::findOrFail($userId)->meals()->get();
        return response()->json($posts);
    }

    public function Meal($id){
        $post = Meal::findOrFail($id);
        $post -> recipie = decrypt($post -> recipie);
        return response()->json($post);
    }

    public function Edit($id){
        $post = Meal::findOrFail($id);
        $post -> recipie = decrypt($post -> recipie);
        return view('meal.edit', ['post' => $post]);
    }

    public function DeleteMeal($id){
        $post = Meal::findOrFail($id);
        $post -> delete();
    }

    public function MealPost(MealCreateRequest $request){

        $validated = $request->validated();

        $filetype = $request->file('image')->getClientOriginalExtension();

        $encryptedRecipe = encrypt($request->input("recipie"));
        $post = new Meal();
        $post -> title = $request->input("title");
        $post -> recipie = $encryptedRecipe;
        $post -> user_id = $request->user()->id;
        $post -> image = "placeholder";
        $post -> save();

        $filename = $post ->id . "." . $filetype;

        $request->file('image')->storeAs('public/images', $filename);

        $post -> image = $filename;
        $post -> save();

        return redirect()->route('dashboard');
    }

    public function EditPost($id, MealEditRequest $request){

        $post = Meal :: find($id);
        if ($request->input("title") != null) {
            $post->title = $request->input("title");
        }

        if ($request->input("recipie") != null) {
            $encryptedRecipe = encrypt($request->input("recipie"));
            $post -> recipie = $encryptedRecipe;
        }

        if ($request->file('image') != null) {
            $filetype = $request->file('image')->getClientOriginalExtension();
            $filename = $post ->id . "." . $filetype;
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png',
            ]);
            $request->file('image')->storeAs('public/images', $filename);
            $post -> image = $filename;
        }

        $post -> save();

        return redirect()->route('dashboard');
    }
}
