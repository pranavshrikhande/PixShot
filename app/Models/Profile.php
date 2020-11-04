<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    /**Here laravel will take care of creating that relationship and fetcging the user_id */
    /**now in create_profie_table.php 
     * we have user_id that matches to our Model>User.php
     * and also in this file we have method user so these are the naming convention we follow
     * 
     */

     //this is disabling mass asignment
     protected $guarded =[];
     
    public function profileImage(){
        $imagePath = ($this->image) ? $this->image : '/profile/JRgu0huth86NP2dRAC3wb7YCtoX1xbMVuFlqmkfZ.jpeg';
        return '/storage/' . $imagePath;
    }

    public function followers(){
        return $this->belongsToMany(User::class);
    }


    public function user(){
        return $this->belongsTo(User::class);
    }
}
/**now the above function will be able to fetch the user, however we want this in both directions,
 * 1) Profile that can fetch user
 * 2)User that can fetch profile
 */

 