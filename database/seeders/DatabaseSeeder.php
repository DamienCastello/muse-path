<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Feedback;
use App\Models\Resource;
use App\Models\Tag;
use App\Models\Genre;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Maga',
            'email' => 'maga@gmail.com',
            'role' => 'artist',
            'password' => Hash::make('0000')
        ]);

        User::factory()->create([
            'name' => 'John',
            'email' => 'john.doe@gmail.com',
            'role' => 'user',
            'password' => Hash::make('0000')
        ]);

        User::factory()->create([
            'name' => 'Gamma',
            'email' => 'shinigamma@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('0000')
        ]);

        Category::factory()->create([
            'name' => 'VST Synthesizer',
        ]);
        Category::factory()->create([
            'name' => 'VST Effect',
        ]);
        Category::factory()->create([
            'name' => 'Sample pack',
        ]);
        Category::factory()->create([
            'name' => 'Formation',
        ]);
        Category::factory()->create([
            'name' => 'Tutoriel',
        ]);

        Tag::factory()->create([
            'name' => 'Acid',
        ]);
        Tag::factory()->create([
            'name' => 'Trance',
        ]);
        Tag::factory()->create([
            'name' => 'Kick',
        ]);
        Tag::factory()->create([
            'name' => 'Bass',
        ]);

        Genre::factory()->create([
            'name' => 'Acid',
        ]);
        Genre::factory()->create([
            'name' => 'Trance',
        ]);
        Genre::factory()->create([
            'name' => 'FrenchCore',
        ]);
        Genre::factory()->create([
            'name' => 'Tribe',
        ]);

        Resource::factory()->hasAttached(Tag::all())->hasAttached(User::find(1))->create([
            'title' => 'VST Serum',
            'image' => 'resource/1701339481.jpg',
            'slug' => 'vst-serum',
            'description' => 'Serum VST, c’est le nom d’un des meilleurs Plugins synthétiseurs du moment. Ce (micro) logiciel de musique offre de réelles fonctionnalités de créations inédites, permettant de composer rapidement avec une grande qualité sonore. Il est présent dans de très nombreuses compositions actuelles et, grâce à sa polyvalence extrême, il s’adapte à de nombreux genres musicaux.',
            'price' => 189,
            'link' => "https://xferrecords.com/products/serum/",
            'category_id' => 1,
            'user_id' => 2
        ]);

        // Attach random :
        // Resource::factory()->hasAttached(Tag::all()->random(2))->hasAttached(User::find(2))->create([
        Resource::factory()->hasAttached(Tag::query()->whereIn('id',[1,3,4])->get())->hasAttached(User::find(2))->create([
            'title' => 'Formation mastering acid',
            'image' => null,
            'slug' => 'formation-mastering-acid',
            'description' => 'Le guide complet pour apprendre à masteriser tes tracks tekno, acid & hardcore.',
            'price' => 69,
            'link' => "https://skone.podia.com/",
            'category_id' => 4,
            'user_id' => 1
        ]);

        Resource::factory()->hasAttached(Tag::query()->whereIn('id',[1,3])->get())->hasAttached(User::find(2))->create([
            'title' => 'Infinite kick acid sample pack',
            'image' => 'resource/1701339518.jpg',
            'slug' => 'infinite-kick-acid-sample-pack',
            'description' => 'Serum VST, c’est le nom d’un des meilleurs Plugins synthétiseurs du moment. Ce (micro) logiciel de musique offre de réelles fonctionnalités de créations inédites, permettant de composer rapidement avec une grande qualité sonore. Il est présent dans de très nombreuses compositions actuelles et, grâce à sa polyvalence extrême, il s’adapte à de nombreux genres musicaux.',
            'price' => 19,
            'link' => "https://skone.podia.com/",
            'category_id' => 3,
            'user_id' => 1
        ]);

        Resource::factory()->hasAttached(Tag::all())->hasAttached(User::query()->find(1))->create([
            'title' => 'VST Sylenth',
            'image' => null,
            'slug' => 'vst-sylenth',
            'description' => 'Sylenth1 est créé par la société LennarDigital en 2006. Il s’agit du seul produit de la firme. C’est un synthé soustractif analogique virtuel avec 4 oscillateurs, des filtres et une section de modulation. Assez basique en somme, mais en approfondissant un peu, on trouve la raison de sa présence dans le podium de ce top.',
            'price' => 139,
            'link' => "https://www.lennardigital.com/sylenth1/",
            'category_id' => 1,
            'user_id' => 2
        ]);

        Comment::factory()->create([
            'content' => 'Thanks!',
            'user_id' => 1,
            'resource_id' => 1
        ]);

        Track::factory()->hasAttached(Genre::find(4))->hasAttached(User::query()->find(2))->create([
            'title' => 'Baboulinet',
            'image' => '1/image/1702464480.jpg',
            'music' => '1/music/1702464480.mp3',
            'description' => null,
            'user_id' => 1,
        ]);

        Feedback::factory()->create([
            'message' => '❤️',
            'user_id' => 2,
            'track_id' => 1
        ]);

        /*
        Resource::factory()
            ->count(2)
            ->forCategory([
                'id' => 1,
            ])
            ->create();

        Resource::factory()
            ->forCategory([
                'id' => 3,
            ])
            ->create();
        */
    }
}
