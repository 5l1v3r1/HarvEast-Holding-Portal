<?php

use App\Poll;
use App\Option;
use App\Article;
use App\Document;
use App\BidCategory;
use App\DocumentCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CityTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(ArticleTagsTableSeeder::class);
        $this->call(UsersTableSeeder::class);        
        $this->call(OtherTablesSeeder::class);
        // $this->call(VoyagerDummyDatabase::class);
        $this->call(VoyagerDatabaseSeeder::class);

    }
}
