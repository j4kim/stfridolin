<?php

namespace App\Console\Commands;

use App\Models\Track;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DumpTracks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dump-tracks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->withProgressBar(Track::all(), function (Track $track) {
            $slug = Str::slug($track->name) . '_' . Str::slug($track->artist_name);
            $path = database_path("seeders/tracks/$slug.json");
            $data = json_encode($track->spotify_data, JSON_PRETTY_PRINT);
            file_put_contents($path, $data);
        });
    }
}
