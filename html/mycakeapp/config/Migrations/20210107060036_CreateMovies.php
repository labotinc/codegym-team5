<?php

use Migrations\AbstractMigration;

class CreateMovies extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('movies');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 1000,
            'null' => false,
        ]);
        $table->addColumn('screening_time', 'integer', [
            'default' => null,
            'limit' => 3,
            'null' => false,
        ]);
        $table->addColumn('picture_name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('top_picuture_name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
        ]);
        $table->addColumn('started_at', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('finished_at', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('is_deleted', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('created_at', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('updated_at', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);
        $table->create();
    }
}
