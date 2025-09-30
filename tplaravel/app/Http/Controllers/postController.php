<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class postController extends Controller
{
    public function meals(){
        $posts = Meal::all();
        foreach($posts as $post){
            $post -> recipie = decrypt($post -> recipie);
        }
        //$likedPosts = User::findOrFail($userId)->meals()->get();
        return response()->json($posts);
    }

    public function meal($id){
        $post = Meal::find($id);
        $post -> recipie = decrypt($post -> recipie);
        return response()->json($post);
    }

    public function mealPost(Request $request){

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ]);
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
}
