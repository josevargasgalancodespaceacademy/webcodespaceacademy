<?php


use Phinx\Migration\AbstractMigration;

class CreateCompanyContactsTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $companyContacts = $this->table('company_contacts');
        $companyContacts->addColumn('name', 'string', array('limit' => 100))
              ->addColumn('email', 'string', array('limit' => 100))
              ->addColumn('telephone', 'string', array('limit' => 15))
              ->addColumn('company_name', 'string', array('limit' => 100))
              ->addColumn('company_link', 'string', array('limit' => 100, 'null' => true))
              ->addColumn('training_request', 'string', array('limit' => 10))
              ->addColumn('comment', 'text', array('null' => true))
              ->addColumn('created', 'datetime')
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('company_contacts');
    }
}
