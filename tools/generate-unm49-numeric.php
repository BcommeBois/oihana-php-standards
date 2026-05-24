<?php

/**
 * Regenerates src/org/unstats/UNM49Numeric.php from the curated dataset below.
 *
 * The dataset is **inlined** in this script (not fetched live) for two reasons:
 *   1. The UN Statistics portal does not expose a stable machine-readable
 *      endpoint for M49 — the "download" link points to an XLSX behind JS.
 *   2. The list changes only once or twice per year. A manual sync against
 *      upstream is realistic; a CI fetch is overkill.
 *
 * Upstream sources to reconcile against when updating:
 *   - https://unstats.un.org/unsd/methodology/m49/  (canonical UN M49)
 *   - https://en.wikipedia.org/wiki/UN_M49           (regional groupings table)
 *   - https://en.wikipedia.org/wiki/ISO_3166-1_numeric  (country/area codes)
 *
 * Usage:
 *   php tools/generate-unm49-numeric.php
 *
 * The script is intentionally outside the composer autoload (no PSR-4, no
 * `autoload.files`) — it is a maintenance helper, not runtime code.
 *
 * @package tools
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */

declare(strict_types=1);

const TARGET_FILE = __DIR__ . '/../src/org/unstats/UNM49Numeric.php' ;

/**
 * The dataset: numeric code → [name, isRegion].
 *
 * Region codes are M49 statistical groupings (continents, sub-regions, special
 * categories). Country codes overlap with ISO 3166-1 numeric.
 *
 * Note: '010' Antarctica is both an ISO 3166-1 country and an M49 region —
 * we mark it as a region to surface the broader semantic.
 *
 * @var array<string, array{name: string, isRegion: bool}>
 */
const DATASET = [
    '001' => [ 'name' => 'World'                                                  , 'isRegion' => true  ],
    '002' => [ 'name' => 'Africa'                                                 , 'isRegion' => true  ],
    '003' => [ 'name' => 'North America'                                          , 'isRegion' => true  ],
    '004' => [ 'name' => 'Afghanistan'                                            , 'isRegion' => false ],
    '005' => [ 'name' => 'South America'                                          , 'isRegion' => true  ],
    '008' => [ 'name' => 'Albania'                                                , 'isRegion' => false ],
    '009' => [ 'name' => 'Oceania'                                                , 'isRegion' => true  ],
    '010' => [ 'name' => 'Antarctica'                                             , 'isRegion' => true  ],
    '011' => [ 'name' => 'Western Africa'                                         , 'isRegion' => true  ],
    '012' => [ 'name' => 'Algeria'                                                , 'isRegion' => false ],
    '013' => [ 'name' => 'Central America'                                        , 'isRegion' => true  ],
    '014' => [ 'name' => 'Eastern Africa'                                         , 'isRegion' => true  ],
    '015' => [ 'name' => 'Northern Africa'                                        , 'isRegion' => true  ],
    '016' => [ 'name' => 'American Samoa'                                         , 'isRegion' => false ],
    '017' => [ 'name' => 'Middle Africa'                                          , 'isRegion' => true  ],
    '018' => [ 'name' => 'Southern Africa'                                        , 'isRegion' => true  ],
    '019' => [ 'name' => 'Americas'                                               , 'isRegion' => true  ],
    '020' => [ 'name' => 'Andorra'                                                , 'isRegion' => false ],
    '021' => [ 'name' => 'Northern America'                                       , 'isRegion' => true  ],
    '024' => [ 'name' => 'Angola'                                                 , 'isRegion' => false ],
    '028' => [ 'name' => 'Antigua and Barbuda'                                    , 'isRegion' => false ],
    '029' => [ 'name' => 'Caribbean'                                              , 'isRegion' => true  ],
    '030' => [ 'name' => 'Eastern Asia'                                           , 'isRegion' => true  ],
    '031' => [ 'name' => 'Azerbaijan'                                             , 'isRegion' => false ],
    '032' => [ 'name' => 'Argentina'                                              , 'isRegion' => false ],
    '034' => [ 'name' => 'Southern Asia'                                          , 'isRegion' => true  ],
    '035' => [ 'name' => 'South-eastern Asia'                                     , 'isRegion' => true  ],
    '036' => [ 'name' => 'Australia'                                              , 'isRegion' => false ],
    '039' => [ 'name' => 'Southern Europe'                                        , 'isRegion' => true  ],
    '040' => [ 'name' => 'Austria'                                                , 'isRegion' => false ],
    '044' => [ 'name' => 'Bahamas'                                                , 'isRegion' => false ],
    '048' => [ 'name' => 'Bahrain'                                                , 'isRegion' => false ],
    '050' => [ 'name' => 'Bangladesh'                                             , 'isRegion' => false ],
    '051' => [ 'name' => 'Armenia'                                                , 'isRegion' => false ],
    '052' => [ 'name' => 'Barbados'                                               , 'isRegion' => false ],
    '053' => [ 'name' => 'Australia and New Zealand'                              , 'isRegion' => true  ],
    '054' => [ 'name' => 'Melanesia'                                              , 'isRegion' => true  ],
    '056' => [ 'name' => 'Belgium'                                                , 'isRegion' => false ],
    '057' => [ 'name' => 'Micronesia'                                             , 'isRegion' => true  ],
    '060' => [ 'name' => 'Bermuda'                                                , 'isRegion' => false ],
    '061' => [ 'name' => 'Polynesia'                                              , 'isRegion' => true  ],
    '064' => [ 'name' => 'Bhutan'                                                 , 'isRegion' => false ],
    '068' => [ 'name' => 'Bolivia, Plurinational State of'                        , 'isRegion' => false ],
    '070' => [ 'name' => 'Bosnia and Herzegovina'                                 , 'isRegion' => false ],
    '072' => [ 'name' => 'Botswana'                                               , 'isRegion' => false ],
    '074' => [ 'name' => 'Bouvet Island'                                          , 'isRegion' => false ],
    '076' => [ 'name' => 'Brazil'                                                 , 'isRegion' => false ],
    '084' => [ 'name' => 'Belize'                                                 , 'isRegion' => false ],
    '086' => [ 'name' => 'British Indian Ocean Territory'                         , 'isRegion' => false ],
    '090' => [ 'name' => 'Solomon Islands'                                        , 'isRegion' => false ],
    '092' => [ 'name' => 'Virgin Islands (British)'                               , 'isRegion' => false ],
    '096' => [ 'name' => 'Brunei Darussalam'                                      , 'isRegion' => false ],
    '100' => [ 'name' => 'Bulgaria'                                               , 'isRegion' => false ],
    '104' => [ 'name' => 'Myanmar'                                                , 'isRegion' => false ],
    '108' => [ 'name' => 'Burundi'                                                , 'isRegion' => false ],
    '112' => [ 'name' => 'Belarus'                                                , 'isRegion' => false ],
    '116' => [ 'name' => 'Cambodia'                                               , 'isRegion' => false ],
    '120' => [ 'name' => 'Cameroon'                                               , 'isRegion' => false ],
    '124' => [ 'name' => 'Canada'                                                 , 'isRegion' => false ],
    '132' => [ 'name' => 'Cabo Verde'                                             , 'isRegion' => false ],
    '136' => [ 'name' => 'Cayman Islands'                                         , 'isRegion' => false ],
    '140' => [ 'name' => 'Central African Republic'                               , 'isRegion' => false ],
    '142' => [ 'name' => 'Asia'                                                   , 'isRegion' => true  ],
    '143' => [ 'name' => 'Central Asia'                                           , 'isRegion' => true  ],
    '144' => [ 'name' => 'Sri Lanka'                                              , 'isRegion' => false ],
    '145' => [ 'name' => 'Western Asia'                                           , 'isRegion' => true  ],
    '148' => [ 'name' => 'Chad'                                                   , 'isRegion' => false ],
    '150' => [ 'name' => 'Europe'                                                 , 'isRegion' => true  ],
    '151' => [ 'name' => 'Eastern Europe'                                         , 'isRegion' => true  ],
    '152' => [ 'name' => 'Chile'                                                  , 'isRegion' => false ],
    '154' => [ 'name' => 'Northern Europe'                                        , 'isRegion' => true  ],
    '155' => [ 'name' => 'Western Europe'                                         , 'isRegion' => true  ],
    '156' => [ 'name' => 'China'                                                  , 'isRegion' => false ],
    '158' => [ 'name' => 'Taiwan, Province of China'                              , 'isRegion' => false ],
    '162' => [ 'name' => 'Christmas Island'                                       , 'isRegion' => false ],
    '166' => [ 'name' => 'Cocos (Keeling) Islands'                                , 'isRegion' => false ],
    '170' => [ 'name' => 'Colombia'                                               , 'isRegion' => false ],
    '172' => [ 'name' => 'Commonwealth of Independent States'                     , 'isRegion' => true  ],
    '174' => [ 'name' => 'Comoros'                                                , 'isRegion' => false ],
    '175' => [ 'name' => 'Mayotte'                                                , 'isRegion' => false ],
    '178' => [ 'name' => 'Congo'                                                  , 'isRegion' => false ],
    '180' => [ 'name' => 'Congo, Democratic Republic of the'                      , 'isRegion' => false ],
    '184' => [ 'name' => 'Cook Islands'                                           , 'isRegion' => false ],
    '188' => [ 'name' => 'Costa Rica'                                             , 'isRegion' => false ],
    '191' => [ 'name' => 'Croatia'                                                , 'isRegion' => false ],
    '192' => [ 'name' => 'Cuba'                                                   , 'isRegion' => false ],
    '196' => [ 'name' => 'Cyprus'                                                 , 'isRegion' => false ],
    '199' => [ 'name' => 'Least Developed Countries'                              , 'isRegion' => true  ],
    '202' => [ 'name' => 'Sub-Saharan Africa'                                     , 'isRegion' => true  ],
    '203' => [ 'name' => 'Czechia'                                                , 'isRegion' => false ],
    '204' => [ 'name' => 'Benin'                                                  , 'isRegion' => false ],
    '208' => [ 'name' => 'Denmark'                                                , 'isRegion' => false ],
    '212' => [ 'name' => 'Dominica'                                               , 'isRegion' => false ],
    '214' => [ 'name' => 'Dominican Republic'                                     , 'isRegion' => false ],
    '218' => [ 'name' => 'Ecuador'                                                , 'isRegion' => false ],
    '222' => [ 'name' => 'El Salvador'                                            , 'isRegion' => false ],
    '226' => [ 'name' => 'Equatorial Guinea'                                      , 'isRegion' => false ],
    '231' => [ 'name' => 'Ethiopia'                                               , 'isRegion' => false ],
    '232' => [ 'name' => 'Eritrea'                                                , 'isRegion' => false ],
    '233' => [ 'name' => 'Estonia'                                                , 'isRegion' => false ],
    '234' => [ 'name' => 'Faroe Islands'                                          , 'isRegion' => false ],
    '238' => [ 'name' => 'Falkland Islands (Malvinas)'                            , 'isRegion' => false ],
    '239' => [ 'name' => 'South Georgia and the South Sandwich Islands'           , 'isRegion' => false ],
    '242' => [ 'name' => 'Fiji'                                                   , 'isRegion' => false ],
    '246' => [ 'name' => 'Finland'                                                , 'isRegion' => false ],
    '248' => [ 'name' => 'Åland Islands'                                          , 'isRegion' => false ],
    '250' => [ 'name' => 'France'                                                 , 'isRegion' => false ],
    '254' => [ 'name' => 'French Guiana'                                          , 'isRegion' => false ],
    '258' => [ 'name' => 'French Polynesia'                                       , 'isRegion' => false ],
    '260' => [ 'name' => 'French Southern Territories'                            , 'isRegion' => false ],
    '262' => [ 'name' => 'Djibouti'                                               , 'isRegion' => false ],
    '266' => [ 'name' => 'Gabon'                                                  , 'isRegion' => false ],
    '268' => [ 'name' => 'Georgia'                                                , 'isRegion' => false ],
    '270' => [ 'name' => 'Gambia'                                                 , 'isRegion' => false ],
    '275' => [ 'name' => 'Palestine, State of'                                    , 'isRegion' => false ],
    '276' => [ 'name' => 'Germany'                                                , 'isRegion' => false ],
    '288' => [ 'name' => 'Ghana'                                                  , 'isRegion' => false ],
    '292' => [ 'name' => 'Gibraltar'                                              , 'isRegion' => false ],
    '296' => [ 'name' => 'Kiribati'                                               , 'isRegion' => false ],
    '300' => [ 'name' => 'Greece'                                                 , 'isRegion' => false ],
    '304' => [ 'name' => 'Greenland'                                              , 'isRegion' => false ],
    '308' => [ 'name' => 'Grenada'                                                , 'isRegion' => false ],
    '312' => [ 'name' => 'Guadeloupe'                                             , 'isRegion' => false ],
    '316' => [ 'name' => 'Guam'                                                   , 'isRegion' => false ],
    '320' => [ 'name' => 'Guatemala'                                              , 'isRegion' => false ],
    '324' => [ 'name' => 'Guinea'                                                 , 'isRegion' => false ],
    '328' => [ 'name' => 'Guyana'                                                 , 'isRegion' => false ],
    '332' => [ 'name' => 'Haiti'                                                  , 'isRegion' => false ],
    '334' => [ 'name' => 'Heard Island and McDonald Islands'                      , 'isRegion' => false ],
    '336' => [ 'name' => 'Holy See'                                               , 'isRegion' => false ],
    '340' => [ 'name' => 'Honduras'                                               , 'isRegion' => false ],
    '344' => [ 'name' => 'Hong Kong'                                              , 'isRegion' => false ],
    '348' => [ 'name' => 'Hungary'                                                , 'isRegion' => false ],
    '352' => [ 'name' => 'Iceland'                                                , 'isRegion' => false ],
    '356' => [ 'name' => 'India'                                                  , 'isRegion' => false ],
    '360' => [ 'name' => 'Indonesia'                                              , 'isRegion' => false ],
    '364' => [ 'name' => 'Iran, Islamic Republic of'                              , 'isRegion' => false ],
    '368' => [ 'name' => 'Iraq'                                                   , 'isRegion' => false ],
    '372' => [ 'name' => 'Ireland'                                                , 'isRegion' => false ],
    '376' => [ 'name' => 'Israel'                                                 , 'isRegion' => false ],
    '380' => [ 'name' => 'Italy'                                                  , 'isRegion' => false ],
    '384' => [ 'name' => "Côte d'Ivoire"                                          , 'isRegion' => false ],
    '388' => [ 'name' => 'Jamaica'                                                , 'isRegion' => false ],
    '392' => [ 'name' => 'Japan'                                                  , 'isRegion' => false ],
    '398' => [ 'name' => 'Kazakhstan'                                             , 'isRegion' => false ],
    '400' => [ 'name' => 'Jordan'                                                 , 'isRegion' => false ],
    '404' => [ 'name' => 'Kenya'                                                  , 'isRegion' => false ],
    '408' => [ 'name' => "Korea, Democratic People's Republic of"                 , 'isRegion' => false ],
    '410' => [ 'name' => 'Korea, Republic of'                                     , 'isRegion' => false ],
    '414' => [ 'name' => 'Kuwait'                                                 , 'isRegion' => false ],
    '417' => [ 'name' => 'Kyrgyzstan'                                             , 'isRegion' => false ],
    '418' => [ 'name' => "Lao People's Democratic Republic"                       , 'isRegion' => false ],
    '419' => [ 'name' => 'Latin America and the Caribbean'                        , 'isRegion' => true  ],
    '422' => [ 'name' => 'Lebanon'                                                , 'isRegion' => false ],
    '426' => [ 'name' => 'Lesotho'                                                , 'isRegion' => false ],
    '428' => [ 'name' => 'Latvia'                                                 , 'isRegion' => false ],
    '430' => [ 'name' => 'Liberia'                                                , 'isRegion' => false ],
    '432' => [ 'name' => 'Landlocked Developing Countries'                        , 'isRegion' => true  ],
    '434' => [ 'name' => 'Libya'                                                  , 'isRegion' => false ],
    '438' => [ 'name' => 'Liechtenstein'                                          , 'isRegion' => false ],
    '440' => [ 'name' => 'Lithuania'                                              , 'isRegion' => false ],
    '442' => [ 'name' => 'Luxembourg'                                             , 'isRegion' => false ],
    '446' => [ 'name' => 'Macao'                                                  , 'isRegion' => false ],
    '450' => [ 'name' => 'Madagascar'                                             , 'isRegion' => false ],
    '454' => [ 'name' => 'Malawi'                                                 , 'isRegion' => false ],
    '458' => [ 'name' => 'Malaysia'                                               , 'isRegion' => false ],
    '462' => [ 'name' => 'Maldives'                                               , 'isRegion' => false ],
    '466' => [ 'name' => 'Mali'                                                   , 'isRegion' => false ],
    '470' => [ 'name' => 'Malta'                                                  , 'isRegion' => false ],
    '474' => [ 'name' => 'Martinique'                                             , 'isRegion' => false ],
    '478' => [ 'name' => 'Mauritania'                                             , 'isRegion' => false ],
    '480' => [ 'name' => 'Mauritius'                                              , 'isRegion' => false ],
    '484' => [ 'name' => 'Mexico'                                                 , 'isRegion' => false ],
    '492' => [ 'name' => 'Monaco'                                                 , 'isRegion' => false ],
    '496' => [ 'name' => 'Mongolia'                                               , 'isRegion' => false ],
    '498' => [ 'name' => 'Moldova, Republic of'                                   , 'isRegion' => false ],
    '499' => [ 'name' => 'Montenegro'                                             , 'isRegion' => false ],
    '500' => [ 'name' => 'Montserrat'                                             , 'isRegion' => false ],
    '504' => [ 'name' => 'Morocco'                                                , 'isRegion' => false ],
    '508' => [ 'name' => 'Mozambique'                                             , 'isRegion' => false ],
    '512' => [ 'name' => 'Oman'                                                   , 'isRegion' => false ],
    '516' => [ 'name' => 'Namibia'                                                , 'isRegion' => false ],
    '520' => [ 'name' => 'Nauru'                                                  , 'isRegion' => false ],
    '524' => [ 'name' => 'Nepal'                                                  , 'isRegion' => false ],
    '528' => [ 'name' => 'Netherlands, Kingdom of the'                            , 'isRegion' => false ],
    '531' => [ 'name' => 'Curaçao'                                                , 'isRegion' => false ],
    '533' => [ 'name' => 'Aruba'                                                  , 'isRegion' => false ],
    '534' => [ 'name' => 'Sint Maarten (Dutch part)'                              , 'isRegion' => false ],
    '535' => [ 'name' => 'Bonaire, Sint Eustatius and Saba'                       , 'isRegion' => false ],
    '540' => [ 'name' => 'New Caledonia'                                          , 'isRegion' => false ],
    '548' => [ 'name' => 'Vanuatu'                                                , 'isRegion' => false ],
    '554' => [ 'name' => 'New Zealand'                                            , 'isRegion' => false ],
    '558' => [ 'name' => 'Nicaragua'                                              , 'isRegion' => false ],
    '562' => [ 'name' => 'Niger'                                                  , 'isRegion' => false ],
    '566' => [ 'name' => 'Nigeria'                                                , 'isRegion' => false ],
    '570' => [ 'name' => 'Niue'                                                   , 'isRegion' => false ],
    '574' => [ 'name' => 'Norfolk Island'                                         , 'isRegion' => false ],
    '578' => [ 'name' => 'Norway'                                                 , 'isRegion' => false ],
    '580' => [ 'name' => 'Northern Mariana Islands'                               , 'isRegion' => false ],
    '581' => [ 'name' => 'United States Minor Outlying Islands'                   , 'isRegion' => false ],
    '583' => [ 'name' => 'Micronesia, Federated States of'                        , 'isRegion' => false ],
    '584' => [ 'name' => 'Marshall Islands'                                       , 'isRegion' => false ],
    '585' => [ 'name' => 'Palau'                                                  , 'isRegion' => false ],
    '586' => [ 'name' => 'Pakistan'                                               , 'isRegion' => false ],
    '591' => [ 'name' => 'Panama'                                                 , 'isRegion' => false ],
    '598' => [ 'name' => 'Papua New Guinea'                                       , 'isRegion' => false ],
    '600' => [ 'name' => 'Paraguay'                                               , 'isRegion' => false ],
    '604' => [ 'name' => 'Peru'                                                   , 'isRegion' => false ],
    '608' => [ 'name' => 'Philippines'                                            , 'isRegion' => false ],
    '612' => [ 'name' => 'Pitcairn'                                               , 'isRegion' => false ],
    '616' => [ 'name' => 'Poland'                                                 , 'isRegion' => false ],
    '620' => [ 'name' => 'Portugal'                                               , 'isRegion' => false ],
    '624' => [ 'name' => 'Guinea-Bissau'                                          , 'isRegion' => false ],
    '626' => [ 'name' => 'Timor-Leste'                                            , 'isRegion' => false ],
    '630' => [ 'name' => 'Puerto Rico'                                            , 'isRegion' => false ],
    '634' => [ 'name' => 'Qatar'                                                  , 'isRegion' => false ],
    '638' => [ 'name' => 'Réunion'                                                , 'isRegion' => false ],
    '642' => [ 'name' => 'Romania'                                                , 'isRegion' => false ],
    '643' => [ 'name' => 'Russian Federation'                                     , 'isRegion' => false ],
    '646' => [ 'name' => 'Rwanda'                                                 , 'isRegion' => false ],
    '652' => [ 'name' => 'Saint Barthélemy'                                       , 'isRegion' => false ],
    '654' => [ 'name' => 'Saint Helena, Ascension and Tristan da Cunha'           , 'isRegion' => false ],
    '659' => [ 'name' => 'Saint Kitts and Nevis'                                  , 'isRegion' => false ],
    '660' => [ 'name' => 'Anguilla'                                               , 'isRegion' => false ],
    '662' => [ 'name' => 'Saint Lucia'                                            , 'isRegion' => false ],
    '663' => [ 'name' => 'Saint Martin (French part)'                             , 'isRegion' => false ],
    '666' => [ 'name' => 'Saint Pierre and Miquelon'                              , 'isRegion' => false ],
    '670' => [ 'name' => 'Saint Vincent and the Grenadines'                       , 'isRegion' => false ],
    '674' => [ 'name' => 'San Marino'                                             , 'isRegion' => false ],
    '678' => [ 'name' => 'Sao Tome and Principe'                                  , 'isRegion' => false ],
    '682' => [ 'name' => 'Saudi Arabia'                                           , 'isRegion' => false ],
    '686' => [ 'name' => 'Senegal'                                                , 'isRegion' => false ],
    '688' => [ 'name' => 'Serbia'                                                 , 'isRegion' => false ],
    '690' => [ 'name' => 'Seychelles'                                             , 'isRegion' => false ],
    '694' => [ 'name' => 'Sierra Leone'                                           , 'isRegion' => false ],
    '702' => [ 'name' => 'Singapore'                                              , 'isRegion' => false ],
    '703' => [ 'name' => 'Slovakia'                                               , 'isRegion' => false ],
    '704' => [ 'name' => 'Viet Nam'                                               , 'isRegion' => false ],
    '705' => [ 'name' => 'Slovenia'                                               , 'isRegion' => false ],
    '706' => [ 'name' => 'Somalia'                                                , 'isRegion' => false ],
    '710' => [ 'name' => 'South Africa'                                           , 'isRegion' => false ],
    '716' => [ 'name' => 'Zimbabwe'                                               , 'isRegion' => false ],
    '722' => [ 'name' => 'Small Island Developing States'                         , 'isRegion' => true  ],
    '724' => [ 'name' => 'Spain'                                                  , 'isRegion' => false ],
    '728' => [ 'name' => 'South Sudan'                                            , 'isRegion' => false ],
    '729' => [ 'name' => 'Sudan'                                                  , 'isRegion' => false ],
    '732' => [ 'name' => 'Western Sahara'                                         , 'isRegion' => false ],
    '740' => [ 'name' => 'Suriname'                                               , 'isRegion' => false ],
    '744' => [ 'name' => 'Svalbard and Jan Mayen'                                 , 'isRegion' => false ],
    '748' => [ 'name' => 'Eswatini'                                               , 'isRegion' => false ],
    '752' => [ 'name' => 'Sweden'                                                 , 'isRegion' => false ],
    '756' => [ 'name' => 'Switzerland'                                            , 'isRegion' => false ],
    '760' => [ 'name' => 'Syrian Arab Republic'                                   , 'isRegion' => false ],
    '762' => [ 'name' => 'Tajikistan'                                             , 'isRegion' => false ],
    '764' => [ 'name' => 'Thailand'                                               , 'isRegion' => false ],
    '768' => [ 'name' => 'Togo'                                                   , 'isRegion' => false ],
    '772' => [ 'name' => 'Tokelau'                                                , 'isRegion' => false ],
    '776' => [ 'name' => 'Tonga'                                                  , 'isRegion' => false ],
    '778' => [ 'name' => 'Transition countries'                                   , 'isRegion' => true  ],
    '780' => [ 'name' => 'Trinidad and Tobago'                                    , 'isRegion' => false ],
    '784' => [ 'name' => 'United Arab Emirates'                                   , 'isRegion' => false ],
    '788' => [ 'name' => 'Tunisia'                                                , 'isRegion' => false ],
    '792' => [ 'name' => 'Türkiye'                                                , 'isRegion' => false ],
    '795' => [ 'name' => 'Turkmenistan'                                           , 'isRegion' => false ],
    '796' => [ 'name' => 'Turks and Caicos Islands'                               , 'isRegion' => false ],
    '798' => [ 'name' => 'Tuvalu'                                                 , 'isRegion' => false ],
    '800' => [ 'name' => 'Uganda'                                                 , 'isRegion' => false ],
    '804' => [ 'name' => 'Ukraine'                                                , 'isRegion' => false ],
    '807' => [ 'name' => 'North Macedonia'                                        , 'isRegion' => false ],
    '818' => [ 'name' => 'Egypt'                                                  , 'isRegion' => false ],
    '826' => [ 'name' => 'United Kingdom of Great Britain and Northern Ireland'   , 'isRegion' => false ],
    '831' => [ 'name' => 'Guernsey'                                               , 'isRegion' => false ],
    '832' => [ 'name' => 'Jersey'                                                 , 'isRegion' => false ],
    '833' => [ 'name' => 'Isle of Man'                                            , 'isRegion' => false ],
    '834' => [ 'name' => 'Tanzania, United Republic of'                           , 'isRegion' => false ],
    '840' => [ 'name' => 'United States of America'                               , 'isRegion' => false ],
    '850' => [ 'name' => 'Virgin Islands (U.S.)'                                  , 'isRegion' => false ],
    '854' => [ 'name' => 'Burkina Faso'                                           , 'isRegion' => false ],
    '858' => [ 'name' => 'Uruguay'                                                , 'isRegion' => false ],
    '860' => [ 'name' => 'Uzbekistan'                                             , 'isRegion' => false ],
    '862' => [ 'name' => 'Venezuela, Bolivarian Republic of'                      , 'isRegion' => false ],
    '876' => [ 'name' => 'Wallis and Futuna'                                      , 'isRegion' => false ],
    '882' => [ 'name' => 'Samoa'                                                  , 'isRegion' => false ],
    '887' => [ 'name' => 'Yemen'                                                  , 'isRegion' => false ],
    '894' => [ 'name' => 'Zambia'                                                 , 'isRegion' => false ],
];

function generatePhpClass(): string
{
    $entries = DATASET ;
    ksort( $entries ) ;

    $header = <<<'PHP'
<?php

namespace org\unstats;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants representing the numeric codes of the UN M49 standard.
 *
 * The UN M49 standard (Standard Country or Area Codes for Statistical Use) is maintained
 * by the United Nations Statistics Division. It assigns a 3-digit numeric code to:
 * - **countries and areas** (overlap with ISO 3166-1 numeric, e.g. `004` Afghanistan,
 *   `250` France, `840` United States of America),
 * - **geographical regions** (continents, sub-regions, special groupings: `001` World,
 *   `019` Americas, `142` Asia, `150` Europe, `419` Latin America and the Caribbean, …).
 *
 * In **IETF BCP 47 / RFC 5646** locale tags, only the M49 region codes that do **not**
 * also have an ISO 3166-1 alpha-2 equivalent are allowed as `region` subtags (e.g.
 * `es-419` for Latin American Spanish). This class lists the full M49 numeric catalog;
 * see {@see \org\ietf\helpers\isLocale} for the BCP 47-specific filtering.
 *
 * Constants are named `M_<code>` (the `M_` prefix is mandatory because PHP identifiers
 * cannot start with a digit). The string value always preserves the 3-digit zero-padded
 * form, e.g. `'004'`, not `'4'`.
 *
 * Example usage:
 *   $country = UNM49Numeric::M_250;  // '250' for France
 *   $region  = UNM49Numeric::M_419;  // '419' for Latin America and the Caribbean
 *
 *   UNM49Numeric::includes('001');   // true (World)
 *   UNM49Numeric::includes('999');   // false
 *
 * @see \org\unstats\UNM49 Alpha-3 form (FRA, USA, …) of the same standard
 * @see \org\iso\ISO3166_1 Alpha-2 form (FR, US, …)
 * @see https://unstats.un.org/unsd/methodology/m49/ Official UN M49 standard
 * @see https://en.wikipedia.org/wiki/UN_M49 Wikipedia: UN M49
 *
 * @package org\unstats
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class UNM49Numeric
{
    use ConstantsTrait;

PHP;

    $body = '' ;
    foreach ( $entries as $code => $entry )
    {
        $name     = $entry[ 'name' ] ;
        $isRegion = $entry[ 'isRegion' ] ;
        $suffix   = $isRegion ? ' (M49 region)' : '' ;
        $doc      = rtrim( $name , '.' ) . $suffix . '.' ;

        $body .= <<<PHP

    /**
     * {$doc}
     */
    public const string M_{$code} = '{$code}';

PHP;
    }

    return $header . $body . "}\n" ;
}

function main(): void
{
    echo sprintf( "Dataset: %d entries (%d regions, %d countries).\n" ,
        count( DATASET ) ,
        count( array_filter( DATASET , fn( $e ) => $e[ 'isRegion' ] ) ) ,
        count( array_filter( DATASET , fn( $e ) => !$e[ 'isRegion' ] ) )
    ) ;

    echo "Generating PHP class...\n" ;
    $php = generatePhpClass() ;

    file_put_contents( TARGET_FILE , $php ) ;
    echo "Wrote " . TARGET_FILE . "\n" ;

    echo "Done.\n" ;
}

main() ;
