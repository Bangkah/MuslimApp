<?php

return [
    /**
     * Source of prayertime.
     *
     * Supported: 'kemenag', 'myquran.com', 'manual calculation', 'custom'
     * default: 'manual calculation'
     */
    'source' => ENV('PRAYERTIME_SOURCE', 'manual calculation'),

    /**
     * manual calculation source
     *
     * Supported: "praytimes.org, geniusts/prayer-times, islamic-network/prayer-times"
     * default: 'geniusts/prayer-times'
     */
    'manual_source' => ENV('PRAYTIME_MANUAL_SOURCE', 'geniusts/prayer-times'),

    /**
     * Kemenag source
     * choose crawler if you don't have an api key
     * Supported: "crawler", "api"
     */
    'kemenag_source' => ENV('PRAYTIME_KEMENAG_SOURCE', 'api'),

    /**
     * Kemenag api key
     * required if kemenag_source is using api
     */
    'kemenag_api_key' => ENV('PRAYTIME_KEMENAG_API_KEY'),

    /**
     * Base URI of prayertime
     *
     * kemenag: https://bimasislam.kemenag.go.id/
     * myquran.com: https://api.myquran.com/v2/
     * manual calculation: `leave this empty`
     * custom: `free to customize`
     */
    'base_uri' => ENV('PRAYTIME_BASE_URI'),

    /**
     * define your custom prayer time class if source is using custom
     *
     * you can check this class as reference
     *
     * @see \Jhonoryza\LaravelPrayertime\Support\KemenagPrayerTime
     * @see \Jhonoryza\LaravelPrayertime\Support\MyQuranPrayerTime
     * @see \Jhonoryza\LaravelPrayertime\Support\ManualPrayerTime
     */
    'custom_prayer_time_class' => null,
];
