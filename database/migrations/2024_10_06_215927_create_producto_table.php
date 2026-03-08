<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id('prod_id'); // id autoincremental
            $table->string('prod_nombre'); // nombre del producto
            $table->text('prod_descripcion'); // descripción del producto
            $table->string('prod_codigo', 15)->unique(); // código de barras (máximo 13 caracteres)
            $table->integer('prod_cantidad'); // cantidad en stock
            $table->decimal('prod_precio', 10, 2); // precio con hasta 10 dígitos y 2 decimales
            $table->unsignedBigInteger('prod_categoria'); // campo para la clave foránea
            // Definir la clave foránea de manera explícita
            $table->foreign('prod_categoria', 'fk_productos_categoria')
                  ->references('cat_id')->on('categoria')
                  ->onDelete('cascade'); // Elimina productos si se elimina la categoría
            $table->timestamps(); // Campos created_at y updated_at
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
