<?php

namespace org\iso;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants representing alpha-3 codes for **language families
 * and groups** as defined by the ISO 639-5 standard.
 *
 * Unlike {@see \org\iso\ISO639_1} (individual languages, alpha-2) or
 * {@see \org\iso\ISO639_2} (individual languages, alpha-3), ISO 639-5 covers
 * **language collections**: language families (`roa` Romance, `gem` Germanic,
 * `sla` Slavic, `cel` Celtic), areal/geographic groupings (`aus` Australian,
 * `nai` North American Indian), and language phyla (`afa` Afro-Asiatic).
 *
 * Useful for **language fallback chains** (e.g. if French `fr` is unavailable,
 * fall back to any Romance language `roa`) and for **bibliographic / linguistic**
 * classification.
 *
 * Many ISO 639-5 codes (~65) coexist with ISO 639-2 — those codes were
 * originally assigned to language families in ISO 639-2 before ISO 639-5 was
 * formalized. Each registry remains independent and authoritative for its
 * intended use; this class enumerates only the ISO 639-5 inventory.
 *
 * Example usage:
 *   ISO639_5::ROA;                      // 'roa' (Romance languages)
 *   ISO639_5::GEM;                      // 'gem' (Germanic languages)
 *   ISO639_5::includes('sla');          // true (Slavic languages)
 *   ISO639_5::includes('fra');          // false (individual language → ISO 639-2)
 *
 * @see \org\iso\ISO639_2  Alpha-3 codes for individual languages
 * @see \org\iso\ISO639_1  Alpha-2 codes for individual languages
 * @see https://www.loc.gov/standards/iso639-5/ Official LoC ISO 639-5 registry
 * @see https://id.loc.gov/vocabulary/iso639-5.html LoC linked-data view
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class ISO639_5
{
    use ConstantsTrait;

    /**
     * Austro-Asiatic languages.
     */
    public const string AAV = 'aav';

    /**
     * Afro-Asiatic languages.
     */
    public const string AFA = 'afa';

    /**
     * Algonquian languages.
     */
    public const string ALG = 'alg';

    /**
     * Atlantic-Congo languages.
     */
    public const string ALV = 'alv';

    /**
     * Apache languages.
     */
    public const string APA = 'apa';

    /**
     * Alacalufan languages.
     */
    public const string AQA = 'aqa';

    /**
     * Algic languages.
     */
    public const string AQL = 'aql';

    /**
     * Artificial languages.
     */
    public const string ART = 'art';

    /**
     * Athapascan languages.
     */
    public const string ATH = 'ath';

    /**
     * Arauan languages.
     */
    public const string AUF = 'auf';

    /**
     * Australian languages.
     */
    public const string AUS = 'aus';

    /**
     * Arawakan languages.
     */
    public const string AWD = 'awd';

    /**
     * Uto-Aztecan languages.
     */
    public const string AZC = 'azc';

    /**
     * Banda languages.
     */
    public const string BAD = 'bad';

    /**
     * Bamileke languages.
     */
    public const string BAI = 'bai';

    /**
     * Baltic languages.
     */
    public const string BAT = 'bat';

    /**
     * Berber languages.
     */
    public const string BER = 'ber';

    /**
     * Bihari languages.
     */
    public const string BIH = 'bih';

    /**
     * Bantu languages.
     */
    public const string BNT = 'bnt';

    /**
     * Batak languages.
     */
    public const string BTK = 'btk';

    /**
     * Central American Indian languages.
     */
    public const string CAI = 'cai';

    /**
     * Caucasian languages.
     */
    public const string CAU = 'cau';

    /**
     * Chibchan languages.
     */
    public const string CBA = 'cba';

    /**
     * North Caucasian languages.
     */
    public const string CCN = 'ccn';

    /**
     * South Caucasian languages.
     */
    public const string CCS = 'ccs';

    /**
     * Chadic languages.
     */
    public const string CDC = 'cdc';

    /**
     * Caddoan languages.
     */
    public const string CDD = 'cdd';

    /**
     * Celtic languages.
     */
    public const string CEL = 'cel';

    /**
     * Chamic languages.
     */
    public const string CMC = 'cmc';

    /**
     * Creoles and pidgins, English‑based.
     */
    public const string CPE = 'cpe';

    /**
     * Creoles and pidgins, French‑based.
     */
    public const string CPF = 'cpf';

    /**
     * Creoles and pidgins, Portuguese-based.
     */
    public const string CPP = 'cpp';

    /**
     * Creoles and pidgins.
     */
    public const string CRP = 'crp';

    /**
     * Central Sudanic languages.
     */
    public const string CSU = 'csu';

    /**
     * Cushitic languages.
     */
    public const string CUS = 'cus';

    /**
     * Land Dayak languages.
     */
    public const string DAY = 'day';

    /**
     * Mande languages.
     */
    public const string DMN = 'dmn';

    /**
     * Dravidian languages.
     */
    public const string DRA = 'dra';

    /**
     * Egyptian languages.
     */
    public const string EGX = 'egx';

    /**
     * Eskimo-Aleut languages.
     */
    public const string ESX = 'esx';

    /**
     * Basque (family).
     */
    public const string EUQ = 'euq';

    /**
     * Finno-Ugrian languages.
     */
    public const string FIU = 'fiu';

    /**
     * Formosan languages.
     */
    public const string FOX = 'fox';

    /**
     * Germanic languages.
     */
    public const string GEM = 'gem';

    /**
     * East Germanic languages.
     */
    public const string GME = 'gme';

    /**
     * North Germanic languages.
     */
    public const string GMQ = 'gmq';

    /**
     * West Germanic languages.
     */
    public const string GMW = 'gmw';

    /**
     * Greek languages.
     */
    public const string GRK = 'grk';

    /**
     * Hmong-Mien languages.
     */
    public const string HMX = 'hmx';

    /**
     * Hokan languages.
     */
    public const string HOK = 'hok';

    /**
     * Armenian (family).
     */
    public const string HYX = 'hyx';

    /**
     * Indo-Iranian languages.
     */
    public const string IIR = 'iir';

    /**
     * Ijo languages.
     */
    public const string IJO = 'ijo';

    /**
     * Indic languages.
     */
    public const string INC = 'inc';

    /**
     * Indo-European languages.
     */
    public const string INE = 'ine';

    /**
     * Iranian languages.
     */
    public const string IRA = 'ira';

    /**
     * Iroquoian languages.
     */
    public const string IRO = 'iro';

    /**
     * Italic languages.
     */
    public const string ITC = 'itc';

    /**
     * Japanese (family).
     */
    public const string JPX = 'jpx';

    /**
     * Karen languages.
     */
    public const string KAR = 'kar';

    /**
     * Kordofanian languages.
     */
    public const string KDO = 'kdo';

    /**
     * Khoisan languages.
     */
    public const string KHI = 'khi';

    /**
     * Kru languages.
     */
    public const string KRO = 'kro';

    /**
     * Austronesian languages.
     */
    public const string MAP = 'map';

    /**
     * Mon-Khmer languages.
     */
    public const string MKH = 'mkh';

    /**
     * Manobo languages.
     */
    public const string MNO = 'mno';

    /**
     * Munda languages.
     */
    public const string MUN = 'mun';

    /**
     * Mayan languages.
     */
    public const string MYN = 'myn';

    /**
     * Nahuatl languages.
     */
    public const string NAH = 'nah';

    /**
     * North American Indian languages.
     */
    public const string NAI = 'nai';

    /**
     * Trans-New Guinea languages.
     */
    public const string NGF = 'ngf';

    /**
     * Niger-Kordofanian languages.
     */
    public const string NIC = 'nic';

    /**
     * Nubian languages.
     */
    public const string NUB = 'nub';

    /**
     * Oto-Manguean languages.
     */
    public const string OMQ = 'omq';

    /**
     * Omotic languages.
     */
    public const string OMV = 'omv';

    /**
     * Otomian languages.
     */
    public const string OTO = 'oto';

    /**
     * Papuan languages.
     */
    public const string PAA = 'paa';

    /**
     * Philippine languages.
     */
    public const string PHI = 'phi';

    /**
     * Central Malayo-Polynesian languages.
     */
    public const string PLF = 'plf';

    /**
     * Malayo-Polynesian languages.
     */
    public const string POZ = 'poz';

    /**
     * Eastern Malayo-Polynesian languages.
     */
    public const string PQE = 'pqe';

    /**
     * Western Malayo-Polynesian languages.
     */
    public const string PQW = 'pqw';

    /**
     * Prakrit languages.
     */
    public const string PRA = 'pra';

    /**
     * Quechuan (family).
     */
    public const string QWE = 'qwe';

    /**
     * Romance languages.
     */
    public const string ROA = 'roa';

    /**
     * South American Indian languages.
     */
    public const string SAI = 'sai';

    /**
     * Salishan languages.
     */
    public const string SAL = 'sal';

    /**
     * Eastern Sudanic languages.
     */
    public const string SDV = 'sdv';

    /**
     * Semitic languages.
     */
    public const string SEM = 'sem';

    /**
     * sign languages.
     */
    public const string SGN = 'sgn';

    /**
     * Siouan languages.
     */
    public const string SIO = 'sio';

    /**
     * Sino-Tibetan languages.
     */
    public const string SIT = 'sit';

    /**
     * Slavic languages.
     */
    public const string SLA = 'sla';

    /**
     * Sami languages.
     */
    public const string SMI = 'smi';

    /**
     * Songhai languages.
     */
    public const string SON = 'son';

    /**
     * Albanian languages.
     */
    public const string SQJ = 'sqj';

    /**
     * Nilo-Saharan languages.
     */
    public const string SSA = 'ssa';

    /**
     * Samoyedic languages.
     */
    public const string SYD = 'syd';

    /**
     * Tai languages.
     */
    public const string TAI = 'tai';

    /**
     * Tibeto-Burman languages.
     */
    public const string TBQ = 'tbq';

    /**
     * Turkic languages.
     */
    public const string TRK = 'trk';

    /**
     * Tupi languages.
     */
    public const string TUP = 'tup';

    /**
     * Altaic languages.
     */
    public const string TUT = 'tut';

    /**
     * Tungus languages.
     */
    public const string TUW = 'tuw';

    /**
     * Uralic languages.
     */
    public const string URJ = 'urj';

    /**
     * Wakashan languages.
     */
    public const string WAK = 'wak';

    /**
     * Sorbian languages.
     */
    public const string WEN = 'wen';

    /**
     * Mongolian languages.
     */
    public const string XGN = 'xgn';

    /**
     * Na-Dene languages.
     */
    public const string XND = 'xnd';

    /**
     * Yupik languages.
     */
    public const string YPK = 'ypk';

    /**
     * Chinese (family).
     */
    public const string ZHX = 'zhx';

    /**
     * East Slavic languages.
     */
    public const string ZLE = 'zle';

    /**
     * South Slavic languages.
     */
    public const string ZLS = 'zls';

    /**
     * West Slavic languages.
     */
    public const string ZLW = 'zlw';

    /**
     * Zande languages.
     */
    public const string ZND = 'znd';
}
