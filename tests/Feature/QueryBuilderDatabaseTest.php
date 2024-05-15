<?php

namespace Tests\Feature;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class QueryBuilderDatabaseTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    //  sengaja dikomentar biar gak nambah
    // public function testQueryBuilderInsert(): void
    // {
    //     DB::table('categories')->insert([
    //         'id' => 'MOVIE',
    //         'name' => 'movie'
    //     ]);
    //     DB::table('categories')->insert([
    //         'id' => 'KOREAN-DRAMA',
    //         'name' => 'Korean Drama'
    //     ]);
    //     $result = DB::select('SELECT COUNT(id)as total FROM categories');

    //     self::assertEquals(2, $result[0]->total);
    // }

    public function testQueryBuilderSelect()
    {
        $collection = DB::table('categories')->select(["id", "name"])->get();

        $collection->each(function ($record) {
            Log::info(json_encode($record));
        });
    }

    public function testQueryBuilderWhere()
    {
        $collection = DB::table('categories')->orWhere(function (Builder $builder) {
            $builder->where('id', '=', 'KOREAN-DRAMA');
            $builder->orWhere('id', '=', 'MOVIE');
        })->get();

        self::assertCount(2, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
    }

    // public function testQueryBuilderWhereBetween()
    // {
    //     $collection = DB::table('categories')->whereBetween('create_at', ['2024-05-14 00:00:00', '2024-05-14 21:21:00'])->get();

    //     self::assertCount(2, $collection);
    //     for ($i = 0; $i < count($collection); $i++) {
    //         Log::info(json_encode($collection[$i]));
    //     }
    // }

    public function testQueryBuilderWhereIn()
    {
        $collection = DB::table('categories')->whereIn('id', ['KOREAN-DRAMA', 'MOVIE'])->get();

        self::assertCount(2, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
    }
    // public function testQueryBuilderWhereNull()
    // {
    //     $collection = DB::table('categories')->whereNull('description')->get();

    //     self::assertCount(2, $collection);
    //     for ($i = 0; $i < count($collection); $i++) {
    //         Log::info(json_encode($collection[$i]));
    //     }
    // }
    // public function testQueryBuilderWhereDate()
    // {
    //     $collection = DB::table('categories')->whereDate('create_at', '2024-05-14')->get();

    //     self::assertCount(2, $collection);
    //     for ($i = 0; $i < count($collection); $i++) {
    //         Log::info(json_encode($collection[$i]));
    //     }
    // }
    public function testQueryBuilderUpdate()
    {
        DB::table('categories')->where('id', '=', 'KOREAN-DRAMA')->update([
            'name' => 'KDrama',
        ]);
        $collection = DB::table('categories')->where('name', '=', 'KDrama')->get();

        self::assertCount(1, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
    }
    public function testQueryBuilderUpdateOrInsert()
    {
        DB::table('categories')->updateOrInsert([
            'id' => 'KOREAN-VARIETY'
        ], [
            'name' => 'Korean Variety',
            'description' => 'Variety Show In Korea',
            'create_at' => '2024-05-14 13:00:00'
        ]);
        $collection = DB::table('categories')->where('id', '=', 'KOREAN-VARIETY')->get();

        self::assertCount(1, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            Log::info(json_encode($collection[$i]));
        }
    }
    public function testQueryBuilderDelete()
    {
        DB::table('categories')->where('id', '=', 'KOREAN-VARIETY')->delete();
        $collection = DB::table('categories')->where('id', '=', 'KOREAN-VARIETY')->get();

        self::assertCount(0, $collection);
    }

    // public function InsertTableMovies(): void
    // {
    //     DB::table('movies')->insert([
    //         'id' => '1',
    //         'title' => 'Exhuma',
    //         'category_id' => 'MOVIE',
    //         'price' => '40000'
    //     ]);
    //     DB::table('movies')->insert([
    //         'id' => '2',
    //         'title' => 'Siksa Kubur',
    //         'category_id' => 'MOVIE',
    //         'price' => '45000'
    //     ]);
    // }

    // public function testQueryBuilderJoin()
    // {
    //     $collection = DB::table('movies')
    //         ->join('categories', 'movies.category_id', '=', 'categories.id')
    //         ->select('movies.id', 'movies.title', 'categories.name as category_name', 'movies.price')->get();

    //     self::assertCount(2, $collection);
    //     for ($i = 0; $i < count($collection); $i++) {
    //         Log::info(json_encode($collection[$i]));
    //     }
    // }
    // public function testQueryBuilderOrdering()
    // {
    //     $collection = DB::table('movies')
    //         ->orderBy('price', 'desc')
    //         ->orderBy('title', 'asc')
    //         ->get();

    //     self::assertCount(2, $collection);
    //     for ($i = 0; $i < count($collection); $i++) {
    //         Log::info(json_encode($collection[$i]));
    //     }
    // }
    // public function testQueryBuilderTakeSkip()
    // {
    //     $collection = DB::table('categories')
    //         ->skip(2)
    //         ->take(2)
    //         ->get();

    //     self::assertCount(0, $collection);
    //     for ($i = 0; $i < count($collection); $i++) {
    //         Log::info(json_encode($collection[$i]));
    //     }
    // }
    public function testQueryBuilderChunkResults()
    {
        DB::table('categories')
            ->orderBy("id")
            ->chunk(1, function ($categories) {
                self::assertNotNull($categories);
                foreach ($categories as $category) {
                    Log::info(json_encode($category));
                }
            });
    }
    public function testQueryBuilderLazyResults()
    {
        DB::table('categories')
            ->orderBy("id")
            ->cursor() // memori < lazy(1)
            ->each(function ($category) {
                self::assertNotNull($category);
                Log::info(json_encode($category));
            });
    }
    // public function testQueryBuilderAggregate()
    // {
    //     $collection = DB::table("movies")
    //         ->count("id");
    //     self::assertEquals(2, $collection);

    //     $collection = DB::table("movies")
    //         ->max("price");
    //     self::assertEquals(45000, $collection);

    //     $collection = DB::table("movies")
    //         ->min("price");
    //     self::assertEquals(40000, $collection);

    //     $collection = DB::table("movies")
    //         ->avg("price");
    //     self::assertEquals(42500, $collection);

    //     $collection = DB::table("movies")
    //         ->sum("price");
    //     self::assertEquals(85000, $collection);
    // }
    // public function testQueryBuilderRawAggregate()
    // {
    //     $collection = DB::table("movies")
    //         ->select(
    //             DB::raw('count(*) as total_product'),
    //             DB::raw('min(price) as min_price'),
    //             DB::raw('max(price) as max_price'),
    //         )->get();
    //     self::assertEquals(2, $collection[0]->total_product);
    //     self::assertEquals(50000, $collection[0]->min_price);
    //     self::assertEquals(45000, $collection[0]->max_price);
    // }

    // public function InsertTableMovies(): void
    // {
    //     DB::table('movies')->insert([
    //         'id' => '3',
    //         'title' => 'Queen of Tears',
    //         'category_id' => 'KOREAN-DRAMA',
    //         'price' => '50000'
    //     ]);
    //     DB::table('movies')->insert([
    //         'id' => '4',
    //         'title' => 'Parasyte: The Grey',
    //         'category_id' => 'KOREAN-DRAMA',
    //         'price' => '50000'
    //     ]);
    // }

    // public function testQueryBuilderGrouping()
    // {
    //     $collection = DB::table("movies")
    //         ->select(
    //             'category_id',
    //             DB::raw('count(*) as total_product')
    //         )->groupBy('category_id')
    //         ->orderBy('category_id', 'desc')
    //         ->get();
    //     self::assertCount(2, $collection);
    //     self::assertEquals('MOVIE', $collection[0]->category_id);
    //     self::assertEquals('KOREAN-DRAMA', $collection[1]->category_id);
    //     self::assertEquals(2, $collection[0]->total_product);
    //     self::assertEquals(2, $collection[1]->total_product);
    // }
    public function testQueryBuilderHaving()
    {
        $collection = DB::table("movies")
            ->select(
                'category_id',
                DB::raw('count(*) as total_product')
            )
            ->groupBy('category_id')
            ->orderBy('category_id', 'desc')
            ->having(DB::raw('count(*)'), '>', 2)
            ->get();
        self::assertCount(0, $collection);
    }
    // public function testQueryBuilderLocking()
    // {
    //     DB::transaction(function () {
    //         $collection = DB::table('movies')
    //             ->where('id', '=', '1')
    //             ->lockForUpdate()
    //             ->get();
    //         self::assertCount(1, $collection);
    //     });
    // }
    // public function testQueryBuilderPagination()
    // {
    //     $paginate = DB::table('movies')->paginate(perPage: 2);
    //     self::assertEquals(1, $paginate->currentPage()); // current Page
    //     self::assertEquals(2, $paginate->perPage()); // items per Page
    //     self::assertEquals(2, $paginate->lastPage()); // last Page
    //     self::assertEquals(4, $paginate->total()); // Total items

    //     $collection = $paginate->items();
    //     self::assertCount(2, $collection);
    //     foreach ($collection as $item) {
    //         Log::info(json_encode($item)); // toObject
    //     }
    // }
    public function testQueryBuilderIterationPerPage()
    {
        $page = 1;
        while (true) {
            $paginate = DB::table('movies')->paginate(perPage: 2, page: $page);
            if ($paginate->isEmpty()) {
                break;
            } else {
                $page++;
                foreach ($paginate->items() as $item) {
                    self::assertNotNull($item);
                    Log::info(json_encode($item)); // toObject
                }
            }
        }
    }
    public function testQueryBuilderCursorPagination()
    {
        $cursor = "id";
        while (true) {
            $paginate = DB::table('categories')
                ->orderBy("id")
                ->cursorPaginate(perPage: 2, cursor: $cursor);
            foreach ($paginate->items() as $item) {
                self::assertNotNull($item);
                Log::info(json_encode($item)); // toObject
            }

            $cursor = $paginate->nextCursor();
            if ($cursor == null) {
                break;
            }
        }
    }
}
