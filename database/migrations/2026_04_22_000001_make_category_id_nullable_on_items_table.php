<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE items DROP FOREIGN KEY items_category_id_foreign');
        DB::statement('ALTER TABLE items MODIFY category_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE items ADD CONSTRAINT items_category_id_foreign FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE items DROP FOREIGN KEY items_category_id_foreign');
        DB::statement('ALTER TABLE items MODIFY category_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE items ADD CONSTRAINT items_category_id_foreign FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE');
    }
};
