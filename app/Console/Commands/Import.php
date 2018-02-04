<?php

namespace MindGeekTest\Console\Commands;

use Illuminate\Console\Command;
use MindGeekTest\Jobs\ProcessMovie;
use GuzzleHttp\Client;

/**
 * Class Import
 * @package MindGeekTest\Console\Commands
 */
class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:showcase {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import showcase movies from source';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $url = $this->argument('url');

        $this->info('Importing movies from: ' . $url);

        $movies = $this->request($url);

        if (empty($movies)) {
            $this->error('Invalid endpoint');
            return false;
        }

        $bar = $this->output->createProgressBar(count($movies));

        collect($movies)->each(function ($source) use ($url, $bar) {
            ProcessMovie::dispatch($source, $url);
            $bar->advance();
        });

        $bar->finish();

        return true;
    }

    /**
     * @param string $url
     * @return bool|mixed
     */
    public function request(string $url)
    {
        try {
            $request = (new Client())->get($url);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }

        return json_decode(
            mb_convert_encoding($request->getBody()->getContents(), 'UTF-8'), true
        );
    }
}
