<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthClientAccessToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('admin')->create('external_oauth_access_token', function (Blueprint $table) {
            $table->id();
            $table->string('access_token', 100)->comment('');
            $table->string('refresh_token', 100)->comment('刷新token');
            $table->dateTime('refresh_token_expires_at')->comment('过期时间');
            $table->dateTime('access_token_expires_at')->comment('过期时间');
            $table->text('scopes')->comment('范围');
            $table->integer('modal_id', false, true)->nullable(false)->default(0)->index()->comment('关联ID');
            $table->string('modal_type', 100)->nullable(false)->default('')->comment('关联类型');
            $table->index(['modal_type', 'modal_id']);
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
        Schema::connection('admin')->dropIfExists('external_oauth_access_token');
    }
}
