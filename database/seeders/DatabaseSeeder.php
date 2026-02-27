<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Content;
use App\Models\ContentAttachment;
use App\Models\Comment;
use App\Models\Client;
use App\Models\Forum;
use App\Models\ForumAccess;
use App\Models\MessageForum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);
        $users = User::factory(10)->create();
        User::factory()->create([
            'name' => "admin",
            'email' => "admin@gmail.com",
            'role_id' => 4,
            'password' => "password11",
        ]);
        
        Content::factory(10)->create();
        ContentAttachment::factory(10)->create([
            'file' => 'images/visi.jpg'
        ]);
        Comment::factory(20)->create();
        for($i=1; $i<=20;$i++){
            Client::factory()->create([
                'name' => 'Mandiri Coal',
                'image' => 'storage/clients/cropped-logo-PTNHM-Small-1.png'
            ]);
        }
        Forum::factory(9)->create();
        $publicForum = Forum::factory()->create([
            'name' => 'Public Forum'
        ]);
        ForumAccess::factory(9)->create();
        for($i=1; $i<$users +1 ;$i++){
            ForumAccess::factory()->create([
                'forum_id' => $publicForum->id,
                'user_id' => $i,
            ]);
        }
        MessageForum::factory(10)->create();
    }
}
