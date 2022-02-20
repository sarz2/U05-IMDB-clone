<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Movie;
use App\Models\Review;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Review::factory(20)->create();
        // Movie::factory(100)->create();

        

        /**** SHOULD THESE API REQUESTS BE SOMEWHERE ELSE? IN THE MOVIE FACTORY FILE? ****/
        // Get popular movies from TMDB
        $movies = Http::get('https://api.themoviedb.org/3/movie/popular?api_key=87a6bee8df47d296511c8924683d6ecf&language=en-US&page=1');
        $moviesToArray = json_decode($movies); // Convert to array

        // Genres are defined as a seperate endpoint and are refered to by their ID in the movie object
        function getGenre ($id) { // Get the genre by the genre ID in the movie object
            $genres = Http::get('https://api.themoviedb.org/3/genre/movie/list?api_key=87a6bee8df47d296511c8924683d6ecf&language=en-US');
            $genresToArray = json_decode($genres);

            foreach ($genresToArray->genres as $genre) { // Loop through all genres to find the match, return the genre name
                if ($genre->id == $id) {
                    return $genre->name;
                }
            }
        }

        // Trailers are defined as a seperate endpoint
        function getTrailer ($id) { // Get the trailer youtube key with the movie ID
            $trailer = Http::get("https://api.themoviedb.org/3/movie/$id/videos?api_key=87a6bee8df47d296511c8924683d6ecf&language=en-US");
            $trailerToArray = json_decode($trailer);

            if (!$trailerToArray->results == []) { // If results is NOT empty array
                
                $trailerId = $trailerToArray->results[0]->key;

                return "https://www.youtube.com/embed/$trailerId"; // Return embed url
            } else {
                return "";
            }
            
        }

        // Loop through API response
        foreach ($moviesToArray->results as $movie) {

            // Actors of a specific movie are defined as a seperate endpoint
            $actors = Http::get("https://api.themoviedb.org/3/movie/$movie->id/credits?api_key=87a6bee8df47d296511c8924683d6ecf&language=en-US");
            $actorsToArray = json_decode($actors);

            Movie::create([ // Seed movies table with the API responses
                'title' => $movie->original_title,
                'genre' => getGenre($movie->genre_ids[0]),
                'cast' => json_encode(array($actorsToArray->cast[0]->name, $actorsToArray->cast[1]->name, $actorsToArray->cast[2]->name)),
                'abstract' => $movie->overview,
                'urls_images' => json_encode(array($movie->poster_path)),
                'url_trailer' => getTrailer($movie->id),
                'avg_rating' => $movie->vote_average,
                'released' => (int)substr($movie->release_date, 0, 4)
            ]);
        }

    }
}
