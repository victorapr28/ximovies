<?php

namespace Common\Admin\Analytics\Actions;

class GetNullAnalyticsData implements GetAnalyticsData
{
    public function execute($channel) {
        return [
            'weeklyPageViews' => [
                'current' => []
            ],
            'monthlyPageViews' => [
                'current' => []
            ],
            'browsers' => [],
            'countries' => []
        ];
    }
}