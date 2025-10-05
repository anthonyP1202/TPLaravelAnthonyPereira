<?php

namespace App\Http\Controllers;

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

    public function FavoriteUserPost($userId, $postId){
        $user = User::findOrFail($userId);
        $favorite = $user->favorites()->where('id', $postId)->first();
        return response()->json($favorite);
    }

    public function ChangeFavorite($userId, $postId){
        $user = User::findOrFail($userId);
        $user->favorites()->toggle($postId);
    }
}
