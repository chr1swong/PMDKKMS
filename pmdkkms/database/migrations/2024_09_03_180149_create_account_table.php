<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account', function (Blueprint $table) {
            $table->increments('account_id');
            $table->string('account_full_name');
            $table->string('account_email_address')->unique();
            $table->string('account_contact_number');
            $table->string('account_password');
            $table->string('account_profile_picture_path'); // for profile picture
            $table->integer('account_role')->default(1)->comment('1 - archer, 2 - coach, 3 - committee_member');
            $table->integer('account_membership_status')->comment('1 - active, 2 - inactive');
            $table->date('account_membership_expiry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};
