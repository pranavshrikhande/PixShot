<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

use App\Models\User;
use Barryvdh\Debugbar\Facade as Debugbar;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        
        Debugbar::startMeasure('render','Time for renderting');
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

       
        $postCount = Cache::remember(
            'counts.posts.'. $user->id,
            now()->addSeconds(30),
            function() use($user){
                return $user->posts->count();
            }
        );
        
        
        $user->posts->count();

        $followersCount = Cache::remember(
            'counts.follwers.'. $user->id,
            now()->addSeconds(30),
            function() use($user){
                return $user->profile->followers->count();
            }
        );
              
        
        

        $followingCount = Cache::remember(
            'counts.following.'. $user->id,
            now()->addSeconds(30),
            function() use($user){
                return $user->following->count() ;
            }
        );
        
        
        
        
        
        
        //$user = (User::findOrFail($user));
        
        /**next we passthis onto the view
         * user is going to be the varible inside home.blade.php
         */
        Debugbar::stopMeasure('render');
        

        return view('profiles.index', compact('user','follows','postCount','followersCount','followingCount'));
    }


/*abvoe method we got user  by $user = (User::findOrFail($user));, below we use different method to grab user
As we are already importing App\Models\User we dont need to use that else we write function as function edit (App\User $user)
*/
    public function edit(User $user){

        //Here we authorise the action

        $this->authorize('update', $user->profile);// Now this edit is now protected

        return view('profiles.edit',compact('user'));
    }


    public function update(User $user){
        //Here we need to do the validation\


        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description'=> 'required',
            'url' => 'url',
            'image' => '',
        ]);

        //We are passing user but that is exposed in url i.e 127.0.0.1/edit/1 <-- here is the user
        
            if(request('image')){
                $imagePath = request('image')->store('profile','public');

                $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000,1000);

                $image->save();
        
                $imageArray = ['image' => $imagePath];
            }

        /*Now inside the $data we need to change the 'image' that we are sending in , so we do is array_merge() a function in php that takes any number of arrays and then
        it appends them together, so here
        first we pass $data array and next we pass another array with the key of image that will overwrite whatever was in the key of image in our orignal one
        
        */ 

        // here we are making sure another level of validation where we are making sure to authorize, only if image is present then overwrite esle we pass an empty array else it breaks the code
        
        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));
        /**this data array does have a key of  image, second array overrides that image */

        return redirect("/profile/{$user->id}");

        //dd($data);
    }

}
