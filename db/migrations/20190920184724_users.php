<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Users extends AbstractMigration
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
        $users_table = $this->table('users');
        $student_table = $this->table('student');
        $employer_table = $this->table('employer');

        $users_table->addColumn('username','string',['limit' => 50])
                ->addColumn('role','string', ['limit' => 30])
                ->create();
        $student_table->addColumn('user_id','integer',['null' => false])
                    ->addForeignKey('user_id','users','id',['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
                    ->addColumn('school','string',['limit' => 100])
                    ->addColumn('resume', 'blob', ['limit' => MysqlAdapter::BLOB_MEDIUM])
                    ->create();
        $employer_table->addColumn('user_id','integer',['null' => false])
                    ->addForeignKey('user_id','users','id',['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
                    ->addColumn('name', 'string',['limit' => 50])
                    ->addColumn('about','text',['limit' => MysqlAdapter::TEXT_LONG])
                    ->create();
    }
}
