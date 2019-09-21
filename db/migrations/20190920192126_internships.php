<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Internships extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('internships');
        $table->addForeignKey('id','employer','id',['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('id','student','id',['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addColumn('name','string',['limit' => 50])
            ->addColumn('description','text',['limit' => MysqlAdapter::TEXT_LONG])
            ->create();
    }
}
