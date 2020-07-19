<?php

namespace App\Service;

use DateTime;
use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Throwable;

class IGDBServiceManager
{
    private $before;
    private $current;
    private $after;
    private $afterFour;
    private $client;
    private $apiurl;
    private $apikey;
    private $platforms = [
        6, // PC
        48, // PS4
        49, // Xbox One
        130, // Switch
        167, // PS5
        169, // Xbox series X
    ];


    /**
     * IGDBServiceManager constructor.
     *
     * @param $apiurl
     * @param $apikey
     *
     * @throws Exception
     */
    public function __construct($apiurl, $apikey)
    {
        $this->before = new DateTime('-2 months');
        $this->current = new DateTime();
        $this->after = new DateTime('+2 months');
        $this->afterFour = new DateTime('+4 months');
        $this->client = HttpClient::create();
        $this->apiurl = $apiurl;
        $this->apikey = $apikey;
    }

    private function getPlatforms()
    {
        return implode($this->platforms, ',');
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getPopularGames()
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiurl.'/games',
                [
                    'headers' => [
                        'user-key' => $this->apikey,
                    ],
                    'body' => "
                        fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating;
                        where platforms = ({$this->getPlatforms()})
                        & (
                            first_release_date >= {$this->before->getTimestamp()} &
                            first_release_date <= {$this->after->getTimestamp()}  
                        );
                        sort popularity desc;
                        limit 12;
                    ",
                ]
            )->toArray();
        } catch (Throwable $e) {
            return null;
        }

        return $response;
    }

    /**
 * @return array
 * @throws Exception
 */
    public function getRecentlyReviewedGames()
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiurl.'/games',
                [
                    'headers' => [
                        'user-key' => $this->apikey,
                    ],
                    'body' => "
                        fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary;
                        where platforms = ({$this->getPlatforms()})
                        & (
                            first_release_date >= {$this->before->getTimestamp()} &
                            first_release_date <= {$this->current->getTimestamp()} & 
                            rating_count > 5
                        );
                        sort popularity desc;
                        limit 3;
                    ",
                ]
            )->toArray();
        } catch (Throwable $e) {
            return null;
        }

        return $response;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getMostAnticipatedGames()
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiurl.'/games',
                [
                    'headers' => [
                        'user-key' => $this->apikey,
                    ],
                    'body' => "
                        fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary;
                        where platforms = ({$this->getPlatforms()})
                        & (
                            first_release_date >= {$this->current->getTimestamp()} &
                            first_release_date < {$this->afterFour->getTimestamp()}
                        );
                        sort popularity desc;
                        limit 4;
                    ",
                ]
            )->toArray();
        } catch (Throwable $e) {
            return null;
        }

        return $response;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getComingSoonGames()
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiurl.'/games',
                [
                    'headers' => [
                        'user-key' => $this->apikey,
                    ],
                    'body' => "
                        fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary;
                        where platforms = ({$this->getPlatforms()})
                        & (
                            first_release_date >= {$this->current->getTimestamp()} &
                            popularity > 5
                        );
                        sort first_release_date asc;
                        limit 4;
                    ",
                ]
            )->toArray();
        } catch (Throwable $e) {
            return null;
        }

        return $response;
    }
}
