<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Database\Seeders\CategorySeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // storage
    public function testStorage()
    {
        $filesystem = Storage::disk("local");
        $filesystem->put("file.txt", "Put Your Content Here");

        self::assertEquals("Put Your Content Here", $filesystem->get('file.txt'));
    }

    // upload
    public function testUpload()
    {
        $image = UploadedFile::fake()->image("ariiq.png");
        $this->post('/file/upload', [
            'picture' => $image
        ])->assertSeeText("OK : ariiq.png");
    }
    // Encryption
    public function testEncrypt()
    {
        $encrypt = Crypt::encrypt('Ariiq Fiezayyan');
        $decrypt = Crypt::decrypt($encrypt);

        self::assertEquals('Ariiq Fiezayyan', $decrypt);
    }

    // cookie
    public function testCreateCookie()
    {
        $this->get('/cookie/set')
            ->assertCookie('User-Id', 'ariiq')
            ->assertCookie('Is-Member', 'true');
    }
    public function testGetCookie()
    {
        $this->withCookie('User-Id', 'ariiq')
            ->withCookie('Is-Member', 'true')
            ->get('/cookie/get')
            ->assertJson([
                'userId' => 'ariiq',
                'isMember' => 'true'
            ]);
    }

    // URL
    public function testCurrent()
    {
        $this->get('/url/current?name=Ariiq')
            ->assertSeeText('/url/current?name=Ariiq');
    }
    public function testNamed()
    {
        $this->get('/url/named')
            ->assertSeeText('/redirect/name/Ariiq');
    }
    public function testAction()
    {
        $this->get('/url/action')
            ->assertSeeText('/register');
    }

    // Session
    public function testCreateSession()
    {
        $this->get('/session/create')
            ->assertSeeText('OK')
            ->assertSessionHas('userId', 'ariiq')
            ->assertSessionHas('isMember', 'true');
    }
    public function testGetSession()
    {
        $this->withSession([
            'userId' => 'ariiq',
            'isMember' => 'true'
        ])->get('/session/get')
            ->assertSeeText('ariiq')->assertSeeText('true');
    }

    // Seeder unit test
    public function testSeeding()
    {
        // $this->seed(CategorySeeder::class);
        $collection = DB::table('categories')->get();
        self::assertCount(4, $collection);
        foreach ($collection as $item) {
            self::assertNotNull($item);
            Log::info(json_encode($item));
        }
    }
}
