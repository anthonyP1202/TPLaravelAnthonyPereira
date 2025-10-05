<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;
use function Sodium\add;

class FavoriteController extends Controller
{
    public function FavoritesCount(){
        $meals = Meal::all();
        $mealsFavoriteCount = collect();
        foreach ($meals as $meal){
            $mealsFavoriteCount ->push(['meal'=>['id' => $meal->id , 'totalFavorite'=> $meal->favorites()->count()]]);
        }

        return response()->json(['meals'=>$mealsFavoriteCount]);
    }

    public function FavoritesPostCount($mealId)
    {
        $meal = Meal::findOrFail($mealId);
        $mealFavoriteCount = $meal->favorites()->count();
        return response()->json(['mealCount'=>$mealFavoriteCount]);
    }

    public function FavoriteUser($userId){
        $user = User::findOrFail($userId);
        $favorites = $user->favorites->all();
        return response()->json($favorites);
    }

    public function FavoriteUserPost($userId, $postId){ //should renaem you forgot what you did the next day
        $user = User::findOrFail($userId);
        $favorite = $user->favorites()->where('id', $postId)->first();
        return response()->json($favorite);
    }

    public function ChangeFavorite($postId){

        $user = User::findOrFail(Auth::user()->id);

        $favorite = Favorite::where('user_id', $user->id)->where('meal_id', $postId)->first();
        if ($favorite){
            $this->authorize('delete', $favorite);
            $user->favorites()->toggle($postId);
        } else {
            $user->favorites()->toggle($postId);
        }
    }
}
