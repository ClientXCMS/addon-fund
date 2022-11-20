<?php

use Phinx\Migration\AbstractMigration;

class CreateFundTransactionsTable extends AbstractMigration
{
    public function change()
    {
        $this->table("fund_transactions")
            ->addColumn("user_id", "integer")
            ->addColumn("amount", "float")
            ->addTimestamps()
            ->addForeignKey("user_id", "users", ['id'], ['delete' => 'CASCADE'])
            ->create();
    }
}
