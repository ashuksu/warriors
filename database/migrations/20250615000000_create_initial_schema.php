<?php

use Phinx\Migration\AbstractMigration;

class CreateInitialSchema extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        // Create 'pages' table
        $pages = $this->table('pages');
        $pages->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('keywords', 'text', ['null' => true])
            ->addColumn('h1', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('schema_type', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('schema_category', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('schema_address', 'jsonb', ['null' => true])
            ->addColumn('schema_same_as', 'jsonb', ['null' => true])
            ->addColumn('noindex', 'boolean', ['default' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['name'], ['unique' => true, 'name' => 'idx_pages_name'])
            ->create();

        // Create 'sections' table
        $sections = $this->table('sections');
        $sections->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('content', 'jsonb', ['null' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['name'], ['unique' => true, 'name' => 'idx_sections_name'])
            ->create();
    }
}