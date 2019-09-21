<?php

use Phinx\Migration\AbstractMigration;

class UpdateUser extends AbstractMigration
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
        $user_table = $this->table('users');
        $session_table = $this->table('sessions',['id' => 'session_id']);

        $user_table->addColumn('password','string',['limit' =>  256])
                ->update();
        $session_table->addColumn('user_id', 'integer',['null' => false])
                ->addColumn('session_cookie','char',['limit' => 32])
                ->addIndex(['session_cookie'],['unique' => true])
                ->addTimestampsWithTimezone(null,'session_start')
                ->create();
                
    }
}
