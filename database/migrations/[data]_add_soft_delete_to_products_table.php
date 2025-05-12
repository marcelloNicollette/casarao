public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->softDeletes();
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
}