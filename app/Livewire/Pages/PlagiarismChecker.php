<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use GuzzleHttp\Client;

class PlagiarismChecker extends Component
{
    public string $text = '';
    public array $results = [];

    public function checkPlagiarism()
    {
        $this->validate([
            'text' => 'required|min:30',
        ]);

        $this->results = $this->detectPlagiarism($this->text);
    }

    private function detectPlagiarism(string $text): array
    {
        $client = new Client();

        $apiKey = config('services.google_search.key'); // Set in config/services.php
        $cx = config('services.google_search.cx');      // Set in config/services.php

        $words = explode(' ', $text);
        $snippetLength = 8; // Words per search
        $results = [];

        for ($i = 0; $i < count($words); $i += $snippetLength) {
            $snippet = implode(' ', array_slice($words, $i, $snippetLength));
            $query = '"' . $snippet . '"'; // Use exact match

            try {
                $response = $client->get("https://www.googleapis.com/customsearch/v1", [
                    'query' => [
                        'key' => $apiKey,
                        'cx' => $cx,
                        'q' => $query
                    ]
                ]);

                $data = json_decode($response->getBody(), true);

                if (!empty($data['items'])) {
                    $matches = array_map(fn($item) => $item['link'], $data['items']);
                } else {
                    $matches = [];
                }

                $results[] = [
                    'phrase' => $snippet,
                    'matches' => $matches,
                ];

                sleep(1); // Avoid rate-limiting

            } catch (\Exception $e) {
                \Log::error("Google Search Error: " . $e->getMessage());
                $results[] = [
                    'phrase' => $snippet,
                    'matches' => [],
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    public function render()
    {
       return view('livewire.pages.plagiarism-checker');
    }
}
