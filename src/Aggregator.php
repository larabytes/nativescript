<?php

namespace Aggregators\Nativescript;

use Carbon\Carbon;
use InvalidArgumentException;
use Aggregators\Support\BaseAggregator;
use Symfony\Component\DomCrawler\Crawler;

class Aggregator extends BaseAggregator
{
    /**
     * {@inheritDoc}
     */
    public string $uri = 'https://nativescript.org/blog/';

    /**
     * {@inheritDoc}
     */
    public string $provider = 'Nativescript';

    /**
     * {@inheritDoc}
     */
    public string $logo = 'logo.jpg';

    /**
     * {@inheritDoc}
     */
    public function articleIdentifier(): string
    {
        return 'li.BlogPost';
    }

    /**
     * {@inheritDoc}
     */
    public function nextUrl(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('a[rel="next"]')->first()->attr('href');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function image(Crawler $crawler): ?string
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function title(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('h3')->text();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function content(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('div.-mb4.-pb4 > div.row > div.col-12 > p')->text();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function link(Crawler $crawler): ?string
    {
        try {
            return 'https://nativescript.org' . $crawler->filter('h3 > a')->attr('href');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function dateCreated(Crawler $crawler): Carbon
    {
        try {
            return Carbon::parse($crawler->filter('time')->text());
        } catch (InvalidArgumentException $e) {
            return Carbon::now();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function dateUpdated(Crawler $crawler): Carbon
    {
        return $this->dateCreated($crawler);
    }
}
