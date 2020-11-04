@extends('layouts.app')

@section('content')
<div class="container">
<!-- here inside action we are doing a PUT/PATCH method as we are editing the username, based on id
PUT is used for inserting
PATCH is used for updating that means the data already present or inserted, we modify the data using Patch, where as if we use PUT, it will insert whole new fields of data
 Also we need to trick the browser as there is no PUT/Patch or delete
!-->
<form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">
    @csrf
    <!--So now using one the directives using blade methods we use annotation for patch!-->
    @method('PATCH')
    <!--nOW WE DONT have this route yet so we create that isn web.php!-->
        <div class="col-8 offset-2">
            <div class="row">
            <h1>Edit Profile</h1>
            </div>

            <div class="form-group row">

                

                <label for="title" class="col-md-4 col-form-label ">Title</label>


                <input id="title" 
                type="text" 
                class="form-control{{ $errors->has('caption') ? ' is-invalid' : '' }}"
                name= "title"
                value="{{old('title') ?? $user->profile->title }}" 
                autocomplete="title" autofocus>

                @if($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{$errors->first('title')}}</strong>

                </span>

                @endif
            </div>


        <!----------------------------------------------------------------------------------------------!-->

        <div class="form-group row">
           <label for="description" class="col-md-4 col-form-label ">Description</label>
            
            <input id="description" 
            type="text" 
            class="form-control{{ $errors->has('caption') ? ' is-invalid' : '' }}"
            name= "description"
            value="{{old('description') ?? $user->profile->description }}" 
            autocomplete="description" autofocus>

            @if($errors->has('description'))
            <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('description')}}</strong>

                </span>

                @endif
        </div>

        <!----------------------------------------------------------------------------------------------!-->

        <div class="form-group row">
           <label for="url" class="col-md-4 col-form-label ">URL</label>
            
            <input id="url" 
            type="text" 
            class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}"
            name= "url"
            value="{{old('url') ?? $user->profile->url }}" 
            autocomplete="url" autofocus>

            @if($errors->has('url'))
            <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('url')}}</strong>

                </span>

                @endif
        </div>


        <!----------------------------------------------------------------------------------------------!-->








            <div class="row">
                <label for="image" class="col-md-4 col-form-label ">Profile Image</label>
                <input type="file" class="form-control-file" id="image" name="image">

                @if($errors->has('image'))
                
                    <strong>{{$errors->first('image')}}</strong>

               

                @endif

            </div>


            <div class="row pt-4">
                <button class="btn btn-primary">Save Profile</button>
            </div>






        </div>
</div>


</form>

</div>

@endsection