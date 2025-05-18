<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeparturePage;
use App\Models\Vote;
use App\Models\Comment;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DeparturePageSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $tones = [
            'dramatique',
            'ironique',
            'absurde',
            'classe',
            'touchant',
            'passif-agressif',
            'ultra_cringe',
            'honnête'
        ];

        // Génère 20 pages
        for ($i = 0; $i < 20; $i++) {
            $tone    = $faker->randomElement($tones);
            $message = $faker->paragraphs($faker->numberBetween(1, 3), true);
            $slug    = Str::slug(Str::limit($message, 50) . '-' . $i, '-');

            $page = DeparturePage::create([
                'tone'         => $tone,
                'message'      => $message,
                'gif'          => $faker->imageUrl(400, 250, 'abstract', true),
                'sound'        => null,    // ou $faker->url
                'anonymous'    => $faker->boolean(30),
                'author_name'  => $faker->name,
                'author_email' => $faker->email,
                'release_at'   => $faker->dateTimeBetween('-1 month', 'now'),
                'slug'         => $slug,
                'user_id'      => null,    // ou $faker->numberBetween(1,5) si vous avez déjà des users
            ]);

            // Génère entre 0 et 50 votes
            $voteCount = $faker->numberBetween(0, 50);
            for ($j = 0; $j < $voteCount; $j++) {
                Vote::create([
                    'departure_page_id' => $page->id,
                    'voter_ip'          => $faker->ipv4,
                    'user_id'           => null,
                ]);
            }

            // Génère entre 0 et 10 commentaires
            $commentCount = $faker->numberBetween(0, 10);
            for ($k = 0; $k < $commentCount; $k++) {
                Comment::create([
                    'departure_page_id' => $page->id,
                    'user_id'           => null,
                    'author'            => $faker->name,
                    'content'           => $faker->sentence($faker->numberBetween(5, 15)),
                ]);
            }
        }
    }
}
