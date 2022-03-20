<?php

use Phinx\Migration\AbstractMigration;

class CreateTransferTable extends AbstractMigration
{

    public function change()
    {
        $this->table("fund_transfers")
            ->addColumn("user_id", "integer")
            ->addColumn("amount", "float", ['precision' => 6, 'scale' => 2])
            ->addColumn("recipient_id", "integer")
            ->addColumn("mustbesentat", "datetime")
            ->addColumn("state", "enum", ["values" => ['pending', 'cancelled', 'accepted', 'refused']])
            ->addTimestamps()
            ->addForeignKey('user_id', "users", 'id', ['delete' => "CASCADE"])
            ->addForeignKey('recipient_id', "users", 'id', ['delete' => "CASCADE"])
            ->create();
    }
}
