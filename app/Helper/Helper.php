<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

// Get Youtube ID
function getYoutubeId($url)
{
    parse_str(parse_url($url, PHP_URL_QUERY), $youtubeUrlArray);
    return $youtubeUrlArray['v'];
}

function lock($string)
{
    if (auth()->user()) {
        $string = Crypt::encrypt(Auth::user()->email) . '@' . Crypt::encrypt($string) . '@' . Crypt::encrypt(Auth::user()->id);
    } else {
        $string = Crypt::encrypt($string);
    }
    return $string;
}

function unlock($string)
{
    if (auth()->user()) {
        $string = explode('@', $string);
        if (Auth::user()->email == Crypt::decrypt($string[0]) && Auth::user()->id == Crypt::decrypt($string[2])) {
            return Crypt::decrypt($string[1]);
        }
    } else {
        return Crypt::decrypt($string);
    }
}
/**
 * Format bytes to kb, mb, gb, tb
 *
 * @param  integer $size
 * @param  integer $precision
 * @return integer
 */
function formatBytes($size, $precision = 2)
{
    if ($size > 0) {
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    } else {
        return $size;
    }
}

// Multidimentional array unique
function array_unique_multidimention($array, $key)
{
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach ($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

function getAssetUrl($filename, $folder = '')
{
    if (empty($filename)) {
        return null;
    }
    if (str_starts_with($filename, 'http')) {
        return $filename;
    } else {
        return asset($folder . '/' . $filename);
    }
}

function isApiUrl(): bool
{
    return str_contains(request()->route()->uri, 'api/') ? true : false;
}

// Greeting message
function greetings()
{
    // 24-hour format of an hour without leading zeros (0 through 23)
    $Hour = date('G');

    if ($Hour >= 5 && $Hour <= 11) {
        return 'Good Morning';
    } elseif ($Hour >= 12 && $Hour <= 18) {
        return 'Good Afternoon';
    } elseif ($Hour >= 19 || $Hour <= 4) {
        return 'Good Evening';
    }
}

// get thumbnail unique name
function getImageName($file)
{
    return preg_replace('/[^a-zA-Z0-9._-]/', '', str_replace(' ', '-', time() . '--' . $file));
}

/**
 * Validate if the given number is a valid number for conversion.
 *
 * @param mixed $number The number to validate.
 *
 * @throws InvalidNumber If the number is not valid.
 * @throws InvalidRange If the number is out of valid range.
 *
 * @return void
 */
function isValid($number)
{
    if (!is_numeric($number) || preg_match('/\.\d+\./', $number) || preg_match('/\d+E\d+/', $number)) {
        throw ('The given value is not a valid number.');
    }

    if (abs($number) > 999999999999999) {
        throw ('Invalid Range Maximum accepted value is ' . $number);
    }
}
/**
 * Convert number into Bangla representation
 *
 * @param $number
 * @return string
 * @throws InvalidNumber
 * @throws InvalidRange
 */
function bnNum($number): string
{
    $numbers = [
        '০',
        '১',
        '২',
        '৩',
        '৪',
        '৫',
        '৬',
        '৭',
        '৮',
        '৯',
    ];
    // isValid($number);

    return strtr($number, $numbers);
}

function enNum($banglaNumber)
{
    $banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    return str_replace($banglaDigits, $englishDigits, $banglaNumber);
}

// BDT
function currency($amount)
{

    if (app()->isLocale('bn')) {
        $amount = bnNum($amount);
    }
    return __('৳') . ' ' . $amount;
}

function getLocaleDate($inputDate)
{
    $inputDate = $inputDate->format('d F, Y \a\t h:i a');
    if (app()->isLocale('en')) {
        return $inputDate;
    }

    // Define arrays for mapping English and Bangla month names
    $englishMonths = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December',
    ];

    $banglaMonths = [
        'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
        'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর',
    ];

    // Extract date components
    $dateTime = \DateTime::createFromFormat('d F, Y \a\t h:i a', $inputDate);

    if (!$dateTime) {
        // Handle invalid date format
        return 'Invalid date format';
    }

    // Get Bangla day, month, and year
    $banglaDay = bnNum($dateTime->format('d'));
    $englishMonth = $dateTime->format('F');
    $banglaMonth = str_replace($englishMonths, $banglaMonths, $englishMonth);
    $banglaYear = bnNum($dateTime->format('Y'));
    $time = bnNum($dateTime->format('h:i'));
    $banglaTime = convertTimeToBangla($dateTime->format('h:i a'));

    // Format the date in the desired format
    $formattedDate = $banglaDay . ' ' . $banglaMonth . ', ' . $banglaYear . ' সময় ' . $banglaTime;

    return $formattedDate;
}

// Function to convert time to Bangla
function convertTimeToBangla($time)
{
    // Define arrays for mapping English and Bangla time-related terms
    $englishTimeTerms = ['am', 'pm'];
    $banglaTimeTerms = ['পূর্বাহ্ণ', 'অপরাহ্ণ'];

    // Get hours, minutes, and AM/PM
    $timeArray = explode(':', date('h:i', strtotime($time)));
    $hours = $timeArray[0];
    $minutes = $timeArray[1];
    $ampm = explode(' ', date('h:i a', strtotime($time)))[1];

    // Convert hours and minutes to Bangla
    $banglaTime = bnNum($hours) . ':' . bnNum($minutes);

    // Replace AM/PM with Bangla terms
    $banglaTime .= ' ' . str_replace($englishTimeTerms, $banglaTimeTerms, $ampm);

    return $banglaTime;
}

function convertToBanglaDate($dateString, $format = 'd/m/Y')
{
    if (app()->isLocale('en')) {
        return $dateString;
    }

    // Parse the input date using Carbon
    $date = Carbon::createFromFormat($format, $dateString);

    // Format the date in Bangla style
    $formattedDate = $date->isoFormat('LL');

    return $formattedDate;
}

function convertReceiptNubmer($receipt_no)
{
    if (app()->isLocale('en')) {
        return $receipt_no;
    }
    if(str_contains($receipt_no, '-')) {
         $number_array = explode('-', $receipt_no);

        return $number_array[0] . '-' . bnNum($number_array[1]);
    }

    return $receipt_no;

}

// app/Helpers/DigitLanguageHelper.php

if (!function_exists('checkDigitLanguage')) {
    function checkDigitLanguage($inputDigit)
    {
        // Regular expression to check if the input contains only English digits
        $englishPattern = '/^[0-9]+$/';

        // Regular expression to check if the input contains only Bangla digits
        $banglaPattern = '/^[০-৯]+$/u';

        if (preg_match($englishPattern, $inputDigit)) {
            return 'english';
        } elseif (preg_match($banglaPattern, $inputDigit)) {
            return 'bangla';
        } else {
            return 'unknown';
        }
    }
}

// icofont icons name
function icofontIconsName()
{
    $social = [
        "icofont-500px" => "icofont-500px",
        "icofont-aim" => "icofont-aim",
        "icofont-badoo" => "icofont-badoo",
        "icofont-baidu-tieba" => "icofont-baidu-tieba",
        "icofont-bbm-messenger" => "icofont-bbm-messenger",
        "icofont-bebo" => "icofont-bebo",
        "icofont-behance" => "icofont-behance",
        "icofont-blogger" => "icofont-blogger",
        "icofont-bootstrap" => "icofont-bootstrap",
        "icofont-brightkite" => "icofont-brightkite",
        "icofont-cloudapp" => "icofont-cloudapp",
        "icofont-concrete5" => "icofont-concrete5",
        "icofont-delicious" => "icofont-delicious",
        "icofont-designbump" => "icofont-designbump",
        "icofont-designfloat" => "icofont-designfloat",
        "icofont-deviantart" => "icofont-deviantart",
        "icofont-digg" => "icofont-digg",
        "icofont-discord" => "icofont-discord",
        "icofont-dotcms" => "icofont-dotcms",
        "icofont-dribbble" => "icofont-dribbble",
        "icofont-dribble" => "icofont-dribble",
        "icofont-dropbox" => "icofont-dropbox",
        "icofont-ebuddy" => "icofont-ebuddy",
        "icofont-ello" => "icofont-ello",
        "icofont-ember" => "icofont-ember",
        "icofont-envato" => "icofont-envato",
        "icofont-evernote" => "icofont-evernote",
        "icofont-facebook-messenger" => "icofont-facebook-messenger",
        "icofont-facebook" => "icofont-facebook",
        "icofont-feedburner" => "icofont-feedburner",
        "icofont-flikr" => "icofont-flikr",
        "icofont-folkd" => "icofont-folkd",
        "icofont-foursquare" => "icofont-foursquare",
        "icofont-friendfeed" => "icofont-friendfeed",
        "icofont-ghost" => "icofont-ghost",
        "icofont-github" => "icofont-github",
        "icofont-gnome" => "icofont-gnome",
        "icofont-google-buzz" => "icofont-google-buzz",
        "icofont-google-hangouts" => "icofont-google-hangouts",
        "icofont-google-map" => "icofont-google-map",
        "icofont-google-plus" => "icofont-google-plus",
        "icofont-google-talk" => "icofont-google-talk",
        "icofont-hype-machine" => "icofont-hype-machine",
        "icofont-instagram" => "icofont-instagram",
        "icofont-kakaotalk" => "icofont-kakaotalk",
        "icofont-kickstarter" => "icofont-kickstarter",
        "icofont-kik" => "icofont-kik",
        "icofont-kiwibox" => "icofont-kiwibox",
        "icofont-line-messenger" => "icofont-line-messenger",
        "icofont-line" => "icofont-line",
        "icofont-linkedin" => "icofont-linkedin",
        "icofont-linux-mint" => "icofont-linux-mint",
        "icofont-live-messenger" => "icofont-live-messenger",
        "icofont-livejournal" => "icofont-livejournal",
        "icofont-magento" => "icofont-magento",
        "icofont-meetme" => "icofont-meetme",
        "icofont-meetup" => "icofont-meetup",
        "icofont-mixx" => "icofont-mixx",
        "icofont-newsvine" => "icofont-newsvine",
        "icofont-nimbuss" => "icofont-nimbuss",
        "icofont-odnoklassniki" => "icofont-odnoklassniki",
        "icofont-opencart" => "icofont-opencart",
        "icofont-oscommerce" => "icofont-oscommerce",
        "icofont-pandora" => "icofont-pandora",
        "icofont-photobucket" => "icofont-photobucket",
        "icofont-picasa" => "icofont-picasa",
        "icofont-pinterest" => "icofont-pinterest",
        "icofont-prestashop" => "icofont-prestashop",
        "icofont-qik" => "icofont-qik",
        "icofont-qq" => "icofont-qq",
        "icofont-readernaut" => "icofont-readernaut",
        "icofont-reddit" => "icofont-reddit",
        "icofont-renren" => "icofont-renren",
        "icofont-rss" => "icofont-rss",
        "icofont-shopify" => "icofont-shopify",
        "icofont-silverstripe" => "icofont-silverstripe",
        "icofont-skype" => "icofont-skype",
        "icofont-slack" => "icofont-slack",
        "icofont-slashdot" => "icofont-slashdot",
        "icofont-slidshare" => "icofont-slidshare",
        "icofont-smugmug" => "icofont-smugmug",
        "icofont-snapchat" => "icofont-snapchat",
        "icofont-soundcloud" => "icofont-soundcloud",
        "icofont-spotify" => "icofont-spotify",
        "icofont-stack-exchange" => "icofont-stack-exchange",
        "icofont-stack-overflow" => "icofont-stack-overflow",
        "icofont-steam" => "icofont-steam",
        "icofont-stumbleupon" => "icofont-stumbleupon",
        "icofont-tagged" => "icofont-tagged",
        "icofont-technorati" => "icofont-technorati",
        "icofont-telegram" => "icofont-telegram",
        "icofont-tiktok" => "icofont-tiktok",
        "icofont-tinder" => "icofont-tinder",
        "icofont-trello" => "icofont-trello",
        "icofont-tumblr" => "icofont-tumblr",
        "icofont-twitch" => "icofont-twitch",
        "icofont-twitter" => "icofont-twitter",
        "icofont-typo3" => "icofont-typo3",
        "icofont-ubercart" => "icofont-ubercart",
        "icofont-viber" => "icofont-viber",
        "icofont-viddler" => "icofont-viddler",
        "icofont-vimeo" => "icofont-vimeo",
        "icofont-vine" => "icofont-vine",
        "icofont-virb" => "icofont-virb",
        "icofont-virtuemart" => "icofont-virtuemart",
        "icofont-vk" => "icofont-vk",
        "icofont-wechat" => "icofont-wechat",
        "icofont-weibo" => "icofont-weibo",
        "icofont-whatsapp" => "icofont-whatsapp",
        "icofont-xing" => "icofont-xing",
        "icofont-yahoo" => "icofont-yahoo",
        "icofont-yelp" => "icofont-yelp",
        "icofont-youku" => "icofont-youku",
        "icofont-youtube" => "icofont-youtube",
        "icofont-zencart" => "icofont-zencart",
        "icofont-duotone" => "icofont-duotone",
    ];
    return [
        'social' => $social,
    ];
}

// Countries with initials
function getCountries()
{
    $countries =
    array(
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, the Democratic Republic of the",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote D'Ivoire",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands (Malvinas)",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and Mcdonald Islands",
        "VA" => "Holy See (Vatican City State)",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran, Islamic Republic of",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic People's Republic of",
        "KR" => "Korea, Republic of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People's Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macao",
        "MK" => "Macedonia, the Former Yugoslav Republic of",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia, Federated States of",
        "MD" => "Moldova, Republic of",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territory, Occupied",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome and Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "CS" => "Serbia and Montenegro",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan, Province of China",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania, United Republic of",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "UM" => "United States Minor Outlying Islands",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Viet Nam",
        "VG" => "Virgin Islands, British",
        "VI" => "Virgin Islands, U.s.",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe",
    );
    return $countries;
}
