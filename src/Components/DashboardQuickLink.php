<?php

namespace Sunnysideup\Dashboard\Components;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use Sunnysideup\Dashboard\DashboardPanelDataObject;
use Sunnysideup\Dashboard\Panels\DashboardQuickLinksPanel;

/**
 * Defines the "quick link" dataobject that is used in {@link DashboardQuickLinksPanel}
 *
 * @package Dashboard
 * @author  Uncle Cheese <unclecheese@leftandmain.com>
 */
class DashboardQuickLink extends DashboardPanelDataObject
{
    private static $table_name = 'DashboardQuickLink';

    private static $db = [
        'Link' => 'Varchar(255)',
        'Text' => 'Varchar(50)',
        'NewWindow' => 'Boolean',
    ];

    private static $has_one = [
        'Panel' => DashboardQuickLinksPanel::class,
    ];

    private static $label_field = 'Text';

    public function getConfigurationFields(): FieldList
    {
        $fields = parent::getConfigurationFields();
        $fields->push(
            TextField::create(
                'Link',
                _t(static::class . '.LINK', 'Link (include http://)')
            )
        );
        $fields->push(
            TextField::create(
                'Text',
                _t(static::class . '.LINKTEXT', 'Link text')
            )
        );
        $fields->push(
            CheckboxField::create(
                'NewWindow',
                _t(static::class . '.NEWWINDOW', 'Open link in new window')
            )
        );

        return $fields;
    }
}
