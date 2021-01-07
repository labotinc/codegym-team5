<?php

use Migrations\AbstractMigration;

class CreatePointRates extends AbstractMigration
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
        $table = $this->table('point_rates');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('point_rate', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 6,
            'scale' => 3,
        ]);
        $table->addColumn('started_at', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('finished_at', 'datetime', [
            'default' => null,
            'null' => true,
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
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
