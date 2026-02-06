<?php

namespace Sunnysideup\Dashboard\Extensions;

use SilverStripe\ORM\DataExtension;
use Sunnysideup\Dashboard\Panels\DashboardPanel;

/**
 * Decorates the {@link SiteConfig} object to work with the Dashboard CMS interface
 * SiteConfig holds the default configuration of a dashboard.
 *
 * @package Dashboard
 * @author  Uncle Cheese <unclecheese@leftandmain.com>
 */
class DashboardSiteConfig extends DataExtension
{
    private static $has_many = [
        'DashboardPanels' => DashboardPanel::class,
    ];
}
