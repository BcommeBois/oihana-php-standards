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

    /**
     * World (M49 region).
     */
    public const string M_001 = '001';

    /**
     * Africa (M49 region).
     */
    public const string M_002 = '002';

    /**
     * North America (M49 region).
     */
    public const string M_003 = '003';

    /**
     * Afghanistan.
     */
    public const string M_004 = '004';

    /**
     * South America (M49 region).
     */
    public const string M_005 = '005';

    /**
     * Albania.
     */
    public const string M_008 = '008';

    /**
     * Oceania (M49 region).
     */
    public const string M_009 = '009';

    /**
     * Antarctica (M49 region).
     */
    public const string M_010 = '010';

    /**
     * Western Africa (M49 region).
     */
    public const string M_011 = '011';

    /**
     * Algeria.
     */
    public const string M_012 = '012';

    /**
     * Central America (M49 region).
     */
    public const string M_013 = '013';

    /**
     * Eastern Africa (M49 region).
     */
    public const string M_014 = '014';

    /**
     * Northern Africa (M49 region).
     */
    public const string M_015 = '015';

    /**
     * American Samoa.
     */
    public const string M_016 = '016';

    /**
     * Middle Africa (M49 region).
     */
    public const string M_017 = '017';

    /**
     * Southern Africa (M49 region).
     */
    public const string M_018 = '018';

    /**
     * Americas (M49 region).
     */
    public const string M_019 = '019';

    /**
     * Andorra.
     */
    public const string M_020 = '020';

    /**
     * Northern America (M49 region).
     */
    public const string M_021 = '021';

    /**
     * Angola.
     */
    public const string M_024 = '024';

    /**
     * Antigua and Barbuda.
     */
    public const string M_028 = '028';

    /**
     * Caribbean (M49 region).
     */
    public const string M_029 = '029';

    /**
     * Eastern Asia (M49 region).
     */
    public const string M_030 = '030';

    /**
     * Azerbaijan.
     */
    public const string M_031 = '031';

    /**
     * Argentina.
     */
    public const string M_032 = '032';

    /**
     * Southern Asia (M49 region).
     */
    public const string M_034 = '034';

    /**
     * South-eastern Asia (M49 region).
     */
    public const string M_035 = '035';

    /**
     * Australia.
     */
    public const string M_036 = '036';

    /**
     * Southern Europe (M49 region).
     */
    public const string M_039 = '039';

    /**
     * Austria.
     */
    public const string M_040 = '040';

    /**
     * Bahamas.
     */
    public const string M_044 = '044';

    /**
     * Bahrain.
     */
    public const string M_048 = '048';

    /**
     * Bangladesh.
     */
    public const string M_050 = '050';

    /**
     * Armenia.
     */
    public const string M_051 = '051';

    /**
     * Barbados.
     */
    public const string M_052 = '052';

    /**
     * Australia and New Zealand (M49 region).
     */
    public const string M_053 = '053';

    /**
     * Melanesia (M49 region).
     */
    public const string M_054 = '054';

    /**
     * Belgium.
     */
    public const string M_056 = '056';

    /**
     * Micronesia (M49 region).
     */
    public const string M_057 = '057';

    /**
     * Bermuda.
     */
    public const string M_060 = '060';

    /**
     * Polynesia (M49 region).
     */
    public const string M_061 = '061';

    /**
     * Bhutan.
     */
    public const string M_064 = '064';

    /**
     * Bolivia, Plurinational State of.
     */
    public const string M_068 = '068';

    /**
     * Bosnia and Herzegovina.
     */
    public const string M_070 = '070';

    /**
     * Botswana.
     */
    public const string M_072 = '072';

    /**
     * Bouvet Island.
     */
    public const string M_074 = '074';

    /**
     * Brazil.
     */
    public const string M_076 = '076';

    /**
     * Belize.
     */
    public const string M_084 = '084';

    /**
     * British Indian Ocean Territory.
     */
    public const string M_086 = '086';

    /**
     * Solomon Islands.
     */
    public const string M_090 = '090';

    /**
     * Virgin Islands (British).
     */
    public const string M_092 = '092';

    /**
     * Brunei Darussalam.
     */
    public const string M_096 = '096';

    /**
     * Bulgaria.
     */
    public const string M_100 = '100';

    /**
     * Myanmar.
     */
    public const string M_104 = '104';

    /**
     * Burundi.
     */
    public const string M_108 = '108';

    /**
     * Belarus.
     */
    public const string M_112 = '112';

    /**
     * Cambodia.
     */
    public const string M_116 = '116';

    /**
     * Cameroon.
     */
    public const string M_120 = '120';

    /**
     * Canada.
     */
    public const string M_124 = '124';

    /**
     * Cabo Verde.
     */
    public const string M_132 = '132';

    /**
     * Cayman Islands.
     */
    public const string M_136 = '136';

    /**
     * Central African Republic.
     */
    public const string M_140 = '140';

    /**
     * Asia (M49 region).
     */
    public const string M_142 = '142';

    /**
     * Central Asia (M49 region).
     */
    public const string M_143 = '143';

    /**
     * Sri Lanka.
     */
    public const string M_144 = '144';

    /**
     * Western Asia (M49 region).
     */
    public const string M_145 = '145';

    /**
     * Chad.
     */
    public const string M_148 = '148';

    /**
     * Europe (M49 region).
     */
    public const string M_150 = '150';

    /**
     * Eastern Europe (M49 region).
     */
    public const string M_151 = '151';

    /**
     * Chile.
     */
    public const string M_152 = '152';

    /**
     * Northern Europe (M49 region).
     */
    public const string M_154 = '154';

    /**
     * Western Europe (M49 region).
     */
    public const string M_155 = '155';

    /**
     * China.
     */
    public const string M_156 = '156';

    /**
     * Taiwan, Province of China.
     */
    public const string M_158 = '158';

    /**
     * Christmas Island.
     */
    public const string M_162 = '162';

    /**
     * Cocos (Keeling) Islands.
     */
    public const string M_166 = '166';

    /**
     * Colombia.
     */
    public const string M_170 = '170';

    /**
     * Commonwealth of Independent States (M49 region).
     */
    public const string M_172 = '172';

    /**
     * Comoros.
     */
    public const string M_174 = '174';

    /**
     * Mayotte.
     */
    public const string M_175 = '175';

    /**
     * Congo.
     */
    public const string M_178 = '178';

    /**
     * Congo, Democratic Republic of the.
     */
    public const string M_180 = '180';

    /**
     * Cook Islands.
     */
    public const string M_184 = '184';

    /**
     * Costa Rica.
     */
    public const string M_188 = '188';

    /**
     * Croatia.
     */
    public const string M_191 = '191';

    /**
     * Cuba.
     */
    public const string M_192 = '192';

    /**
     * Cyprus.
     */
    public const string M_196 = '196';

    /**
     * Least Developed Countries (M49 region).
     */
    public const string M_199 = '199';

    /**
     * Sub-Saharan Africa (M49 region).
     */
    public const string M_202 = '202';

    /**
     * Czechia.
     */
    public const string M_203 = '203';

    /**
     * Benin.
     */
    public const string M_204 = '204';

    /**
     * Denmark.
     */
    public const string M_208 = '208';

    /**
     * Dominica.
     */
    public const string M_212 = '212';

    /**
     * Dominican Republic.
     */
    public const string M_214 = '214';

    /**
     * Ecuador.
     */
    public const string M_218 = '218';

    /**
     * El Salvador.
     */
    public const string M_222 = '222';

    /**
     * Equatorial Guinea.
     */
    public const string M_226 = '226';

    /**
     * Ethiopia.
     */
    public const string M_231 = '231';

    /**
     * Eritrea.
     */
    public const string M_232 = '232';

    /**
     * Estonia.
     */
    public const string M_233 = '233';

    /**
     * Faroe Islands.
     */
    public const string M_234 = '234';

    /**
     * Falkland Islands (Malvinas).
     */
    public const string M_238 = '238';

    /**
     * South Georgia and the South Sandwich Islands.
     */
    public const string M_239 = '239';

    /**
     * Fiji.
     */
    public const string M_242 = '242';

    /**
     * Finland.
     */
    public const string M_246 = '246';

    /**
     * Åland Islands.
     */
    public const string M_248 = '248';

    /**
     * France.
     */
    public const string M_250 = '250';

    /**
     * French Guiana.
     */
    public const string M_254 = '254';

    /**
     * French Polynesia.
     */
    public const string M_258 = '258';

    /**
     * French Southern Territories.
     */
    public const string M_260 = '260';

    /**
     * Djibouti.
     */
    public const string M_262 = '262';

    /**
     * Gabon.
     */
    public const string M_266 = '266';

    /**
     * Georgia.
     */
    public const string M_268 = '268';

    /**
     * Gambia.
     */
    public const string M_270 = '270';

    /**
     * Palestine, State of.
     */
    public const string M_275 = '275';

    /**
     * Germany.
     */
    public const string M_276 = '276';

    /**
     * Ghana.
     */
    public const string M_288 = '288';

    /**
     * Gibraltar.
     */
    public const string M_292 = '292';

    /**
     * Kiribati.
     */
    public const string M_296 = '296';

    /**
     * Greece.
     */
    public const string M_300 = '300';

    /**
     * Greenland.
     */
    public const string M_304 = '304';

    /**
     * Grenada.
     */
    public const string M_308 = '308';

    /**
     * Guadeloupe.
     */
    public const string M_312 = '312';

    /**
     * Guam.
     */
    public const string M_316 = '316';

    /**
     * Guatemala.
     */
    public const string M_320 = '320';

    /**
     * Guinea.
     */
    public const string M_324 = '324';

    /**
     * Guyana.
     */
    public const string M_328 = '328';

    /**
     * Haiti.
     */
    public const string M_332 = '332';

    /**
     * Heard Island and McDonald Islands.
     */
    public const string M_334 = '334';

    /**
     * Holy See.
     */
    public const string M_336 = '336';

    /**
     * Honduras.
     */
    public const string M_340 = '340';

    /**
     * Hong Kong.
     */
    public const string M_344 = '344';

    /**
     * Hungary.
     */
    public const string M_348 = '348';

    /**
     * Iceland.
     */
    public const string M_352 = '352';

    /**
     * India.
     */
    public const string M_356 = '356';

    /**
     * Indonesia.
     */
    public const string M_360 = '360';

    /**
     * Iran, Islamic Republic of.
     */
    public const string M_364 = '364';

    /**
     * Iraq.
     */
    public const string M_368 = '368';

    /**
     * Ireland.
     */
    public const string M_372 = '372';

    /**
     * Israel.
     */
    public const string M_376 = '376';

    /**
     * Italy.
     */
    public const string M_380 = '380';

    /**
     * Côte d'Ivoire.
     */
    public const string M_384 = '384';

    /**
     * Jamaica.
     */
    public const string M_388 = '388';

    /**
     * Japan.
     */
    public const string M_392 = '392';

    /**
     * Kazakhstan.
     */
    public const string M_398 = '398';

    /**
     * Jordan.
     */
    public const string M_400 = '400';

    /**
     * Kenya.
     */
    public const string M_404 = '404';

    /**
     * Korea, Democratic People's Republic of.
     */
    public const string M_408 = '408';

    /**
     * Korea, Republic of.
     */
    public const string M_410 = '410';

    /**
     * Kuwait.
     */
    public const string M_414 = '414';

    /**
     * Kyrgyzstan.
     */
    public const string M_417 = '417';

    /**
     * Lao People's Democratic Republic.
     */
    public const string M_418 = '418';

    /**
     * Latin America and the Caribbean (M49 region).
     */
    public const string M_419 = '419';

    /**
     * Lebanon.
     */
    public const string M_422 = '422';

    /**
     * Lesotho.
     */
    public const string M_426 = '426';

    /**
     * Latvia.
     */
    public const string M_428 = '428';

    /**
     * Liberia.
     */
    public const string M_430 = '430';

    /**
     * Landlocked Developing Countries (M49 region).
     */
    public const string M_432 = '432';

    /**
     * Libya.
     */
    public const string M_434 = '434';

    /**
     * Liechtenstein.
     */
    public const string M_438 = '438';

    /**
     * Lithuania.
     */
    public const string M_440 = '440';

    /**
     * Luxembourg.
     */
    public const string M_442 = '442';

    /**
     * Macao.
     */
    public const string M_446 = '446';

    /**
     * Madagascar.
     */
    public const string M_450 = '450';

    /**
     * Malawi.
     */
    public const string M_454 = '454';

    /**
     * Malaysia.
     */
    public const string M_458 = '458';

    /**
     * Maldives.
     */
    public const string M_462 = '462';

    /**
     * Mali.
     */
    public const string M_466 = '466';

    /**
     * Malta.
     */
    public const string M_470 = '470';

    /**
     * Martinique.
     */
    public const string M_474 = '474';

    /**
     * Mauritania.
     */
    public const string M_478 = '478';

    /**
     * Mauritius.
     */
    public const string M_480 = '480';

    /**
     * Mexico.
     */
    public const string M_484 = '484';

    /**
     * Monaco.
     */
    public const string M_492 = '492';

    /**
     * Mongolia.
     */
    public const string M_496 = '496';

    /**
     * Moldova, Republic of.
     */
    public const string M_498 = '498';

    /**
     * Montenegro.
     */
    public const string M_499 = '499';

    /**
     * Montserrat.
     */
    public const string M_500 = '500';

    /**
     * Morocco.
     */
    public const string M_504 = '504';

    /**
     * Mozambique.
     */
    public const string M_508 = '508';

    /**
     * Oman.
     */
    public const string M_512 = '512';

    /**
     * Namibia.
     */
    public const string M_516 = '516';

    /**
     * Nauru.
     */
    public const string M_520 = '520';

    /**
     * Nepal.
     */
    public const string M_524 = '524';

    /**
     * Netherlands, Kingdom of the.
     */
    public const string M_528 = '528';

    /**
     * Curaçao.
     */
    public const string M_531 = '531';

    /**
     * Aruba.
     */
    public const string M_533 = '533';

    /**
     * Sint Maarten (Dutch part).
     */
    public const string M_534 = '534';

    /**
     * Bonaire, Sint Eustatius and Saba.
     */
    public const string M_535 = '535';

    /**
     * New Caledonia.
     */
    public const string M_540 = '540';

    /**
     * Vanuatu.
     */
    public const string M_548 = '548';

    /**
     * New Zealand.
     */
    public const string M_554 = '554';

    /**
     * Nicaragua.
     */
    public const string M_558 = '558';

    /**
     * Niger.
     */
    public const string M_562 = '562';

    /**
     * Nigeria.
     */
    public const string M_566 = '566';

    /**
     * Niue.
     */
    public const string M_570 = '570';

    /**
     * Norfolk Island.
     */
    public const string M_574 = '574';

    /**
     * Norway.
     */
    public const string M_578 = '578';

    /**
     * Northern Mariana Islands.
     */
    public const string M_580 = '580';

    /**
     * United States Minor Outlying Islands.
     */
    public const string M_581 = '581';

    /**
     * Micronesia, Federated States of.
     */
    public const string M_583 = '583';

    /**
     * Marshall Islands.
     */
    public const string M_584 = '584';

    /**
     * Palau.
     */
    public const string M_585 = '585';

    /**
     * Pakistan.
     */
    public const string M_586 = '586';

    /**
     * Panama.
     */
    public const string M_591 = '591';

    /**
     * Papua New Guinea.
     */
    public const string M_598 = '598';

    /**
     * Paraguay.
     */
    public const string M_600 = '600';

    /**
     * Peru.
     */
    public const string M_604 = '604';

    /**
     * Philippines.
     */
    public const string M_608 = '608';

    /**
     * Pitcairn.
     */
    public const string M_612 = '612';

    /**
     * Poland.
     */
    public const string M_616 = '616';

    /**
     * Portugal.
     */
    public const string M_620 = '620';

    /**
     * Guinea-Bissau.
     */
    public const string M_624 = '624';

    /**
     * Timor-Leste.
     */
    public const string M_626 = '626';

    /**
     * Puerto Rico.
     */
    public const string M_630 = '630';

    /**
     * Qatar.
     */
    public const string M_634 = '634';

    /**
     * Réunion.
     */
    public const string M_638 = '638';

    /**
     * Romania.
     */
    public const string M_642 = '642';

    /**
     * Russian Federation.
     */
    public const string M_643 = '643';

    /**
     * Rwanda.
     */
    public const string M_646 = '646';

    /**
     * Saint Barthélemy.
     */
    public const string M_652 = '652';

    /**
     * Saint Helena, Ascension and Tristan da Cunha.
     */
    public const string M_654 = '654';

    /**
     * Saint Kitts and Nevis.
     */
    public const string M_659 = '659';

    /**
     * Anguilla.
     */
    public const string M_660 = '660';

    /**
     * Saint Lucia.
     */
    public const string M_662 = '662';

    /**
     * Saint Martin (French part).
     */
    public const string M_663 = '663';

    /**
     * Saint Pierre and Miquelon.
     */
    public const string M_666 = '666';

    /**
     * Saint Vincent and the Grenadines.
     */
    public const string M_670 = '670';

    /**
     * San Marino.
     */
    public const string M_674 = '674';

    /**
     * Sao Tome and Principe.
     */
    public const string M_678 = '678';

    /**
     * Saudi Arabia.
     */
    public const string M_682 = '682';

    /**
     * Senegal.
     */
    public const string M_686 = '686';

    /**
     * Serbia.
     */
    public const string M_688 = '688';

    /**
     * Seychelles.
     */
    public const string M_690 = '690';

    /**
     * Sierra Leone.
     */
    public const string M_694 = '694';

    /**
     * Singapore.
     */
    public const string M_702 = '702';

    /**
     * Slovakia.
     */
    public const string M_703 = '703';

    /**
     * Viet Nam.
     */
    public const string M_704 = '704';

    /**
     * Slovenia.
     */
    public const string M_705 = '705';

    /**
     * Somalia.
     */
    public const string M_706 = '706';

    /**
     * South Africa.
     */
    public const string M_710 = '710';

    /**
     * Zimbabwe.
     */
    public const string M_716 = '716';

    /**
     * Small Island Developing States (M49 region).
     */
    public const string M_722 = '722';

    /**
     * Spain.
     */
    public const string M_724 = '724';

    /**
     * South Sudan.
     */
    public const string M_728 = '728';

    /**
     * Sudan.
     */
    public const string M_729 = '729';

    /**
     * Western Sahara.
     */
    public const string M_732 = '732';

    /**
     * Suriname.
     */
    public const string M_740 = '740';

    /**
     * Svalbard and Jan Mayen.
     */
    public const string M_744 = '744';

    /**
     * Eswatini.
     */
    public const string M_748 = '748';

    /**
     * Sweden.
     */
    public const string M_752 = '752';

    /**
     * Switzerland.
     */
    public const string M_756 = '756';

    /**
     * Syrian Arab Republic.
     */
    public const string M_760 = '760';

    /**
     * Tajikistan.
     */
    public const string M_762 = '762';

    /**
     * Thailand.
     */
    public const string M_764 = '764';

    /**
     * Togo.
     */
    public const string M_768 = '768';

    /**
     * Tokelau.
     */
    public const string M_772 = '772';

    /**
     * Tonga.
     */
    public const string M_776 = '776';

    /**
     * Transition countries (M49 region).
     */
    public const string M_778 = '778';

    /**
     * Trinidad and Tobago.
     */
    public const string M_780 = '780';

    /**
     * United Arab Emirates.
     */
    public const string M_784 = '784';

    /**
     * Tunisia.
     */
    public const string M_788 = '788';

    /**
     * Türkiye.
     */
    public const string M_792 = '792';

    /**
     * Turkmenistan.
     */
    public const string M_795 = '795';

    /**
     * Turks and Caicos Islands.
     */
    public const string M_796 = '796';

    /**
     * Tuvalu.
     */
    public const string M_798 = '798';

    /**
     * Uganda.
     */
    public const string M_800 = '800';

    /**
     * Ukraine.
     */
    public const string M_804 = '804';

    /**
     * North Macedonia.
     */
    public const string M_807 = '807';

    /**
     * Egypt.
     */
    public const string M_818 = '818';

    /**
     * United Kingdom of Great Britain and Northern Ireland.
     */
    public const string M_826 = '826';

    /**
     * Guernsey.
     */
    public const string M_831 = '831';

    /**
     * Jersey.
     */
    public const string M_832 = '832';

    /**
     * Isle of Man.
     */
    public const string M_833 = '833';

    /**
     * Tanzania, United Republic of.
     */
    public const string M_834 = '834';

    /**
     * United States of America.
     */
    public const string M_840 = '840';

    /**
     * Virgin Islands (U.S.).
     */
    public const string M_850 = '850';

    /**
     * Burkina Faso.
     */
    public const string M_854 = '854';

    /**
     * Uruguay.
     */
    public const string M_858 = '858';

    /**
     * Uzbekistan.
     */
    public const string M_860 = '860';

    /**
     * Venezuela, Bolivarian Republic of.
     */
    public const string M_862 = '862';

    /**
     * Wallis and Futuna.
     */
    public const string M_876 = '876';

    /**
     * Samoa.
     */
    public const string M_882 = '882';

    /**
     * Yemen.
     */
    public const string M_887 = '887';

    /**
     * Zambia.
     */
    public const string M_894 = '894';
}
