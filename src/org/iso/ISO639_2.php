<?php

namespace org\iso;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants representing language codes as defined by the ISO 639-2 standard
 * (canonical alpha-3 form).
 *
 * ISO 639-2 assigns 3-letter codes to languages. For ~20 major languages, two codes coexist:
 * a **bibliographic (B)** form historically used in librarianship and a **terminologic (T)**
 * form designed for general use. IETF BCP 47 / RFC 5646 §4.1.2 prescribes the **terminologic**
 * form as canonical.
 *
 * This class lists the **canonical** alpha-3 code for every ISO 639-2 language:
 * - the **T** form when both B and T exist (e.g. `fra` for French, `deu` for German, `zho` for Chinese),
 * - the single alpha-3 code otherwise (e.g. `eng`, `spa`, `ita`).
 *
 * For the bibliographic forms and the B → T conversion map, see {@see \org\iso\ISO639_2B}.
 *
 * Includes ISO 639-2 special purpose codes:
 *   `mis` (Uncoded languages), `mul` (Multiple languages),
 *   `und` (Undetermined), `zxx` (No linguistic content).
 *
 * The `qaa-qtz` range (reserved for local use) is **intentionally not enumerated**:
 * those codes are not individually assigned by ISO and should be defined locally
 * by consumers if needed (similar to `Qaaa`-`Qabx` in {@see \org\iso\ISO15924}).
 *
 * Example usage:
 *   $french = ISO639_2::FRA;            // 'fra'
 *   $german = ISO639_2::DEU;            // 'deu'
 *
 *   ISO639_2::includes('eng');          // true (English)
 *   ISO639_2::includes('fre');          // false ('fre' is bibliographic — see ISO639_2B)
 *   ISO639_2::includes('zzz');          // false
 *
 * @see \org\iso\ISO639_2B Bibliographic forms and B → T conversion
 * @see \org\iso\ISO639_1  Alpha-2 form (subset: 184 languages with alpha-2)
 * @see \org\iso\ISO639_5  Alpha-3 codes for language families/groups
 * @see https://www.loc.gov/standards/iso639-2/ Official LoC ISO 639-2 registry
 * @see https://www.rfc-editor.org/rfc/rfc5646#section-4.1.2 RFC 5646 — Preferred form
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class ISO639_2
{
    use ConstantsTrait;

    /**
     * Afar.
     */
    public const string AAR = 'aar';

    /**
     * Abkhazian.
     */
    public const string ABK = 'abk';

    /**
     * Achinese.
     */
    public const string ACE = 'ace';

    /**
     * Acoli.
     */
    public const string ACH = 'ach';

    /**
     * Adangme.
     */
    public const string ADA = 'ada';

    /**
     * Adyghe; Adygei.
     */
    public const string ADY = 'ady';

    /**
     * Afro-Asiatic languages.
     */
    public const string AFA = 'afa';

    /**
     * Afrihili.
     */
    public const string AFH = 'afh';

    /**
     * Afrikaans.
     */
    public const string AFR = 'afr';

    /**
     * Ainu.
     */
    public const string AIN = 'ain';

    /**
     * Akan.
     */
    public const string AKA = 'aka';

    /**
     * Akkadian.
     */
    public const string AKK = 'akk';

    /**
     * Aleut.
     */
    public const string ALE = 'ale';

    /**
     * Algonquian languages.
     */
    public const string ALG = 'alg';

    /**
     * Southern Altai.
     */
    public const string ALT = 'alt';

    /**
     * Amharic.
     */
    public const string AMH = 'amh';

    /**
     * English, Old (ca.450-1100).
     */
    public const string ANG = 'ang';

    /**
     * Angika.
     */
    public const string ANP = 'anp';

    /**
     * Apache languages.
     */
    public const string APA = 'apa';

    /**
     * Arabic.
     */
    public const string ARA = 'ara';

    /**
     * Official Aramaic (700-300 BCE); Imperial Aramaic (700-300 BCE).
     */
    public const string ARC = 'arc';

    /**
     * Aragonese.
     */
    public const string ARG = 'arg';

    /**
     * Mapudungun; Mapuche.
     */
    public const string ARN = 'arn';

    /**
     * Arapaho.
     */
    public const string ARP = 'arp';

    /**
     * Artificial languages.
     */
    public const string ART = 'art';

    /**
     * Arawak.
     */
    public const string ARW = 'arw';

    /**
     * Assamese.
     */
    public const string ASM = 'asm';

    /**
     * Asturian; Bable; Leonese; Asturleonese.
     */
    public const string AST = 'ast';

    /**
     * Athapascan languages.
     */
    public const string ATH = 'ath';

    /**
     * Australian languages.
     */
    public const string AUS = 'aus';

    /**
     * Avaric.
     */
    public const string AVA = 'ava';

    /**
     * Avestan.
     */
    public const string AVE = 'ave';

    /**
     * Awadhi.
     */
    public const string AWA = 'awa';

    /**
     * Aymara.
     */
    public const string AYM = 'aym';

    /**
     * Azerbaijani.
     */
    public const string AZE = 'aze';

    /**
     * Banda languages.
     */
    public const string BAD = 'bad';

    /**
     * Bamileke languages.
     */
    public const string BAI = 'bai';

    /**
     * Bashkir.
     */
    public const string BAK = 'bak';

    /**
     * Baluchi.
     */
    public const string BAL = 'bal';

    /**
     * Bambara.
     */
    public const string BAM = 'bam';

    /**
     * Balinese.
     */
    public const string BAN = 'ban';

    /**
     * Basa.
     */
    public const string BAS = 'bas';

    /**
     * Baltic languages.
     */
    public const string BAT = 'bat';

    /**
     * Beja; Bedawiyet.
     */
    public const string BEJ = 'bej';

    /**
     * Belarusian.
     */
    public const string BEL = 'bel';

    /**
     * Bemba.
     */
    public const string BEM = 'bem';

    /**
     * Bengali.
     */
    public const string BEN = 'ben';

    /**
     * Berber languages.
     */
    public const string BER = 'ber';

    /**
     * Bhojpuri.
     */
    public const string BHO = 'bho';

    /**
     * Bihari languages.
     */
    public const string BIH = 'bih';

    /**
     * Bikol.
     */
    public const string BIK = 'bik';

    /**
     * Bini; Edo.
     */
    public const string BIN = 'bin';

    /**
     * Bislama.
     */
    public const string BIS = 'bis';

    /**
     * Siksika.
     */
    public const string BLA = 'bla';

    /**
     * Bantu languages.
     */
    public const string BNT = 'bnt';

    /**
     * Tibetan.
     */
    public const string BOD = 'bod';

    /**
     * Bosnian.
     */
    public const string BOS = 'bos';

    /**
     * Braj.
     */
    public const string BRA = 'bra';

    /**
     * Breton.
     */
    public const string BRE = 'bre';

    /**
     * Batak languages.
     */
    public const string BTK = 'btk';

    /**
     * Buriat.
     */
    public const string BUA = 'bua';

    /**
     * Buginese.
     */
    public const string BUG = 'bug';

    /**
     * Bulgarian.
     */
    public const string BUL = 'bul';

    /**
     * Blin; Bilin.
     */
    public const string BYN = 'byn';

    /**
     * Caddo.
     */
    public const string CAD = 'cad';

    /**
     * Central American Indian languages.
     */
    public const string CAI = 'cai';

    /**
     * Galibi Carib.
     */
    public const string CAR = 'car';

    /**
     * Catalan; Valencian.
     */
    public const string CAT = 'cat';

    /**
     * Caucasian languages.
     */
    public const string CAU = 'cau';

    /**
     * Cebuano.
     */
    public const string CEB = 'ceb';

    /**
     * Celtic languages.
     */
    public const string CEL = 'cel';

    /**
     * Czech.
     */
    public const string CES = 'ces';

    /**
     * Chamorro.
     */
    public const string CHA = 'cha';

    /**
     * Chibcha.
     */
    public const string CHB = 'chb';

    /**
     * Chechen.
     */
    public const string CHE = 'che';

    /**
     * Chagatai.
     */
    public const string CHG = 'chg';

    /**
     * Chuukese.
     */
    public const string CHK = 'chk';

    /**
     * Mari.
     */
    public const string CHM = 'chm';

    /**
     * Chinook jargon.
     */
    public const string CHN = 'chn';

    /**
     * Choctaw.
     */
    public const string CHO = 'cho';

    /**
     * Chipewyan; Dene Suline.
     */
    public const string CHP = 'chp';

    /**
     * Cherokee.
     */
    public const string CHR = 'chr';

    /**
     * Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic.
     */
    public const string CHU = 'chu';

    /**
     * Chuvash.
     */
    public const string CHV = 'chv';

    /**
     * Cheyenne.
     */
    public const string CHY = 'chy';

    /**
     * Chamic languages.
     */
    public const string CMC = 'cmc';

    /**
     * Montenegrin.
     */
    public const string CNR = 'cnr';

    /**
     * Coptic.
     */
    public const string COP = 'cop';

    /**
     * Cornish.
     */
    public const string COR = 'cor';

    /**
     * Corsican.
     */
    public const string COS = 'cos';

    /**
     * Creoles and pidgins, English based.
     */
    public const string CPE = 'cpe';

    /**
     * Creoles and pidgins, French-based.
     */
    public const string CPF = 'cpf';

    /**
     * Creoles and pidgins, Portuguese-based.
     */
    public const string CPP = 'cpp';

    /**
     * Cree.
     */
    public const string CRE = 'cre';

    /**
     * Crimean Tatar; Crimean Turkish.
     */
    public const string CRH = 'crh';

    /**
     * Creoles and pidgins.
     */
    public const string CRP = 'crp';

    /**
     * Kashubian.
     */
    public const string CSB = 'csb';

    /**
     * Cushitic languages.
     */
    public const string CUS = 'cus';

    /**
     * Welsh.
     */
    public const string CYM = 'cym';

    /**
     * Dakota.
     */
    public const string DAK = 'dak';

    /**
     * Danish.
     */
    public const string DAN = 'dan';

    /**
     * Dargwa.
     */
    public const string DAR = 'dar';

    /**
     * Land Dayak languages.
     */
    public const string DAY = 'day';

    /**
     * Delaware.
     */
    public const string DEL = 'del';

    /**
     * Slave (Athapascan).
     */
    public const string DEN = 'den';

    /**
     * German.
     */
    public const string DEU = 'deu';

    /**
     * Tlicho; Dogrib.
     */
    public const string DGR = 'dgr';

    /**
     * Dinka.
     */
    public const string DIN = 'din';

    /**
     * Divehi; Dhivehi; Maldivian.
     */
    public const string DIV = 'div';

    /**
     * Dogri.
     */
    public const string DOI = 'doi';

    /**
     * Dravidian languages.
     */
    public const string DRA = 'dra';

    /**
     * Lower Sorbian.
     */
    public const string DSB = 'dsb';

    /**
     * Duala.
     */
    public const string DUA = 'dua';

    /**
     * Dutch, Middle (ca.1050-1350).
     */
    public const string DUM = 'dum';

    /**
     * Dyula.
     */
    public const string DYU = 'dyu';

    /**
     * Dzongkha.
     */
    public const string DZO = 'dzo';

    /**
     * Efik.
     */
    public const string EFI = 'efi';

    /**
     * Egyptian (Ancient).
     */
    public const string EGY = 'egy';

    /**
     * Ekajuk.
     */
    public const string EKA = 'eka';

    /**
     * Modern Greek (1453-).
     */
    public const string ELL = 'ell';

    /**
     * Elamite.
     */
    public const string ELX = 'elx';

    /**
     * English.
     */
    public const string ENG = 'eng';

    /**
     * English, Middle (1100-1500).
     */
    public const string ENM = 'enm';

    /**
     * Esperanto.
     */
    public const string EPO = 'epo';

    /**
     * Estonian.
     */
    public const string EST = 'est';

    /**
     * Basque.
     */
    public const string EUS = 'eus';

    /**
     * Ewe.
     */
    public const string EWE = 'ewe';

    /**
     * Ewondo.
     */
    public const string EWO = 'ewo';

    /**
     * Fang.
     */
    public const string FAN = 'fan';

    /**
     * Faroese.
     */
    public const string FAO = 'fao';

    /**
     * Persian.
     */
    public const string FAS = 'fas';

    /**
     * Fanti.
     */
    public const string FAT = 'fat';

    /**
     * Fijian.
     */
    public const string FIJ = 'fij';

    /**
     * Filipino; Pilipino.
     */
    public const string FIL = 'fil';

    /**
     * Finnish.
     */
    public const string FIN = 'fin';

    /**
     * Finno-Ugrian languages.
     */
    public const string FIU = 'fiu';

    /**
     * Fon.
     */
    public const string FON = 'fon';

    /**
     * French.
     */
    public const string FRA = 'fra';

    /**
     * French, Middle (ca.1400-1600).
     */
    public const string FRM = 'frm';

    /**
     * French, Old (842-ca.1400).
     */
    public const string FRO = 'fro';

    /**
     * Northern Frisian.
     */
    public const string FRR = 'frr';

    /**
     * Eastern Frisian.
     */
    public const string FRS = 'frs';

    /**
     * Western Frisian.
     */
    public const string FRY = 'fry';

    /**
     * Fulah.
     */
    public const string FUL = 'ful';

    /**
     * Friulian.
     */
    public const string FUR = 'fur';

    /**
     * Ga.
     */
    public const string GAA = 'gaa';

    /**
     * Gayo.
     */
    public const string GAY = 'gay';

    /**
     * Gbaya.
     */
    public const string GBA = 'gba';

    /**
     * Germanic languages.
     */
    public const string GEM = 'gem';

    /**
     * Geez.
     */
    public const string GEZ = 'gez';

    /**
     * Gilbertese.
     */
    public const string GIL = 'gil';

    /**
     * Gaelic; Scottish Gaelic.
     */
    public const string GLA = 'gla';

    /**
     * Irish.
     */
    public const string GLE = 'gle';

    /**
     * Galician.
     */
    public const string GLG = 'glg';

    /**
     * Manx.
     */
    public const string GLV = 'glv';

    /**
     * German, Middle High (ca.1050-1500).
     */
    public const string GMH = 'gmh';

    /**
     * German, Old High (ca.750-1050).
     */
    public const string GOH = 'goh';

    /**
     * Gondi.
     */
    public const string GON = 'gon';

    /**
     * Gorontalo.
     */
    public const string GOR = 'gor';

    /**
     * Gothic.
     */
    public const string GOT = 'got';

    /**
     * Grebo.
     */
    public const string GRB = 'grb';

    /**
     * Greek, Ancient (to 1453).
     */
    public const string GRC = 'grc';

    /**
     * Guarani.
     */
    public const string GRN = 'grn';

    /**
     * Swiss German; Alemannic; Alsatian.
     */
    public const string GSW = 'gsw';

    /**
     * Gujarati.
     */
    public const string GUJ = 'guj';

    /**
     * Gwich'in.
     */
    public const string GWI = 'gwi';

    /**
     * Haida.
     */
    public const string HAI = 'hai';

    /**
     * Haitian; Haitian Creole.
     */
    public const string HAT = 'hat';

    /**
     * Hausa.
     */
    public const string HAU = 'hau';

    /**
     * Hawaiian.
     */
    public const string HAW = 'haw';

    /**
     * Hebrew.
     */
    public const string HEB = 'heb';

    /**
     * Herero.
     */
    public const string HER = 'her';

    /**
     * Hiligaynon.
     */
    public const string HIL = 'hil';

    /**
     * Himachali languages; Western Pahari languages.
     */
    public const string HIM = 'him';

    /**
     * Hindi.
     */
    public const string HIN = 'hin';

    /**
     * Hittite.
     */
    public const string HIT = 'hit';

    /**
     * Hmong; Mong.
     */
    public const string HMN = 'hmn';

    /**
     * Hiri Motu.
     */
    public const string HMO = 'hmo';

    /**
     * Croatian.
     */
    public const string HRV = 'hrv';

    /**
     * Upper Sorbian.
     */
    public const string HSB = 'hsb';

    /**
     * Hungarian.
     */
    public const string HUN = 'hun';

    /**
     * Hupa.
     */
    public const string HUP = 'hup';

    /**
     * Armenian.
     */
    public const string HYE = 'hye';

    /**
     * Iban.
     */
    public const string IBA = 'iba';

    /**
     * Igbo.
     */
    public const string IBO = 'ibo';

    /**
     * Ido.
     */
    public const string IDO = 'ido';

    /**
     * Sichuan Yi; Nuosu.
     */
    public const string III = 'iii';

    /**
     * Ijo languages.
     */
    public const string IJO = 'ijo';

    /**
     * Inuktitut.
     */
    public const string IKU = 'iku';

    /**
     * Interlingue; Occidental.
     */
    public const string ILE = 'ile';

    /**
     * Iloko.
     */
    public const string ILO = 'ilo';

    /**
     * Interlingua (International Auxiliary Language Association).
     */
    public const string INA = 'ina';

    /**
     * Indic languages.
     */
    public const string INC = 'inc';

    /**
     * Indonesian.
     */
    public const string IND = 'ind';

    /**
     * Indo-European languages.
     */
    public const string INE = 'ine';

    /**
     * Ingush.
     */
    public const string INH = 'inh';

    /**
     * Inupiaq.
     */
    public const string IPK = 'ipk';

    /**
     * Iranian languages.
     */
    public const string IRA = 'ira';

    /**
     * Iroquoian languages.
     */
    public const string IRO = 'iro';

    /**
     * Icelandic.
     */
    public const string ISL = 'isl';

    /**
     * Italian.
     */
    public const string ITA = 'ita';

    /**
     * Javanese.
     */
    public const string JAV = 'jav';

    /**
     * Lojban.
     */
    public const string JBO = 'jbo';

    /**
     * Japanese.
     */
    public const string JPN = 'jpn';

    /**
     * Judeo-Persian.
     */
    public const string JPR = 'jpr';

    /**
     * Judeo-Arabic.
     */
    public const string JRB = 'jrb';

    /**
     * Kara-Kalpak.
     */
    public const string KAA = 'kaa';

    /**
     * Kabyle.
     */
    public const string KAB = 'kab';

    /**
     * Kachin; Jingpho.
     */
    public const string KAC = 'kac';

    /**
     * Kalaallisut; Greenlandic.
     */
    public const string KAL = 'kal';

    /**
     * Kamba.
     */
    public const string KAM = 'kam';

    /**
     * Kannada.
     */
    public const string KAN = 'kan';

    /**
     * Karen languages.
     */
    public const string KAR = 'kar';

    /**
     * Kashmiri.
     */
    public const string KAS = 'kas';

    /**
     * Georgian.
     */
    public const string KAT = 'kat';

    /**
     * Kanuri.
     */
    public const string KAU = 'kau';

    /**
     * Kawi.
     */
    public const string KAW = 'kaw';

    /**
     * Kazakh.
     */
    public const string KAZ = 'kaz';

    /**
     * Kabardian.
     */
    public const string KBD = 'kbd';

    /**
     * Khasi.
     */
    public const string KHA = 'kha';

    /**
     * Khoisan languages.
     */
    public const string KHI = 'khi';

    /**
     * Central Khmer.
     */
    public const string KHM = 'khm';

    /**
     * Khotanese; Sakan.
     */
    public const string KHO = 'kho';

    /**
     * Kikuyu; Gikuyu.
     */
    public const string KIK = 'kik';

    /**
     * Kinyarwanda.
     */
    public const string KIN = 'kin';

    /**
     * Kirghiz; Kyrgyz.
     */
    public const string KIR = 'kir';

    /**
     * Kimbundu.
     */
    public const string KMB = 'kmb';

    /**
     * Konkani.
     */
    public const string KOK = 'kok';

    /**
     * Komi.
     */
    public const string KOM = 'kom';

    /**
     * Kongo.
     */
    public const string KON = 'kon';

    /**
     * Korean.
     */
    public const string KOR = 'kor';

    /**
     * Kosraean.
     */
    public const string KOS = 'kos';

    /**
     * Kpelle.
     */
    public const string KPE = 'kpe';

    /**
     * Karachay-Balkar.
     */
    public const string KRC = 'krc';

    /**
     * Karelian.
     */
    public const string KRL = 'krl';

    /**
     * Kru languages.
     */
    public const string KRO = 'kro';

    /**
     * Kurukh.
     */
    public const string KRU = 'kru';

    /**
     * Kuanyama; Kwanyama.
     */
    public const string KUA = 'kua';

    /**
     * Kumyk.
     */
    public const string KUM = 'kum';

    /**
     * Kurdish.
     */
    public const string KUR = 'kur';

    /**
     * Kutenai.
     */
    public const string KUT = 'kut';

    /**
     * Ladino.
     */
    public const string LAD = 'lad';

    /**
     * Lahnda.
     */
    public const string LAH = 'lah';

    /**
     * Lamba.
     */
    public const string LAM = 'lam';

    /**
     * Lao.
     */
    public const string LAO = 'lao';

    /**
     * Latin.
     */
    public const string LAT = 'lat';

    /**
     * Latvian.
     */
    public const string LAV = 'lav';

    /**
     * Lezghian.
     */
    public const string LEZ = 'lez';

    /**
     * Limburgan; Limburger; Limburgish.
     */
    public const string LIM = 'lim';

    /**
     * Lingala.
     */
    public const string LIN = 'lin';

    /**
     * Lithuanian.
     */
    public const string LIT = 'lit';

    /**
     * Mongo.
     */
    public const string LOL = 'lol';

    /**
     * Lozi.
     */
    public const string LOZ = 'loz';

    /**
     * Luxembourgish; Letzeburgesch.
     */
    public const string LTZ = 'ltz';

    /**
     * Luba-Lulua.
     */
    public const string LUA = 'lua';

    /**
     * Luba-Katanga.
     */
    public const string LUB = 'lub';

    /**
     * Ganda.
     */
    public const string LUG = 'lug';

    /**
     * Luiseno.
     */
    public const string LUI = 'lui';

    /**
     * Lunda.
     */
    public const string LUN = 'lun';

    /**
     * Luo (Kenya and Tanzania).
     */
    public const string LUO = 'luo';

    /**
     * Lushai.
     */
    public const string LUS = 'lus';

    /**
     * Madurese.
     */
    public const string MAD = 'mad';

    /**
     * Magahi.
     */
    public const string MAG = 'mag';

    /**
     * Marshallese.
     */
    public const string MAH = 'mah';

    /**
     * Maithili.
     */
    public const string MAI = 'mai';

    /**
     * Makasar.
     */
    public const string MAK = 'mak';

    /**
     * Malayalam.
     */
    public const string MAL = 'mal';

    /**
     * Mandingo.
     */
    public const string MAN = 'man';

    /**
     * Austronesian languages.
     */
    public const string MAP = 'map';

    /**
     * Marathi.
     */
    public const string MAR = 'mar';

    /**
     * Masai.
     */
    public const string MAS = 'mas';

    /**
     * Moksha.
     */
    public const string MDF = 'mdf';

    /**
     * Mandar.
     */
    public const string MDR = 'mdr';

    /**
     * Mende.
     */
    public const string MEN = 'men';

    /**
     * Irish, Middle (900-1200).
     */
    public const string MGA = 'mga';

    /**
     * Mi'kmaq; Micmac.
     */
    public const string MIC = 'mic';

    /**
     * Minangkabau.
     */
    public const string MIN = 'min';

    /**
     * Uncoded languages.
     */
    public const string MIS = 'mis';

    /**
     * Macedonian.
     */
    public const string MKD = 'mkd';

    /**
     * Mon-Khmer languages.
     */
    public const string MKH = 'mkh';

    /**
     * Malagasy.
     */
    public const string MLG = 'mlg';

    /**
     * Maltese.
     */
    public const string MLT = 'mlt';

    /**
     * Manchu.
     */
    public const string MNC = 'mnc';

    /**
     * Manipuri.
     */
    public const string MNI = 'mni';

    /**
     * Manobo languages.
     */
    public const string MNO = 'mno';

    /**
     * Mohawk.
     */
    public const string MOH = 'moh';

    /**
     * Mongolian.
     */
    public const string MON = 'mon';

    /**
     * Mossi.
     */
    public const string MOS = 'mos';

    /**
     * Maori.
     */
    public const string MRI = 'mri';

    /**
     * Malay.
     */
    public const string MSA = 'msa';

    /**
     * Multiple languages.
     */
    public const string MUL = 'mul';

    /**
     * Munda languages.
     */
    public const string MUN = 'mun';

    /**
     * Creek.
     */
    public const string MUS = 'mus';

    /**
     * Mirandese.
     */
    public const string MWL = 'mwl';

    /**
     * Marwari.
     */
    public const string MWR = 'mwr';

    /**
     * Burmese.
     */
    public const string MYA = 'mya';

    /**
     * Mayan languages.
     */
    public const string MYN = 'myn';

    /**
     * Erzya.
     */
    public const string MYV = 'myv';

    /**
     * Nahuatl languages.
     */
    public const string NAH = 'nah';

    /**
     * North American Indian languages.
     */
    public const string NAI = 'nai';

    /**
     * Neapolitan.
     */
    public const string NAP = 'nap';

    /**
     * Nauru.
     */
    public const string NAU = 'nau';

    /**
     * Navajo; Navaho.
     */
    public const string NAV = 'nav';

    /**
     * South Ndebele.
     */
    public const string NBL = 'nbl';

    /**
     * North Ndebele.
     */
    public const string NDE = 'nde';

    /**
     * Ndonga.
     */
    public const string NDO = 'ndo';

    /**
     * Low German; Low Saxon; German, Low; Saxon, Low.
     */
    public const string NDS = 'nds';

    /**
     * Nepali.
     */
    public const string NEP = 'nep';

    /**
     * Nepal Bhasa; Newar; Newari.
     */
    public const string NEW = 'new';

    /**
     * Nias.
     */
    public const string NIA = 'nia';

    /**
     * Niger-Kordofanian languages.
     */
    public const string NIC = 'nic';

    /**
     * Niuean.
     */
    public const string NIU = 'niu';

    /**
     * Dutch; Flemish.
     */
    public const string NLD = 'nld';

    /**
     * Norwegian Nynorsk.
     */
    public const string NNO = 'nno';

    /**
     * Norwegian Bokmål.
     */
    public const string NOB = 'nob';

    /**
     * Nogai.
     */
    public const string NOG = 'nog';

    /**
     * Norse, Old.
     */
    public const string NON = 'non';

    /**
     * Norwegian.
     */
    public const string NOR = 'nor';

    /**
     * N'Ko.
     */
    public const string NQO = 'nqo';

    /**
     * Pedi; Sepedi; Northern Sotho.
     */
    public const string NSO = 'nso';

    /**
     * Nubian languages.
     */
    public const string NUB = 'nub';

    /**
     * Classical Newari; Old Newari; Classical Nepal Bhasa.
     */
    public const string NWC = 'nwc';

    /**
     * Chichewa; Chewa; Nyanja.
     */
    public const string NYA = 'nya';

    /**
     * Nyamwezi.
     */
    public const string NYM = 'nym';

    /**
     * Nyankole.
     */
    public const string NYN = 'nyn';

    /**
     * Nyoro.
     */
    public const string NYO = 'nyo';

    /**
     * Nzima.
     */
    public const string NZI = 'nzi';

    /**
     * Occitan (post 1500).
     */
    public const string OCI = 'oci';

    /**
     * Ojibwa.
     */
    public const string OJI = 'oji';

    /**
     * Oriya.
     */
    public const string ORI = 'ori';

    /**
     * Oromo.
     */
    public const string ORM = 'orm';

    /**
     * Osage.
     */
    public const string OSA = 'osa';

    /**
     * Ossetian; Ossetic.
     */
    public const string OSS = 'oss';

    /**
     * Turkish, Ottoman (1500-1928).
     */
    public const string OTA = 'ota';

    /**
     * Otomian languages.
     */
    public const string OTO = 'oto';

    /**
     * Papuan languages.
     */
    public const string PAA = 'paa';

    /**
     * Pangasinan.
     */
    public const string PAG = 'pag';

    /**
     * Pahlavi.
     */
    public const string PAL = 'pal';

    /**
     * Pampanga; Kapampangan.
     */
    public const string PAM = 'pam';

    /**
     * Panjabi; Punjabi.
     */
    public const string PAN = 'pan';

    /**
     * Papiamento.
     */
    public const string PAP = 'pap';

    /**
     * Palauan.
     */
    public const string PAU = 'pau';

    /**
     * Persian, Old (ca.600-400 B.C.).
     */
    public const string PEO = 'peo';

    /**
     * Philippine languages.
     */
    public const string PHI = 'phi';

    /**
     * Phoenician.
     */
    public const string PHN = 'phn';

    /**
     * Pali.
     */
    public const string PLI = 'pli';

    /**
     * Polish.
     */
    public const string POL = 'pol';

    /**
     * Pohnpeian.
     */
    public const string PON = 'pon';

    /**
     * Portuguese.
     */
    public const string POR = 'por';

    /**
     * Prakrit languages.
     */
    public const string PRA = 'pra';

    /**
     * Provençal, Old (to 1500); Occitan, Old (to 1500).
     */
    public const string PRO = 'pro';

    /**
     * Pushto; Pashto.
     */
    public const string PUS = 'pus';

    /**
     * Quechua.
     */
    public const string QUE = 'que';

    /**
     * Rajasthani.
     */
    public const string RAJ = 'raj';

    /**
     * Rapanui.
     */
    public const string RAP = 'rap';

    /**
     * Rarotongan; Cook Islands Maori.
     */
    public const string RAR = 'rar';

    /**
     * Romance languages.
     */
    public const string ROA = 'roa';

    /**
     * Romansh.
     */
    public const string ROH = 'roh';

    /**
     * Romany.
     */
    public const string ROM = 'rom';

    /**
     * Romanian; Moldavian; Moldovan.
     */
    public const string RON = 'ron';

    /**
     * Rundi.
     */
    public const string RUN = 'run';

    /**
     * Aromanian; Arumanian; Macedo-Romanian.
     */
    public const string RUP = 'rup';

    /**
     * Russian.
     */
    public const string RUS = 'rus';

    /**
     * Sandawe.
     */
    public const string SAD = 'sad';

    /**
     * Sango.
     */
    public const string SAG = 'sag';

    /**
     * Yakut.
     */
    public const string SAH = 'sah';

    /**
     * South American Indian languages.
     */
    public const string SAI = 'sai';

    /**
     * Salishan languages.
     */
    public const string SAL = 'sal';

    /**
     * Samaritan Aramaic.
     */
    public const string SAM = 'sam';

    /**
     * Sanskrit.
     */
    public const string SAN = 'san';

    /**
     * Sasak.
     */
    public const string SAS = 'sas';

    /**
     * Santali.
     */
    public const string SAT = 'sat';

    /**
     * Sicilian.
     */
    public const string SCN = 'scn';

    /**
     * Scots.
     */
    public const string SCO = 'sco';

    /**
     * Selkup.
     */
    public const string SEL = 'sel';

    /**
     * Semitic languages.
     */
    public const string SEM = 'sem';

    /**
     * Irish, Old (to 900).
     */
    public const string SGA = 'sga';

    /**
     * Sign Languages.
     */
    public const string SGN = 'sgn';

    /**
     * Shan.
     */
    public const string SHN = 'shn';

    /**
     * Sidamo.
     */
    public const string SID = 'sid';

    /**
     * Sinhala; Sinhalese.
     */
    public const string SIN = 'sin';

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
     * Slovak.
     */
    public const string SLK = 'slk';

    /**
     * Slovenian.
     */
    public const string SLV = 'slv';

    /**
     * Southern Sami.
     */
    public const string SMA = 'sma';

    /**
     * Northern Sami.
     */
    public const string SME = 'sme';

    /**
     * Sami languages.
     */
    public const string SMI = 'smi';

    /**
     * Lule Sami.
     */
    public const string SMJ = 'smj';

    /**
     * Inari Sami.
     */
    public const string SMN = 'smn';

    /**
     * Samoan.
     */
    public const string SMO = 'smo';

    /**
     * Skolt Sami.
     */
    public const string SMS = 'sms';

    /**
     * Shona.
     */
    public const string SNA = 'sna';

    /**
     * Sindhi.
     */
    public const string SND = 'snd';

    /**
     * Soninke.
     */
    public const string SNK = 'snk';

    /**
     * Sogdian.
     */
    public const string SOG = 'sog';

    /**
     * Somali.
     */
    public const string SOM = 'som';

    /**
     * Songhai languages.
     */
    public const string SON = 'son';

    /**
     * Sotho, Southern.
     */
    public const string SOT = 'sot';

    /**
     * Spanish; Castilian.
     */
    public const string SPA = 'spa';

    /**
     * Albanian.
     */
    public const string SQI = 'sqi';

    /**
     * Sardinian.
     */
    public const string SRD = 'srd';

    /**
     * Sranan Tongo.
     */
    public const string SRN = 'srn';

    /**
     * Serbian.
     */
    public const string SRP = 'srp';

    /**
     * Serer.
     */
    public const string SRR = 'srr';

    /**
     * Nilo-Saharan languages.
     */
    public const string SSA = 'ssa';

    /**
     * Swati.
     */
    public const string SSW = 'ssw';

    /**
     * Sukuma.
     */
    public const string SUK = 'suk';

    /**
     * Sundanese.
     */
    public const string SUN = 'sun';

    /**
     * Susu.
     */
    public const string SUS = 'sus';

    /**
     * Sumerian.
     */
    public const string SUX = 'sux';

    /**
     * Swahili.
     */
    public const string SWA = 'swa';

    /**
     * Swedish.
     */
    public const string SWE = 'swe';

    /**
     * Classical Syriac.
     */
    public const string SYC = 'syc';

    /**
     * Syriac.
     */
    public const string SYR = 'syr';

    /**
     * Tahitian.
     */
    public const string TAH = 'tah';

    /**
     * Tai languages.
     */
    public const string TAI = 'tai';

    /**
     * Tamil.
     */
    public const string TAM = 'tam';

    /**
     * Tatar.
     */
    public const string TAT = 'tat';

    /**
     * Telugu.
     */
    public const string TEL = 'tel';

    /**
     * Timne.
     */
    public const string TEM = 'tem';

    /**
     * Tereno.
     */
    public const string TER = 'ter';

    /**
     * Tetum.
     */
    public const string TET = 'tet';

    /**
     * Tajik.
     */
    public const string TGK = 'tgk';

    /**
     * Tagalog.
     */
    public const string TGL = 'tgl';

    /**
     * Thai.
     */
    public const string THA = 'tha';

    /**
     * Tigre.
     */
    public const string TIG = 'tig';

    /**
     * Tigrinya.
     */
    public const string TIR = 'tir';

    /**
     * Tiv.
     */
    public const string TIV = 'tiv';

    /**
     * Tokelau.
     */
    public const string TKL = 'tkl';

    /**
     * Klingon; tlhIngan-Hol.
     */
    public const string TLH = 'tlh';

    /**
     * Tlingit.
     */
    public const string TLI = 'tli';

    /**
     * Tamashek.
     */
    public const string TMH = 'tmh';

    /**
     * Tonga (Nyasa).
     */
    public const string TOG = 'tog';

    /**
     * Tonga (Tonga Islands).
     */
    public const string TON = 'ton';

    /**
     * Tok Pisin.
     */
    public const string TPI = 'tpi';

    /**
     * Tsimshian.
     */
    public const string TSI = 'tsi';

    /**
     * Tswana.
     */
    public const string TSN = 'tsn';

    /**
     * Tsonga.
     */
    public const string TSO = 'tso';

    /**
     * Turkmen.
     */
    public const string TUK = 'tuk';

    /**
     * Tumbuka.
     */
    public const string TUM = 'tum';

    /**
     * Tupi languages.
     */
    public const string TUP = 'tup';

    /**
     * Turkish.
     */
    public const string TUR = 'tur';

    /**
     * Altaic languages.
     */
    public const string TUT = 'tut';

    /**
     * Tuvalu.
     */
    public const string TVL = 'tvl';

    /**
     * Twi.
     */
    public const string TWI = 'twi';

    /**
     * Tuvinian.
     */
    public const string TYV = 'tyv';

    /**
     * Udmurt.
     */
    public const string UDM = 'udm';

    /**
     * Ugaritic.
     */
    public const string UGA = 'uga';

    /**
     * Uighur; Uyghur.
     */
    public const string UIG = 'uig';

    /**
     * Ukrainian.
     */
    public const string UKR = 'ukr';

    /**
     * Umbundu.
     */
    public const string UMB = 'umb';

    /**
     * Undetermined.
     */
    public const string UND = 'und';

    /**
     * Urdu.
     */
    public const string URD = 'urd';

    /**
     * Uzbek.
     */
    public const string UZB = 'uzb';

    /**
     * Vai.
     */
    public const string VAI = 'vai';

    /**
     * Venda.
     */
    public const string VEN = 'ven';

    /**
     * Vietnamese.
     */
    public const string VIE = 'vie';

    /**
     * Volapük.
     */
    public const string VOL = 'vol';

    /**
     * Votic.
     */
    public const string VOT = 'vot';

    /**
     * Wakashan languages.
     */
    public const string WAK = 'wak';

    /**
     * Wolaitta; Wolaytta.
     */
    public const string WAL = 'wal';

    /**
     * Waray.
     */
    public const string WAR = 'war';

    /**
     * Washo.
     */
    public const string WAS = 'was';

    /**
     * Sorbian languages.
     */
    public const string WEN = 'wen';

    /**
     * Walloon.
     */
    public const string WLN = 'wln';

    /**
     * Wolof.
     */
    public const string WOL = 'wol';

    /**
     * Kalmyk; Oirat.
     */
    public const string XAL = 'xal';

    /**
     * Xhosa.
     */
    public const string XHO = 'xho';

    /**
     * Yao.
     */
    public const string YAO = 'yao';

    /**
     * Yapese.
     */
    public const string YAP = 'yap';

    /**
     * Yiddish.
     */
    public const string YID = 'yid';

    /**
     * Yoruba.
     */
    public const string YOR = 'yor';

    /**
     * Yupik languages.
     */
    public const string YPK = 'ypk';

    /**
     * Zapotec.
     */
    public const string ZAP = 'zap';

    /**
     * Blissymbols; Blissymbolics; Bliss.
     */
    public const string ZBL = 'zbl';

    /**
     * Zenaga.
     */
    public const string ZEN = 'zen';

    /**
     * Standard Moroccan Tamazight.
     */
    public const string ZGH = 'zgh';

    /**
     * Zhuang; Chuang.
     */
    public const string ZHA = 'zha';

    /**
     * Chinese.
     */
    public const string ZHO = 'zho';

    /**
     * Zande languages.
     */
    public const string ZND = 'znd';

    /**
     * Zulu.
     */
    public const string ZUL = 'zul';

    /**
     * Zuni.
     */
    public const string ZUN = 'zun';

    /**
     * No linguistic content; Not applicable.
     */
    public const string ZXX = 'zxx';

    /**
     * Zaza; Dimili; Dimli; Kirdki; Kirmanjki; Zazaki.
     */
    public const string ZZA = 'zza';
}
