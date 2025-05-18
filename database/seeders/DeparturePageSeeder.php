<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeparturePage;
use App\Models\Vote;
use App\Models\Comment;
use App\Models\User;
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

        $imageUrls = [
            'https://picsum.photos/seed/1/400/250',
            'https://picsum.photos/seed/2/400/250',
            'https://picsum.photos/seed/3/400/250',
            'https://placekitten.com/400/250',
            'https://placebear.com/400/250',
        ];

        // Créer 15 utilisateurs
        $users = collect();
        for ($i = 0; $i < 15; $i++) {
            $users->push(User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), // mot de passe générique
            ]));
        }

        // Créer 20 pages
        for ($i = 0; $i < 20; $i++) {
            $tone = $faker->randomElement($tones);
            $message = $faker->paragraphs($faker->numberBetween(1, 3), true);
            $slug = Str::slug(Str::limit($tone . '-' . Str::random(8), 50));

            $isAnonymous = $faker->boolean(30); // 30% anonymes
            $user = $isAnonymous ? null : $users->random();

            $page = DeparturePage::create([
                'tone'         => $tone,
                'message'      => $message,
                'gif'          => $faker->randomElement($imageUrls),
                'sound'        => "/sounds/{$tone}.mp3",
                'anonymous'    => $isAnonymous,
                'author_name'  => $isAnonymous ? null : $user->name,
                'author_email' => $isAnonymous ? null : $user->email,
                'release_at'   => $faker->dateTimeBetween('-1 month', 'now'),
                'slug'         => $slug,
                'user_id'      => $user?->id,
            ]);

            // Créer entre 3 et 10 votes
            $voteCount = $faker->numberBetween(3, 10);
            for ($j = 0; $j < $voteCount; $j++) {
                $voteUser = $faker->boolean(60) ? $users->random() : null; // 60% des votes avec utilisateur

                Vote::create([
                    'departure_page_id' => $page->id,
                    'voter_ip' => $faker->ipv4,
                    'user_id' => $voteUser?->id,
                ]);
            }

            // Créer entre 1 et 5 commentaires
            $commentCount = $faker->numberBetween(1, 5);
            for ($k = 0; $k < $commentCount; $k++) {
                $commentUser = $faker->boolean(50) ? $users->random() : null;

                Comment::create([
                    'departure_page_id' => $page->id,
                    'user_id' => $commentUser?->id,
                    'author' => $commentUser?->name ?? $faker->name,
                    'content' => $faker->sentence($faker->numberBetween(5, 15)),
                ]);
            }
        }
    }
}
