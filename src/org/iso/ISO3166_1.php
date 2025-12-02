<?php

namespace org\iso;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants representing country and territory codes as defined by the ISO 3166-1 standard.
 *
 * ISO 3166-1 specifies two-letter (alpha-2) codes for countries, dependent territories, and special areas of
 * geographical interest. These codes are widely used in internationalization, shipping, payments, and data exchange.
 *
 * Each constant in this class corresponds to a valid ISO 3166-1 alpha-2 code, and its name reflects the code itself.
 *
 * Example usage:
 *   $country = ISO3166_1::FR; // 'FR' for France
 *
 * @see https://www.iso.org/iso-3166-country-codes.html Official ISO 3166-1 list
 * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 Wikipedia: ISO 3166-1 alpha-2
 */
class ISO3166_1
{
    use ConstantsTrait;

    /**
     * Andorra
     */
    public const string AD = 'AD';

    /**
     * United Arab Emirates
     */
    public const string AE = 'AE';

    /**
     * Afghanistan
     */
    public const string AF = 'AF';

    /**
     * Antigua and Barbuda
     */
    public const string AG = 'AG';

    /**
     * Anguilla
     */
    public const string AI = 'AI';

    /**
     * Albania
     */
    public const string AL = 'AL';

    /**
     * Armenia
     */
    public const string AM = 'AM';

    /**
     * Angola
     */
    public const string AO = 'AO';

    /**
     * Antarctica
     */
    public const string AQ = 'AQ';

    /**
     * Argentina
     */
    public const string AR = 'AR';

    /**
     * American Samoa
     */
    public const string AS = 'AS';

    /**
     * Austria
     */
    public const string AT = 'AT';

    /**
     * Australia
     */
    public const string AU = 'AU';

    /**
     * Aruba
     */
    public const string AW = 'AW';

    /**
     * Aland Islands
     */
    public const string AX = 'AX';

    /**
     * Azerbaijan
     */
    public const string AZ = 'AZ';

    /**
     * Bosnia and Herzegovina
     */
    public const string BA = 'BA';

    /**
     * Barbados
     */
    public const string BB = 'BB';

    /**
     * Bangladesh
     */
    public const string BD = 'BD';

    /**
     * Belgium
     */
    public const string BE = 'BE';

    /**
     * Burkina Faso
     */
    public const string BF = 'BF';

    /**
     * Bulgaria
     */
    public const string BG = 'BG';

    /**
     * Bahrain
     */
    public const string BH = 'BH';

    /**
     * Burundi
     */
    public const string BI = 'BI';

    /**
     * Benin
     */
    public const string BJ = 'BJ';

    /**
     * Saint Barthelemy
     */
    public const string BL = 'BL';

    /**
     * Bermuda
     */
    public const string BM = 'BM';

    /**
     * Brunei Darussalam
     */
    public const string BN = 'BN';

    /**
     * Bolivia (Plurinational State of)
     */
    public const string BO = 'BO';

    /**
     * Bonaire, Sint Eustatius and Saba
     */
    public const string BQ = 'BQ';

    /**
     * Brazil
     */
    public const string BR = 'BR';

    /**
     * Bahamas
     */
    public const string BS = 'BS';

    /**
     * Bhutan
     */
    public const string BT = 'BT';

    /**
     * Bouvet Island
     */
    public const string BV = 'BV';

    /**
     * Botswana
     */
    public const string BW = 'BW';

    /**
     * Belarus
     */
    public const string BY = 'BY';

    /**
     * Belize
     */
    public const string BZ = 'BZ';

    /**
     * Canada
     */
    public const string CA = 'CA';

    /**
     * Cocos (Keeling) Islands
     */
    public const string CC = 'CC';

    /**
     * Congo, Democratic Republic of the
     */
    public const string CD = 'CD';

    /**
     * Central African Republic
     */
    public const string CF = 'CF';

    /**
     * Congo
     */
    public const string CG = 'CG';

    /**
     * Switzerland
     */
    public const string CH = 'CH';

    /**
     * Cote d'Ivoire
     */
    public const string CI = 'CI';

    /**
     * Cook Islands
     */
    public const string CK = 'CK';

    /**
     * Chile
     */
    public const string CL = 'CL';

    /**
     * Cameroon
     */
    public const string CM = 'CM';

    /**
     * China
     */
    public const string CN = 'CN';

    /**
     * Colombia
     */
    public const string CO = 'CO';

    /**
     * Costa Rica
     */
    public const string CR = 'CR';

    /**
     * Cuba
     */
    public const string CU = 'CU';

    /**
     * Cabo Verde
     */
    public const string CV = 'CV';

    /**
     * Curacao
     */
    public const string CW = 'CW';

    /**
     * Christmas Island
     */
    public const string CX = 'CX';

    /**
     * Cyprus
     */
    public const string CY = 'CY';

    /**
     * Czechia
     */
    public const string CZ = 'CZ';

    /**
     * Germany
     */
    public const string DE = 'DE';

    /**
     * Djibouti
     */
    public const string DJ = 'DJ';

    /**
     * Denmark
     */
    public const string DK = 'DK';

    /**
     * Dominica
     */
    public const string DM = 'DM';

    /**
     * Dominican Republic
     */
    public const string DO = 'DO';

    /**
     * Algeria
     */
    public const string DZ = 'DZ';

    /**
     * Ecuador
     */
    public const string EC = 'EC';

    /**
     * Estonia
     */
    public const string EE = 'EE';

    /**
     * Egypt
     */
    public const string EG = 'EG';

    /**
     * Western Sahara
     */
    public const string EH = 'EH';

    /**
     * Eritrea
     */
    public const string ER = 'ER';

    /**
     * Spain
     */
    public const string ES = 'ES';

    /**
     * Ethiopia
     */
    public const string ET = 'ET';

    /**
     * Finland
     */
    public const string FI = 'FI';

    /**
     * Fiji
     */
    public const string FJ = 'FJ';

    /**
     * Falkland Islands (Malvinas)
     */
    public const string FK = 'FK';

    /**
     * Micronesia (Federated States of)
     */
    public const string FM = 'FM';

    /**
     * Faroe Islands
     */
    public const string FO = 'FO';

    /**
     * France
     */
    public const string FR = 'FR';

    /**
     * Gabon
     */
    public const string GA = 'GA';

    /**
     * United Kingdom of Great Britain and Northern Ireland
     */
    public const string GB = 'GB';

    /**
     * Grenada
     */
    public const string GD = 'GD';

    /**
     * Georgia
     */
    public const string GE = 'GE';

    /**
     * French Guiana
     */
    public const string GF = 'GF';

    /**
     * Guernsey
     */
    public const string GG = 'GG';

    /**
     * Ghana
     */
    public const string GH = 'GH';

    /**
     * Gibraltar
     */
    public const string GI = 'GI';

    /**
     * Greenland
     */
    public const string GL = 'GL';

    /**
     * Gambia
     */
    public const string GM = 'GM';

    /**
     * Guinea
     */
    public const string GN = 'GN';

    /**
     * Guadeloupe
     */
    public const string GP = 'GP';

    /**
     * Equatorial Guinea
     */
    public const string GQ = 'GQ';

    /**
     * Greece
     */
    public const string GR = 'GR';

    /**
     * South Georgia and the South Sandwich Islands
     */
    public const string GS = 'GS';

    /**
     * Guatemala
     */
    public const string GT = 'GT';

    /**
     * Guam
     */
    public const string GU = 'GU';

    /**
     * Guinea-Bissau
     */
    public const string GW = 'GW';

    /**
     * Guyana
     */
    public const string GY = 'GY';

    /**
     * Hong Kong
     */
    public const string HK = 'HK';

    /**
     * Heard Island and McDonald Islands
     */
    public const string HM = 'HM';

    /**
     * Honduras
     */
    public const string HN = 'HN';

    /**
     * Croatia
     */
    public const string HR = 'HR';

    /**
     * Haiti
     */
    public const string HT = 'HT';

    /**
     * Hungary
     */
    public const string HU = 'HU';

    /**
     * Indonesia
     */
    public const string ID = 'ID';

    /**
     * Ireland
     */
    public const string IE = 'IE';

    /**
     * Israel
     */
    public const string IL = 'IL';

    /**
     * Isle of Man
     */
    public const string IM = 'IM';

    /**
     * India
     */
    public const string IN = 'IN';

    /**
     * British Indian Ocean Territory
     */
    public const string IO = 'IO';

    /**
     * Iraq
     */
    public const string IQ = 'IQ';

    /**
     * Iran (Islamic Republic of)
     */
    public const string IR = 'IR';

    /**
     * Iceland
     */
    public const string IS = 'IS';

    /**
     * Italy
     */
    public const string IT = 'IT';

    /**
     * Jersey
     */
    public const string JE = 'JE';

    /**
     * Jamaica
     */
    public const string JM = 'JM';

    /**
     * Jordan
     */
    public const string JO = 'JO';

    /**
     * Japan
     */
    public const string JP = 'JP';

    /**
     * Kenya
     */
    public const string KE = 'KE';

    /**
     * Kyrgyzstan
     */
    public const string KG = 'KG';

    /**
     * Cambodia
     */
    public const string KH = 'KH';

    /**
     * Kiribati
     */
    public const string KI = 'KI';

    /**
     * Comoros
     */
    public const string KM = 'KM';

    /**
     * Saint Kitts and Nevis
     */
    public const string KN = 'KN';

    /**
     * Korea, Democratic People's Republic of
     */
    public const string KP = 'KP';

    /**
     * Korea, Republic of
     */
    public const string KR = 'KR';

    /**
     * Kuwait
     */
    public const string KW = 'KW';

    /**
     * Cayman Islands
     */
    public const string KY = 'KY';

    /**
     * Kazakhstan
     */
    public const string KZ = 'KZ';

    /**
     * Lao People's Democratic Republic
     */
    public const string LA = 'LA';

    /**
     * Lebanon
     */
    public const string LB = 'LB';

    /**
     * Saint Lucia
     */
    public const string LC = 'LC';

    /**
     * Liechtenstein
     */
    public const string LI = 'LI';

    /**
     * Sri Lanka
     */
    public const string LK = 'LK';

    /**
     * Liberia
     */
    public const string LR = 'LR';

    /**
     * Lesotho
     */
    public const string LS = 'LS';

    /**
     * Lithuania
     */
    public const string LT = 'LT';

    /**
     * Luxembourg
     */
    public const string LU = 'LU';

    /**
     * Latvia
     */
    public const string LV = 'LV';

    /**
     * Libya
     */
    public const string LY = 'LY';

    /**
     * Morocco
     */
    public const string MA = 'MA';

    /**
     * Monaco
     */
    public const string MC = 'MC';

    /**
     * Moldova, Republic of
     */
    public const string MD = 'MD';

    /**
     * Montenegro
     */
    public const string ME = 'ME';

    /**
     * Saint Martin (French part)
     */
    public const string MF = 'MF';

    /**
     * Madagascar
     */
    public const string MG = 'MG';

    /**
     * Marshall Islands
     */
    public const string MH = 'MH';

    /**
     * North Macedonia
     */
    public const string MK = 'MK';

    /**
     * Mali
     */
    public const string ML = 'ML';

    /**
     * Myanmar
     */
    public const string MM = 'MM';

    /**
     * Mongolia
     */
    public const string MN = 'MN';

    /**
     * Macao
     */
    public const string MO = 'MO';

    /**
     * Northern Mariana Islands
     */
    public const string MP = 'MP';

    /**
     * Martinique
     */
    public const string MQ = 'MQ';

    /**
     * Mauritania
     */
    public const string MR = 'MR';

    /**
     * Montserrat
     */
    public const string MS = 'MS';

    /**
     * Malta
     */
    public const string MT = 'MT';

    /**
     * Mauritius
     */
    public const string MU = 'MU';

    /**
     * Maldives
     */
    public const string MV = 'MV';

    /**
     * Malawi
     */
    public const string MW = 'MW';

    /**
     * Mexico
     */
    public const string MX = 'MX';

    /**
     * Malaysia
     */
    public const string MY = 'MY';

    /**
     * Mozambique
     */
    public const string MZ = 'MZ';

    /**
     * Namibia
     */
    public const string NA = 'NA';

    /**
     * New Caledonia
     */
    public const string NC = 'NC';

    /**
     * Niger
     */
    public const string NE = 'NE';

    /**
     * Norfolk Island
     */
    public const string NF = 'NF';

    /**
     * Nigeria
     */
    public const string NG = 'NG';

    /**
     * Nicaragua
     */
    public const string NI = 'NI';

    /**
     * Netherlands
     */
    public const string NL = 'NL';

    /**
     * Norway
     */
    public const string NO = 'NO';

    /**
     * Nepal
     */
    public const string NP = 'NP';

    /**
     * Nauru
     */
    public const string NR = 'NR';

    /**
     * Niue
     */
    public const string NU = 'NU';

    /**
     * New Zealand
     */
    public const string NZ = 'NZ';

    /**
     * Oman
     */
    public const string OM = 'OM';

    /**
     * Panama
     */
    public const string PA = 'PA';

    /**
     * Peru
     */
    public const string PE = 'PE';

    /**
     * French Polynesia
     */
    public const string PF = 'PF';

    /**
     * Papua New Guinea
     */
    public const string PG = 'PG';

    /**
     * Philippines
     */
    public const string PH = 'PH';

    /**
     * Pakistan
     */
    public const string PK = 'PK';

    /**
     * Poland
     */
    public const string PL = 'PL';

    /**
     * Saint Pierre and Miquelon
     */
    public const string PM = 'PM';

    /**
     * Pitcairn
     */
    public const string PN = 'PN';

    /**
     * Puerto Rico
     */
    public const string PR = 'PR';

    /**
     * Palestine, State of
     */
    public const string PS = 'PS';

    /**
     * Portugal
     */
    public const string PT = 'PT';

    /**
     * Palau
     */
    public const string PW = 'PW';

    /**
     * Paraguay
     */
    public const string PY = 'PY';

    /**
     * Qatar
     */
    public const string QA = 'QA';

    /**
     * Reunion
     */
    public const string RE = 'RE';

    /**
     * Romania
     */
    public const string RO = 'RO';

    /**
     * Serbia
     */
    public const string RS = 'RS';

    /**
     * Russian Federation
     */
    public const string RU = 'RU';

    /**
     * Rwanda
     */
    public const string RW = 'RW';

    /**
     * Saudi Arabia
     */
    public const string SA = 'SA';

    /**
     * Solomon Islands
     */
    public const string SB = 'SB';

    /**
     * Seychelles
     */
    public const string SC = 'SC';

    /**
     * Sudan
     */
    public const string SD = 'SD';

    /**
     * Sweden
     */
    public const string SE = 'SE';

    /**
     * Singapore
     */
    public const string SG = 'SG';

    /**
     * Saint HISO639_1elena, Ascension and Tristan da Cunha
     */
    public const string SH = 'SH';

    /**
     * Slovenia
     */
    public const string SI = 'SI';

    /**
     * Svalbard and Jan Mayen
     */
    public const string SJ = 'SJ';

    /**
     * Slovakia
     */
    public const string SK = 'SK';

    /**
     * Sierra Leone
     */
    public const string SL = 'SL';

    /**
     * San Marino
     */
    public const string SM = 'SM';

    /**
     * Senegal
     */
    public const string SN = 'SN';

    /**
     * Somalia
     */
    public const string SO = 'SO';

    /**
     * Suriname
     */
    public const string SR = 'SR';

    /**
     * South Sudan
     */
    public const string SS = 'SS';

    /**
     * Sao Tome and Principe
     */
    public const string ST = 'ST';

    /**
     * El Salvador
     */
    public const string SV = 'SV';

    /**
     * Sint Maarten (Dutch part)
     */
    public const string SX = 'SX';

    /**
     * Syrian Arab Republic
     */
    public const string SY = 'SY';

    /**
     * Eswatini
     */
    public const string SZ = 'SZ';

    /**
     * Turks and Caicos Islands
     */
    public const string TC = 'TC';

    /**
     * Chad
     */
    public const string TD = 'TD';

    /**
     * French Southern Territories
     */
    public const string TF = 'TF';

    /**
     * Togo
     */
    public const string TG = 'TG';

    /**
     * Thailand
     */
    public const string TH = 'TH';

    /**
     * Tajikistan
     */
    public const string TJ = 'TJ';

    /**
     * Tokelau
     */
    public const string TK = 'TK';

    /**
     * Timor-Leste
     */
    public const string TL = 'TL';

    /**
     * Turkmenistan
     */
    public const string TM = 'TM';

    /**
     * Tunisia
     */
    public const string TN = 'TN';

    /**
     * Tonga
     */
    public const string TO = 'TO';

    /**
     * Türkiye
     */
    public const string TR = 'TR';

    /**
     * Trinidad and Tobago
     */
    public const string TT = 'TT';

    /**
     * Tuvalu
     */
    public const string TV = 'TV';

    /**
     * Taiwan, Province of China
     */
    public const string TW = 'TW';

    /**
     * Tanzania, United Republic of
     */
    public const string TZ = 'TZ';

    /**
     * Ukraine
     */
    public const string UA = 'UA';

    /**
     * Uganda
     */
    public const string UG = 'UG';

    /**
     * United States Minor Outlying Islands
     */
    public const string UM = 'UM';

    /**
     * United States of America
     */
    public const string US = 'US';

    /**
     * Uruguay
     */
    public const string UY = 'UY';

    /**
     * Uzbekistan
     */
    public const string UZ = 'UZ';

    /**
     * Holy See
     */
    public const string VA = 'VA';

    /**
     * Saint Vincent and the Grenadines
     */
    public const string VC = 'VC';

    /**
     * Venezuela (Bolivarian Republic of)
     */
    public const string VE = 'VE';

    /**
     * Virgin Islands (British)
     */
    public const string VG = 'VG';

    /**
     * Virgin Islands (U.S.)
     */
    public const string VI = 'VI';

    /**
     * Viet Nam
     */
    public const string VN = 'VN';

    /**
     * Vanuatu
     */
    public const string VU = 'VU';

    /**
     * Wallis and Futuna
     */
    public const string WF = 'WF';

    /**
     * Samoa
     */
    public const string WS = 'WS';

    /**
     * Yemen
     */
    public const string YE = 'YE';

    /**
     * Mayotte
     */
    public const string YT = 'YT';

    /**
     * South Africa
     */
    public const string ZA = 'ZA';

    /**
     * Zambia
     */
    public const string ZM = 'ZM';

    /**
     * Zimbabwe
     */
    public const string ZW = 'ZW';
}