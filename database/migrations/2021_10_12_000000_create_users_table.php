<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private string $tableName = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('phone');
            $table->string('password');
            $table->boolean('is_active')->default(false);
            $table->boolean('phone_confirmed')->default(false);
            $table->dateTime('phone_confirmed_at')->nullable();
            $table->date('birthday')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users');
            $table->softDeletes();
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
        Schema::dropIfExists($this->tableName);
    }
};
