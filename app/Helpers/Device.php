<?php

namespace Helpers;

/**
 * Device detection helper class.
 */
class Device
{
    /**
     * @var array|null Caches device info.
     */
    private static ?array $deviceInfo = null;

    /**
     * Resets cached detection results.
     */
    public static function resetCache(): void
    {
        self::$deviceInfo = null;
    }

    /**
     * Checks if a device is a phone.
     */
    public static function ispPhone(): bool
    {
        $info = self::getDeviceInfo();
        return $info['ispPhone'];
    }

    /**
     * Checks if a device is a tablet.
     */
    public static function isTablet(): bool
    {
        $info = self::getDeviceInfo();
        return $info['isTablet'];
    }

    /**
     * Checks if a device is mobile (phone or tablet).
     */
    public static function isMobile(): bool
    {
        $info = self::getDeviceInfo();
        return $info['isMobile'];
    }

    /**
     * Checks if device is desktop.
     */
    public static function isDesktop(): bool
    {
        $info = self::getDeviceInfo();
        return $info['isDesktop'];
    }

    /**
     * Retrieves detailed device information, performs detection if not cached.
     * Analyzes User-Agent and HTTP headers.
     */
    private static function getDeviceInfo(): array
    {
        if (self::$deviceInfo !== null) {
            return self::$deviceInfo;
        }

        // Ensure $_SERVER['HTTP_USER_AGENT'] is set, default to empty string if not.
        // This is crucial for CLI environments or if the header is somehow missing.
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        // Tablet detection (sorted alphabetically)
        $tabletRegex = '/
            (android(?!.*mobile))
            |(fablet)
            |(gt-p\d{4})
            |(hp-tablet)
            |(ipad)
            |(kindle)
            |(nexus (7|9|10))
            |(playbook)
            |(samsungtab)
            |(silk)
            |(surface)
            |(tablet)
            |(transformer)
            |(windows nt.*touch)
        /ix'; // Original comments removed from inside the regex string

        $isTabletDetected = (bool)preg_match($tabletRegex, $userAgent);

        // Mobile phone detection (after tablet, sorted alphabetically)
        $mobileRegex = '/
            (android(?!.*(tab|pad|transformer|fablet)).*mobile)
            |(avantgo)
            |(bada\/)
            |(bb10)
            |(blackberry)
            |(blazer)
            |(compal)
            |(elaine)
            |(fennec)
            |(hiptop)
            |(iemobile)
            |(ip(hone|od))
            |(iris)
            |(lge |maemo)
            |(midp)
            |(mmp)
            |(mobile.+firefox)
            |(mobile.+safari)
            |(nokia)
            |(opera m(ob|in)i)
            |(palm)
            |(p(ixi|rim))
            |(pocket)
            |(psp)
            |(series(4|6)0)
            |(symbian)
            |(samsung.*mobile)
            |(treo)
            |(ucbrowser.*mobile)
            |(up\.(browser|link))
            |(vodafone)
            |(webos.*mobile)
            |(windows ce)
            |(xiino)
        /ix'; // Original comments removed from inside the regex string

        $isPhoneDetected = (bool)preg_match($mobileRegex, $userAgent);

        // Additional mobile indicators from HTTP headers
        $isMobileByHeaders = isset($_SERVER['HTTP_X_WAP_PROFILE']) ||
            isset($_SERVER['HTTP_PROFILE']) ||
            isset($_SERVER['X-OPERAMINI-PHONE-UA']) ||
            (isset($_SERVER['HTTP_ACCEPT']) && stripos($_SERVER['HTTP_ACCEPT'], 'wap') !== false);

        // Final determination logic:
        // A device is a "tablet" if $isTabletDetected.
        // A device is a "phone" if $isPhoneDetected AND it wasn't already classified as a tablet.
        // A device is "mobile" if it's a tablet OR a phone OR if headers strongly indicate mobile (and it's not already classified as a tablet).

        $isActualPhone = $isPhoneDetected && !$isTabletDetected; // A device specifically identified as a phone, not a tablet

        $isMobile = $isTabletDetected || $isActualPhone || ($isMobileByHeaders && !$isTabletDetected);
        $isDesktop = !$isMobile;

        self::$deviceInfo = [
            'isMobile' => $isMobile,        // True for tablets and phones
            'isTablet' => $isTabletDetected, // True only for tablets
            'isPhone' => $isActualPhone,     // True only for phones (not tablets)
            'isDesktop' => $isDesktop,
            'userAgent' => $userAgent
        ];

        return self::$deviceInfo;
    }
}