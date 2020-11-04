<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;




class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        
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


    protected static function boot()
    {
        parent::boot();//this method is called when booting up model



        static::created(function ($user){

            $user->profile()->create([
                'title'=> $user->username, //this way user will have one thing in its profile and wont be blank  
            ]);

        }); //created becomes an event, this gets fired whenever a new user gets created, we want as soon as user is created we want profile to be created inside created(), its going to take a closure
    }


    /**when you have has many relationship we have plural so posts instead of post */
    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at','DESC');

    }

    public function following(){
        
        return $this->belongsToMany(Profile::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }
}

/**here in profile we did not need to use /app/Profile namespace as we already have declared
 * namespace App/Model and Profile is in same directory
 */
