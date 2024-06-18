<?php 
namespace App\Helpers;

use Symfony\Component\DomCrawler\Crawler;

class GeneralHelper
{
    public function extractPlainText($rawEmail)
    {
        $crawler = new Crawler($rawEmail);

        $textNodes = $crawler->filterXPath('//text()');
        $plainText = '';

        foreach ($textNodes as $node) {
            if ($node->nodeName === 'br') {
                $plainText .= "\n";
                continue;
            }
            $plainText .= trim($node->textContent) . "\n";
        }

        return $plainText;
    }
}