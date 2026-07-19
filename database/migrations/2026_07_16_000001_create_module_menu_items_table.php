<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleMenuItemsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('module_menu_items')) {
            return;
        }

        Schema::create('module_menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('module_key', 64);
            $table->string('item_key', 100)->unique();
            $table->string('route_name', 150);
            $table->json('route_params')->nullable();
            $table->string('label_en');
            $table->string('label_ar');
            $table->string('icon_class')->nullable();
            $table->json('app_types')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['module_key', 'is_active', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('clinic_module_menu_items');
    }
}
