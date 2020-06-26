<?php

namespace Common\Admin\Analytics\Actions;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

class GetGoogleAnalyticsData implements GetAnalyticsData
{
    /**
     * @var Analytics
     */
    private $analytics;

    /**
     * @param Analytics $analytics
     */
    public function __construct(Analytics $analytics)
    {
        $this->analytics = $analytics;
        $this->registerCollectionMacros();
    }

    public function execute($channel)
    {
        return [
            'browsers' =>  $this->analytics->fetchTopBrowsers(Period::days(7)),
            'countries' => $this->getCountries(),
            'weeklyPageViews' => $this->weeklyPageViews(),
            'monthlyPageViews' => $this->monthlyPageViews(),
        ];
    }

    private function weeklyPageViews()
    {
        return [
            'current' => $this->getPageViews(Period::days(7))
        ];
    }

    private function monthlyPageViews()
    {
        return [
            'current' => $this->getPageViews(Period::months(1))
        ];
    }

    private function getPageViews(Period $period)
    {
        $data = $this->analytics->fetchTotalVisitorsAndPageViews($period);

        return $data->map(function($item) {
            return [
                'pageViews' => $item['pageViews'],
                'date' => $item['date']->getTimestamp()
            ];
        });
    }

    private function getCountries($maxResults = 6)
    {
        $answer = $this->analytics->performQuery(
            Period::days(7),
            'ga:sessions',
            ['dimensions' => 'ga:country', 'sort' => '-ga:sessions']
        );

        if (is_null($answer->rows)) {
            return new Collection([]);
        }

        $pagesData = [];
        foreach ($answer->rows as $pageRow) {
            $pagesData[] = ['country' => $pageRow[0], 'sessions' => $pageRow[1]];
        }

        $countries = new Collection(array_slice($pagesData, 0, $maxResults - 1));

        if (count($pagesData) > $maxResults) {
            $otherCountries = new Collection(array_slice($pagesData, $maxResults - 1));
            $otherCountriesCount = array_sum(Collection::make($otherCountries->lists('sessions'))->toArray());

            $countries->put(null, ['country' => 'other', 'sessions' => $otherCountriesCount]);
        }

        return $countries;
    }

    private function registerCollectionMacros()
    {
        // laravel analytics page needs legacy "lists" method
        Collection::macro('lists', function($value, $key = null) {
            return self::pluck($value, $key);
        });
    }
}