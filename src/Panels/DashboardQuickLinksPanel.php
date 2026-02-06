<?php

namespace Sunnysideup\Dashboard\Panels;

use SilverStripe\Forms\FieldList;
use Sunnysideup\Dashboard\Components\DashboardHasManyRelationEditor;
use Sunnysideup\Dashboard\Components\DashboardQuickLink;
use Sunnysideup\Dashboard\Dashboard;

/**
 * Defines the "Quick Links" dashboard panel type
 *
 * @package Dashboard
 * @author  Uncle Cheese <unclecheese@leftandmain.com>
 */
class DashboardQuickLinksPanel extends DashboardPanel
{
    private static $table_name = 'DashboardQuickLinksPanel';

    private static $has_many = [
        'Links' => DashboardQuickLink::class,
    ];

    private static $defaults = [
        'PanelSize' => 'small',
    ];

    private static $font_icon = 'link';

    private static $configure_on_create = true;

    public function getLabel(): string
    {
        return _t(Dashboard::class . '.QUICKLINKSLABEL', 'Quick Links');
    }

    public function getDescription(): string
    {
        return _t(Dashboard::class . '.QUICKLINKSDESCRIPTION', 'Allows management of arbitrary links from the dashboard');
    }

    public function getConfigurationFields(): FieldList
    {
        $fields = parent::getConfigurationFields();

        $fields->push(DashboardHasManyRelationEditor::create(
            $this,
            'Links',
            DashboardQuickLink::class
        ));

        return $fields;
    }
}
