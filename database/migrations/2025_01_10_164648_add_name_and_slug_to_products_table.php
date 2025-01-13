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
    Schema::table('products', function (Blueprint $table) {
        $table->string('name')->after('id_brand'); // Menambahkan kolom 'name' setelah 'id_brand'
        $table->string('slug')->after('name');    // Menambahkan kolom 'slug' setelah 'name'
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['name', 'slug']); // Menghapus kolom jika migrasi di-rollback
    });
}

};
