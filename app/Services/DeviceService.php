<?php

namespace App\Services;

/**
 * Service for detecting a user device type.
 * Determines if the device is mobile, tablet, or desktop based on User-Agent and HTTP headers.
 */
class DeviceService
{
    /**
     * @var array|null Caches device information for the current request.
     */
    private ?array $deviceInfo = null;

    /**
     * Constructs the DeviceService.
     * Device detection is performed on instantiation if not already cached.
     */
    public function __construct()
    {
        // Device info is calculated once per instance/request.
        // If instantiated via singleton in Container, it's calculated once per app run.
        $this->getDeviceInfo();
    }

    /**
     * Resets cached detection results.
     * This is primarily for testing purposes or if device context changes during a request.
     */
    public function resetCache(): void
    {
        $this->deviceInfo = null;
    }

    /**
     * Checks if the detected device is a phone.
     *
     * @return bool True if the device is identified as a phone (not a tablet).
     */
    public function isPhone(): bool
    {
        return $this->deviceInfo['isPhone'];
    }

    /**
     * Checks if the detected device is a tablet.
     *
     * @return bool True if the device is identified as a tablet.
     */
    public function isTablet(): bool
    {
        return $this->deviceInfo['isTablet'];
    }

    /**
     * Checks if the detected device is mobile (either phone or tablet).
     *
     * @return bool True if the device is mobile.
     */
    public function isMobile(): bool
    {
        return $this->deviceInfo['isMobile'];
    }

    /**
     * Checks if the detected device is a desktop.
     *
     * @return bool True if the device is a desktop.
     */
    public function isDesktop(): bool
    {
        return $this->deviceInfo['isDesktop'];
    }

    /**
     * Retrieves detailed device information, performing detection if not already cached.
     * Analyzes the User-Agent string and relevant HTTP headers.
     *
     * @return void An associative array containing 'isMobile', 'isTablet', 'isPhone', 'isDesktop', and 'userAgent'.
     */
    private function getDeviceInfo(): void
    {
        if ($this->deviceInfo !== null) {
            return;
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

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
        /ix';

        $isTabletDetected = (bool)preg_match($tabletRegex, $userAgent);

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
        /ix';

        $isPhoneDetected = (bool)preg_match($mobileRegex, $userAgent);

        $isMobileByHeaders = isset($_SERVER['HTTP_X_WAP_PROFILE']) ||
            isset($_SERVER['HTTP_PROFILE']) ||
            isset($_SERVER['X-OPERAMINI-PHONE-UA']) ||
            (isset($_SERVER['HTTP_ACCEPT']) && stripos($_SERVER['HTTP_ACCEPT'], 'wap') !== false);

        // Final determination logic:
        // A device is a "tablet" of $isTabletDetected.
        // A device is a "phone" if $isPhoneDetected AND it wasn't already classified as a tablet.
        // A device is "mobile" if it's a tablet OR a phone OR if headers strongly indicate mobile (and it's not already classified as a tablet).

        $isActualPhone = $isPhoneDetected && !$isTabletDetected; // A device specifically identified as a phone, not a tablet

        $isMobile = $isTabletDetected || $isActualPhone || $isMobileByHeaders;
        $isDesktop = !$isMobile;

        $this->deviceInfo = [
            'isMobile' => $isMobile,         // True for tablets and phones
            'isTablet' => $isTabletDetected, // True only for tablets
            'isPhone' => $isActualPhone,     // True only for phones (not tablets)
            'isDesktop' => $isDesktop,
            'userAgent' => $userAgent
        ];

    }
}