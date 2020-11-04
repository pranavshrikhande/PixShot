<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\ Post;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index(){

        /*the entire controller  is under midleware  of auth so we are going to have an autheticated user, we have to get all post of all people we are following an puth that in reverse chronological order*/
        /** we are following profiles, but all posts are associated with user and not profiles
         * 
         * so we grab all the users first
         */
        $users = auth()->user()->following()->pluck('profiles.user_id'); //now we have collection of user id

        //Use that post  where the user_id is in list of users that we grabbed above and get everything

        /**Now for pagination we change the below query from get() to paginate() */

        /**Again we change this query to solve n+1 problem by addin with(user) this is talking about relationship its going to Models/Post.php and takes     user() and loads it */
        $posts = Post::whereIn('user_id',$users)->with('user')->latest()->paginate(5);
        //dd($posts);


        return view ('posts.index',compact('posts'));

    }

    public function create()
    {
        return view('posts.create');
    }
   

        


    /*also we need to validate our data so*/
public function store(){
    
    $data = request()-> validate([
        'caption'=>'required',
        'image'=>['required','image'],
    ]);

    
        /**we set request image to store and move to relative path 
         * if we put / it wil store in root folder, here we save in uploads directory
         * second argument pass is driver, here we can give s3 for amazon cloud as well
         * now we give public because of local storage 
         * 
         * 
         * now as soon as we upload image we see new directory has been created in Storage/app/public/uploads
         * 
         * however this public is not accessible to others
         * 
         * so we need to make sure laravel to access this image hits the path 127.0.0.0:8000/uploads/crbSIZeioRKfFmA9Q3O86pPbtG4uT0IRBTrW7WGU.jpeg
         * again it fails, so we need laravel to link to the files that are in storage
         * 
         * so there is an artisan command, that you can only run once in the life time of a project
         *  php artisan storage:link
        */

        //below line returns our file path
       $imagePath =request('image')->store('uploads','public');


             /**Intervention image for automatic resizing */

       /**make() will wrap image file around interventin class so we can manipulate it
        * it will take image from path and fit pixels 1200 x 1200

        this is diferent from resizing as it will change physical dimensions of the image proportionally. here we cut any escess that it has and fit in 1200x1200 square image
        */
       $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200)->save();


//Now we just dont pass in data 

    /**how to use authenticated user */
    auth()->user()->posts()->create([
        'caption'=> $data['caption'],
        'image'=> $imagePath,
    ]);


    

    /**in tinker we did $post = new \App..... made instance and then saved it,
     * here we do it using create method
     */
    return redirect('/profile/' . auth()->user()->id);

}


 /*below code is the show, as we hover over the image it will direct to imdividual path of image */
/**this will take post as argument as we required post_id */
 



public function show(\App\Models\Post $post){
   /**here whatever we pass in url as query parameter., it will be posted, nothing special  */
   /**Also to pass data from our controller to html we can use array as second argument or else we can use compact function,
    * in compact function you can pass as many strings as you need
     */
    return view('posts.show',compact('post'));
        
    }

}
