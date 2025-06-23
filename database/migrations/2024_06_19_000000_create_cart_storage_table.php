<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_storage', function (Blueprint $table) {
            $table->string('identifier');
            $table->string('instance');
            $table->longText('content');
            $table->timestamps();
            
            $table->primary(['identifier', 'instance']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cart_storage');
    }
};