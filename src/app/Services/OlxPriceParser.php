<?php

namespace App\Services;

class OlxPriceParser
{
    public function parse(string $html): ?float
    {
        $dom = new \DOMDocument;

        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        foreach ($dom->getElementsByTagName('script') as $script) {
            if ($script->getAttribute('type') !== 'application/ld+json') {
                continue;
            }

            $data = json_decode($script->textContent, true);

            if (isset($data['offers']['price'])) {
                return (float) $data['offers']['price'];
            }
        }

        return null;
    }
}
