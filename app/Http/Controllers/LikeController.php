<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Product $product)
    {
        $user = Auth::user();

        // ログインしているかチェック
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $like = Like::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $liked = true;
        }

        return response()->json(['liked' => $liked]);
    }
}