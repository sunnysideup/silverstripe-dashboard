<?php

declare(strict_types=1);

namespace Sunnysideup\Dashboard\Extensions;

use SilverStripe\Core\Extension;
use Sunnysideup\Dashboard\Panels\DashboardPanel;

/**
 * Decorates the {@link SiteConfig} object to work with the Dashboard CMS interface
 * SiteConfig holds the default configuration of a dashboard.
 *
 * @package Dashboard
 * @author  Uncle Cheese <unclecheese@leftandmain.com>
 */
class DashboardSiteConfig extends Extension
{
    private static $has_many = [
        'DashboardPanels' => DashboardPanel::class,
    ];
}
