<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;


class StudentApplication extends AbstractMigration
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
        $table = $this->table('student_applications');

        $table->addColumn('student_id','integer',['null' => false])
            ->addColumn('internship_id', 'integer', ['null' => false])
            ->addForeignKey('student_id', 'student', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addColumn('time_of_availablity', 'integer')
            ->addColumn('internship_specific', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM, 'null' => true])
            ->addColumn('student_resume', 'blob', ['limit' => MysqlAdapter::BLOB_LONG])
            ->create();
    }
}
