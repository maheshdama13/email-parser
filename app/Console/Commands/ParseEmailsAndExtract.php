<?php

namespace App\Console\Commands;

use App\Helpers\GeneralHelper;
use Illuminate\Console\Command;
use App\Models\SuccessfulEmail;
use Symfony\Component\DomCrawler\Crawler;

class ParseEmailsAndExtract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:parse-and-extract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the emails and extract plain text.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails = SuccessfulEmail::whereNull('raw_text')->get();

        foreach ($emails as $email) {
            $plainText = (new GeneralHelper)->extractPlainText($email->email);
            $email->update(['raw_text' => $plainText]);
            $this->info("Parsed email ID: {$email->id}");
        }

        return 0;
    }
}
