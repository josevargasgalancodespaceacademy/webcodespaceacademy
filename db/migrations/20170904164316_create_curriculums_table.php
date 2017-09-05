<?php


use Phinx\Migration\AbstractMigration;

class CreateCurriculumsTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $curriculums = $this->table('curriculums');
        $curriculums->addColumn('name', 'string', array('limit' => 100))
              ->addColumn('email', 'string', array('limit' => 100))
              ->addColumn('telephone', 'string', array('limit' => 15))
              ->addColumn('website', 'string', array('limit' => 100 , 'null' => true))
              ->addColumn('linkedin', 'string', array('limit' => 100, 'null' => true))
              ->addColumn('route_curriculum_pdf', 'string', array('limit' => 100))
              ->addColumn('created', 'datetime')
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('curriculums');
    }
}
