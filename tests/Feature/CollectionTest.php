<?php

namespace Tests\Feature;

use App\Data\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\LazyCollection;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertEqualsCanonicalizing;

class CollectionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateCollection(): void
    {
        $collection = collect([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $collection->all());
    }

    public function testForEach()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        foreach ($collection as $key => $value) {
            self::assertEquals($key + 1, $value);
        }
    }

    public function testCrud()
    {
        $collection = collect([]);
        $collection->push(1, 2, 3);
        assertEqualsCanonicalizing([1, 2, 3], $collection->all());

        $result = $collection->pop();
        assertEquals(3, $result);
        assertEqualsCanonicalizing([1, 2], $collection->all());
    }

    public function testMap()
    {
        $collection = collect([1, 2, 3]);
        $result = $collection->map(function ($item) {
            return $item * 2;
        });
        $this->assertEquals([2, 4, 6], $result->all());
    }

    public function testMapInto()
    {
        $collection = collect(["Exhuma"]);
        $result = $collection->mapInto(Film::class);
        $this->assertEquals([new Film("Exhuma")], $result->all());
    }

    public function testMapSpread()
    {
        $collection = collect([["Godzilla X Kong", "The New Empire"], ["Ghostbusters", "Frozen Empire"]]);
        $result = $collection->mapSpread(function ($firstTitle, $lastTitle) {
            $fullTitle = $firstTitle . ": " . $lastTitle;
            return new Film($fullTitle);
        });
        assertEquals([
            new Film("Godzilla X Kong: The New Empire"),
            new Film("Ghostbusters: Frozen Empire")
        ], $result->all());
    }

    public function testMapToGroups()
    {
        $collection = collect([
            [
                "title" => "Exhuma",
                "type" => "Film"
            ],
            [
                "title" => "Siksa Kubur",
                "type" => "Film"
            ],
            [
                "title" => "Hangout with Yoo",
                "type" => "Variety Show"
            ]
        ]);
        $result = $collection->mapToGroups(function ($item) {
            return [$item["type"] => $item["title"]];
        });
        assertEquals([
            "Film" => collect(["Exhuma", "Siksa Kubur"]),
            "Variety Show" => collect(["Hangout with Yoo"])
        ], $result->all());
    }

    public function testZip()
    {
        $collection = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $collection3 = $collection->zip($collection2);

        assertEquals([
            collect([1, 4]),
            collect([2, 5]),
            collect([3, 6]),
        ], $collection3->all());
    }
    public function testConcat()
    {
        $collection = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $collection3 = $collection->concat($collection2);

        assertEquals([1, 2, 3, 4, 5, 6], $collection3->all());
    }

    public function testCombine()
    {
        $collection = ["title", "country"];
        $collection2 = ["Exhuma", "South Korea"];
        $collection3 = collect($collection)->combine($collection2);

        assertEquals([
            "title" => "Exhuma",
            "country" => "South Korea",
        ], $collection3->all());
    }

    public function testCollapse()
    {
        $collection = collect([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ]);

        $result = $collection->collapse();
        assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
    }

    // flatMap
    public function testFlatMap()
    {
        $collection = collect([
            [
                "title" => "Exhuma",
                "genres" => ["Horror", "Mystery", "Thriller"]
            ],
            [
                "title" => "Ghostbusters: Frozen Empire",
                "genres" => ["Adventure", "Comedy", "Fantasy"]
            ]
        ]);

        $genres = $collection->flatMap(function ($item) {
            return $item["genres"];
        });
        assertEquals(["Horror", "Mystery", "Thriller", "Adventure", "Comedy", "Fantasy"], $genres->all());
    }

    // string representation
    public function testJoin()
    {
        $collection = collect(["Muhammad", "Ariiq", "Fiezayyan"]);

        assertEquals("Muhammad-Ariiq-Fiezayyan", $collection->join("-"));
        assertEquals("Muhammad-Ariiq_Fiezayyan", $collection->join(glue: "-", finalGlue: "_"));
    }
    //
    public function testFilter()
    {
        $collection = collect([
            "Exhuma" => 100,
            "Ghostbusters: Frozen Empire" => 85,
            "Godzilla x Kong: The New Empire" => 90,
        ]);
        $result = $collection->filter(function ($item, $key) {
            return $item >= 90;
        });
        assertEquals([
            "Exhuma" => 100,
            "Godzilla x Kong: The New Empire" => 90
        ], $result->all());
    }
    // better than filter
    public function testPartition()
    {
        $collection = collect([
            "Exhuma" => 100,
            "Ghostbusters: Frozen Empire" => 85,
            "Godzilla x Kong: The New Empire" => 90,
        ]);
        [$result, $result2] = $collection->partition(function ($item, $key) {
            return $item >= 90;
        });
        assertEquals([
            "Exhuma" => 100, "Godzilla x Kong: The New Empire" => 90
        ], $result->all());
        assertEquals(["Ghostbusters: Frozen Empire" => 85], $result2->all());
    }

    //
    public function testTesting()
    {
        $collection = collect(["Muhammad", "Ariiq", "Fiezayyan"]);
        self::assertTrue($collection->contains(key: "Ariiq"));
        self::assertTrue($collection->contains(function ($value, $key) {
            return $value == "Ariiq";
        }));
    }

    public function testGrouping()
    {
        $collection = collect([
            [
                "title" => "Exhuma",
                "type" => "Film"
            ],
            [
                "title" => "Siksa Kubur",
                "type" => "Film"
            ],
            [
                "title" => "Hangout with Yoo",
                "type" => "Variety Show"
            ]
        ]);
        $result = $collection->groupBy(groupBy: "type");
        assertEquals([
            "Film" => collect([
                [
                    "title" => "Exhuma",
                    "type" => "Film"
                ],
                [
                    "title" => "Siksa Kubur",
                    "type" => "Film"
                ],
            ]),
            "Variety Show" => collect([
                [
                    "title" => "Hangout with Yoo",
                    "type" => "Variety Show"
                ]
            ]),
        ], $result->all());
        assertEquals([
            "Film" => collect([
                [
                    "title" => "Exhuma",
                    "type" => "Film"
                ],
                [
                    "title" => "Siksa Kubur",
                    "type" => "Film"
                ],
            ]),
            "Variety Show" => collect([
                [
                    "title" => "Hangout with Yoo",
                    "type" => "Variety Show"
                ]
            ]),
        ], $collection->groupBy(function ($value, $key) {
            return $value["type"];
        })->all());
    }

    public function testSlice()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->slice(offset: 3);
        assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->slice(offset: 3, length: 2);
        assertEqualsCanonicalizing([4, 5], $result->all());
    }
    public function testTake()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->take(limit: 3);
        assertEqualsCanonicalizing([1, 2, 3], $result->all());

        $result = $collection->takeUntil(function ($value, $key) {
            return $value == 3;
        });
        assertEqualsCanonicalizing([1, 2], $result->all());

        $result = $collection->takeWhile(function ($value, $key) {
            return $value < 3;
        });
        assertEqualsCanonicalizing([1, 2], $result->all());
    }
    public function testSkip()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->skip(count: 3);
        assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->skipUntil(function ($value, $key) {
            return $value == 3;
        });
        assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->skipWhile(function ($value, $key) {
            return $value < 3;
        });
        assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());
    }
    public function testChunked()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->chunk(size: 3);
        assertEqualsCanonicalizing([1, 2, 3], $result->all()[0]->all());
        assertEqualsCanonicalizing([4, 5, 6], $result->all()[1]->all());
        assertEqualsCanonicalizing([7, 8, 9], $result->all()[2]->all());
    }
    public function testFirst()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->first();
        assertEquals(1, $result);
        $result = $collection->first(function ($value, $key) {
            return $value > 5;
        });
        assertEquals(6, $result);
    }
    public function testLast()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->last();
        assertEquals(9, $result);
        $result = $collection->last(function ($value, $key) {
            return $value < 5;
        });
        assertEquals(4, $result);
    }
    public function testRandom()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->random();
        self::assertTrue(in_array($result, [1, 2, 3, 4, 5, 6, 7, 8, 9]));
    }
    public function testCheckingExistance()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        self::assertTrue($collection->isNotEmpty());
        self::assertFalse($collection->isEmpty());
        self::assertTrue($collection->contains(8));
        self::assertFalse($collection->contains(10));
        self::assertTrue($collection->contains(function ($value, $key) {
            return $value == 8;
        }));
    }
    public function testOrdering()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->sort();
        assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
        $result = $collection->sortDesc();
        assertEqualsCanonicalizing([9, 8, 7, 6, 5, 4, 3, 2, 1], $result->all());
    }
    public function testAggregate()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->sum();
        assertEquals(45, $result);

        $result = $collection->avg();
        assertEquals(5, $result);

        $result = $collection->min();
        assertEquals(1, $result);

        $result = $collection->max();
        assertEquals(9, $result);
    }
    public function testReduce()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->reduce(function ($carry, $item) {
            return $carry + $item;
        });
        assertEquals(45, $result);
    }
    public function testLazyCollection()
    {
        $collection = LazyCollection::make(function () {
            $value = 0;
            while (true) {
                yield $value;
                $value++;
            }
        });

        $result = $collection->take(10);
        assertEqualsCanonicalizing([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
    }
}
