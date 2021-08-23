<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class,'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    
    public function followers()
    {
        return $this->hasMany(Follow::class, 'user_id')->where('follow','=','1');
    }

    public function fol()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }
    
    public function followings()
    {
        return $this->hasMany(Follow::class, 'following_id')->where('follow','=','1');
    }

    public function follow($user = null, $follow=true)
    {
        $this->fol()->updateOrCreate([
            'following_id' => $user ? $user->id : auth()->id()
        ],[
            'follow' => $follow
        ]);
    }

    public function unfollow($user = null)
    {
        $this->follow($user, false);
    }

    public function isFollowedBy(User $user)
    {
        return (bool)  $user->fol
            ->where('following_id', $this->id)
            ->where('follow', true)
            ->count();
    }


}
