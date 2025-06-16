<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class InitialSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $this->seedPages();
        $this->seedSections();
    }

    private function seedPages(): void
    {
        $pagesData = json_decode(file_get_contents(__DIR__ . '/data/pages.json'), true);
        $pagesTable = $this->table('pages');

        // To prevent duplicates on re-seed
        $pagesTable->truncate();

        $dataToInsert = [];
        foreach ($pagesData as $page) {
            $dataToInsert[] = [
                'name' => $page['name'],
                'title' => $page['title'],
                'description' => $page['description'],
                'keywords' => $page['keywords'],
                'h1' => $page['h1'],
                'schema_type' => $page['schema']['type'] ?? null,
                'schema_category' => $page['schema']['category'] ?? null,
                'schema_address' => isset($page['schema']['address']) ? json_encode($page['schema']['address']) : null,
                'schema_same_as' => isset($page['schema']['sameAs']) ? json_encode($page['schema']['sameAs']) : null,
                'noindex' => $page['noindex'] ?? false,
            ];
        }

        $pagesTable->insert($dataToInsert)->saveData();
    }

    private function seedSections(): void
    {
        $sectionsData = json_decode(file_get_contents(__DIR__ . '/data/sections.json'), true);
        $sectionsTable = $this->table('sections');
        $sectionsTable->truncate();

        $dataToInsert = [];
        foreach ($sectionsData as $name => $content) {
            $dataToInsert[] = [
                'name' => $name,
                'content' => json_encode($content)
            ];
        }

        $sectionsTable->insert($dataToInsert)->saveData();
    }
}