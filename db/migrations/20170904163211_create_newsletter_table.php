<?php


use Phinx\Migration\AbstractMigration;

class CreateNewsletterTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $newsletter = $this->table('newsletter_subscriptions');
        $newsletter->addColumn('email', 'string', array('limit' => 100))
              ->addColumn('subscribed', 'boolean', array('default' => true))
              ->addColumn('created', 'datetime')
              ->addColumn('updated', 'datetime', array('null' => true))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('newsletter_subscriptions');
    }
}
