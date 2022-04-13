<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monsters', function (Blueprint $table)
        {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->set('gender', ['male', 'female', 'non-binary']);
            $table->set('race', ['aberration', 'beast', 'dragon', 'elemental', 'undead', 'vampire', 'werewolf']);
            $table->set('size', ['small', 'medium', 'large']);
            $table->set('favorite_color', ['black', 'white', 'red', 'yellow', 'blue', 'orange', 'green', 'purple'])->nullable();
            $table->integer('life')->default(100);
            $table->integer('hunger')->default(0);
            $table->integer('energy')->default(100);
            $table->boolean('sleeping')->default(false);
            $table->boolean('dead')->default(false);
            $table->timestamp('fed_at')->nullable()->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monsters');
    }
};
