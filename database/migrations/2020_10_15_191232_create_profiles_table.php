<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            /**this table needs to connect to our user, User has profile, profile belongs to user, 1-1 relationship */
            /**now to connect it we need to have column that stores reference to the id of user  */
            /**also its a foreign key that representws key in foreign table */
            $table->unsignedBigInteger('user_id');



            /**three fields below are nullable, user is not required to have them at all times*/
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            
            /**here we add another field image */
            $table->string('image')->nullable();

            $table->timestamps();

            /**next we add index for better searchability and quicker queries, also add index for any foreign keys you have  */

            $table->index('user_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}

/**next we migrate this so that we can add Profiles table to our database
 * 
 * php artisan migrate
 * 
 * alhough we have made connectin to user table, laravle needs to know how to work through it proprerly
 */