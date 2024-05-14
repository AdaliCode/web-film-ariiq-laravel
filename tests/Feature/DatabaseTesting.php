<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseTesting extends TestCase
{
    protected function seUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM movies");
    }
    public function test_example(): void
    {
        DB::insert('insert into movies (id, title, description, create_at) values (?, ?, ?, ?)', ['ONE-PIECE', 'One Piece', 'Kaizoku Ni Naru Ottokoda', '2023-05-14 08:40:00']);

        $result = DB::select('select * from movies where id = ?', ['ONE-PIECE']);

        self::assertEquals(1, count($result));
        self::assertEquals('ONE-PIECE', count($result[0]->id));
        self::assertEquals('One Piece', count($result[0]->title));
        self::assertEquals('Kaizoku Ni Naru Ottokoda', count($result[0]->description));
        self::assertEquals('2023-05-14 08:40:00', count($result[0]->create_at));
    }

    public function testNamedBinding(): void
    {
        DB::insert('INSERT INTO movies(id, title, description, create_at) VALUES (:id, :title, :description, :create_at)', [
            'id' => 'ONE-PIECE',
            'title' => 'One Piece',
            'description' => 'Kaizoku Ni Naru Ottokoda',
            'create_at' => '2023-05-14 08:59:00',
        ]);

        $result = DB::select('SELECT * FROM movies where id = :id', ['id' => 'ONE-PIECE']);

        self::assertEquals(1, count($result));
        self::assertEquals('ONE-PIECE', count($result[0]->id));
        self::assertEquals('One Piece', count($result[0]->title));
        self::assertEquals('Kaizoku Ni Naru Ottokoda', count($result[0]->description));
        self::assertEquals('2023-05-14 08:40:00', count($result[0]->create_at));
    }
    public function testTransaction(): void
    {
        DB::transaction(function () {
            DB::insert('insert into movies (id, title, description, create_at) values (?, ?, ?, ?)', ['ONE-PIECE', 'One Piece', 'Kaizoku Ni Naru Ottokoda', '2023-05-14 08:40:00']);
            DB::insert('insert into movies (id, title, description, create_at) values (?, ?, ?, ?)', ['RUNNINGMAN', 'Runningman', 'Daebagida', '2023-05-14 09:03:00']);
        });

        $result = DB::select('select * from movies');

        self::assertEquals(2, count($result));
    }
    public function testManualTransaction(): void
    {
        try {
            //code...
            DB::beginTransaction();
            DB::insert('insert into movies (id, title, description, create_at) values (?, ?, ?, ?)', ['ONE-PIECE', 'One Piece', 'Kaizoku Ni Naru Ottokoda', '2023-05-14 08:40:00']);
            DB::insert('insert into movies (id, title, description, create_at) values (?, ?, ?, ?)', ['RUNNINGMAN', 'Runningman', 'Daebagida', '2023-05-14 09:03:00']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        $result = DB::select('select * from movies');
        self::assertEquals(2, count($result));
    }
}
