<?php


use Phinx\Migration\AbstractMigration;

class CreatePromotionEntriesTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $promotionEntries = $this->table('promotion_entries');
        $promotionEntries->addColumn('name', 'string', array('limit' => 100))
              ->addColumn('surnames', 'string', array('limit' => 100))
              ->addColumn('date_of_birth', 'date')
              ->addColumn('email', 'string', array('limit' => 100))
              ->addColumn('type_identification', 'string', array('limit' => 10))
              ->addColumn('number_identification', 'string', array('limit' => 15))
              ->addColumn('telephone', 'string', array('limit' => 15))
              ->addColumn('city', 'string', array('limit' => 100))
              ->addColumn('comment', 'text', array('null' => true))
              ->addColumn('linkedin', 'string', array('limit' => 100, 'null' => true))
              ->addColumn('created', 'datetime')
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('promotion_entries');
    }
}
