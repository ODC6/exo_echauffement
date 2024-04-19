<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('_l_o_g', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('action');
            $table->json('data');
            $table->timestamps();
        });


        DB::statement("
            CREATE TRIGGER after_update_category
            AFTER UPDATE ON category
            FOR EACH ROW
            BEGIN
                DECLARE json_data JSON;

                SET json_data = JSON_OBJECT(
                    'old', JSON_OBJECT('category_name', OLD.category_name),
                    'new', JSON_OBJECT('category_name', NEW.category_name)
                );

                INSERT INTO _l_o_g (table_name, action, data)
                VALUES ('dish', 'update', json_data);
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_l_o_g');
    }
};
