<?php

namespace Tests\Feature;

use App\Models\Cast;
use App\Models\Catagory;
use App\Models\Comment;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CastSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;

class EloquentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function testInsert(): void
    // {
    //     $category = new Catagory();
    //     $category->id = "ACTION";
    //     $category->name = "Action";
    //     $result = $category->save();

    //     assertTrue($result);
    // }
    // public function testInsertManyCategories(): void
    // {
    //     $categories = [];
    //     for ($i = 0; $i < 10; $i++) {
    //         $categories[] = [
    //             'id' => "ID $i",
    //             'name' => "Name $i"
    //         ];
    //     }
    //     $result = Catagory::query()->insert($categories);
    //     self::assertTrue($result);
    //     $total = Catagory::query()->count();
    //     self::assertEquals(15, $total);
    // }

    // public function testFind()
    // {
    //     // $this->seed(CategorySeeder::class);

    //     $category = Catagory::query()->find("HORROR");
    //     self::assertNotNull($category);
    //     self::assertEquals("HORROR", $category->id);
    //     self::assertEquals("Horror", $category->name);
    //     self::assertEquals("Horror Category", $category->description);
    // }
    // public function testUpdate()
    // {
    //     // $this->seed(CategorySeeder::class);

    //     $category = Catagory::query()->find("HORROR");
    //     $category->description = "Horror Category";
    //     $result = $category->update();
    //     self::assertTrue($result);
    // }
    // public function testSelect()
    // {
    //     // for ($i = 10; $i < 15; $i++) {
    //     //     $category = new Catagory();
    //     //     $category->id = "$i";
    //     //     $category->name = "Category $i";
    //     //     $category->save();
    //     // }

    //     $categories = Catagory::query()->whereNull("description")->get();
    //     self::assertEquals(19, $categories->count());
    //     $categories->each(function ($category) {
    //         self::assertNull($category->description);
    //     });
    // }
    // public function testUpdateSelect()
    // {
    //     $categories = Catagory::query()->whereNull("description")->get();
    //     self::assertEquals(19, $categories->count());
    //     $categories->each(function ($category) {
    //         $category->description = "Updated";
    //         $category->update();
    //     });
    // }
    // public function testUpdateMany()
    // {
    //     Catagory::query()->whereNull("description")->update([
    //         'description' => "updated"
    //     ]);
    //     $total = Catagory::query()->where("description", "Updated")->count();
    //     self::assertEquals(0, $total);
    // }
    // public function testDelete()
    // {
    //     // $this->seed(CategorySeeder::class);

    //     $category = Catagory::query()->find("HORROR");
    //     $result = $category->delete();
    //     self::assertTrue($result);

    //     $total = Catagory::query()->count();
    //     self::assertEquals(19, $total);
    // }

    public function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from casts");
    }

    public function testCreateCast()
    {
        $cast = new Cast();
        $cast->name = "Byeon Woo Seok";
        $cast->cast_code = "1232123";
        $cast->save();

        self::assertNotNull($cast->id);
    }

    public function testCreateCastUUID()
    {
        $cast = new Cast();
        $cast->name = "Kim Hye Yoon";
        $cast->save();

        self::assertNotNull($cast->id);
        self::assertNotNull($cast->cast_code);
    }

    public function setUpComment(): void
    {
        parent::setUp();
        DB::delete("delete from comments");
    }

    public function testCreateComment()
    {
        $comment = new Comment();
        $comment->email = "ariiq@aflix.com";
        $comment->title = "Sample Title";
        $comment->comment = "Sample Comment";
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();
        $comment->save();

        self::assertNotNull($comment->id);
    }

    public function testDefaultAttributeValues()
    {
        $comment = new Comment();
        $comment->email = "ariiq@aflix.com";
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();
        $comment->save();

        self::assertNotNull($comment->id);
    }
    // public function testCreate()
    // {
    //     $request = [
    //         'id' => 'ACTION',
    //         'name' => 'Action',
    //         'description' => 'Action Category'
    //     ];
    //     $category = Catagory::query()->create($request);
    //     self::assertNotNull($category->id);
    // }
    // public function testUpdateModel()
    // {
    //     $request = [
    //         'name' => 'Action Updated',
    //         'description' => 'Action Category Updated'
    //     ];
    //     $category = Catagory::query()->find('ACTION');
    //     $category->fill($request);
    //     $category->save();
    //     self::assertNotNull($category->id);
    // }
    public function testSoftDelete()
    {
        $this->seed(CastSeeder::class);
        $cast = Cast::query()->where('name', 'Sample Cast')->first();
        $cast->delete();
        $cast = Cast::query()->where('name', 'Sample Cast')->first();
        self::assertNull($cast);
    }
    // public function testRemoveGlobalScope()
    // {
    //     $category = new Catagory();
    //     $category->id = "HORROR";
    //     $category->name = "Horror";
    //     $category->description = "Horror Category";
    //     $category->is_active = false;
    //     $category->save();
    //     self::assertNull($category);
    // }

    public function testShutdownGlobalScope()
    {
        $category = Catagory::query()->find("HORROR");
        self::assertNull($category);

        $category = Catagory::query()->withoutGlobalScopes([IsActiveScope::class])->find("HORROR");
        self::assertNotNull($category);
    }
}
