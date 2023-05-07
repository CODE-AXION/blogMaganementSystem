<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','image','user_id'];

    //delete all the likes when the post is deleted

    protected static function boot() {
    
        parent::boot();
    
        static::deleting(function($post) {
            
            $post->likes()->delete();
        });
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * add like if user has not liked yet else remove like ,
     * you can even add a like besides the auth user by passing the user id in the paramater
     * 
     * we have also removed the else statement here and have used return , this is a technique called "Early Returns"  
     */

    public function like($user = null)
    {
        $existingLike = $this->likes()->where('user_id', $user ? $user->id : auth()->id())->first();

        if ($existingLike) {
            
            $existingLike->delete();

            return;
        }
        
        $this->likes()->create([
            'user_id' => $user ? $user->id : auth()->id(),
        ]);

        return;
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * i have created some scopes so we dont have to writing long queries in the controller,
     * this will make our controller clean and maintainable
     */
    
    public function scopeHasLikedByUser($query, $userId)
    {
        //get the posts with likes and give me the posts which has liked by auth user
        return $query->withCount('likes')
            ->whereHas('likes', function($query) use ($userId) {
                $query->where('user_id', $userId);
            });
    }

    //filter the posts according to the likes or latest posts
    public function scopeSortBy($query,$sortBy = null){

        switch ($sortBy) {
            case 'most-liked':
                
                return $query->orderByDesc('likes_count');

            break;

            case 'latest':
                
                return $query->latest();
               
            break;

            default:
       
                return $query;
            
            break;
        }
    }

    //search posts with title or description
    public function scopeSearch($query,$q)
    {
        $query->when(isset($q), function($query) use($q)
        {
            $query->where('name','like','%' . $q . '%')
            ->orWhere('description', 'like', '%' . $q . '%');
        });
    }
}
