<?php

namespace Sunnysideup\Dashboard\Components;

use Override;
use SilverStripe\Model\ModelData;

/**
 * Defines the object that renders as a button in a dashboard panel
 *
 * @package Dashboard
 * @author  Uncle Cheese <unclecheese@leftandmain.com>
 */
class DashboardPanelAction extends ModelData
{
    /**
     * @param string $link
     * @param string $title
     * @param string $type
     */
    public function __construct(
        /**
         * @var string The link for this action button
         */
        protected $Link,
        /**
         * @var string The title (label) of the button
         */
        protected $Title,
        /**
         * @var string The type of action. Default is the plain button color.
         *                A value of "good" will provide a green "constructive" button
         *
         * @todo More button types?
         */
        protected $Type = null
    )
    {
    }

    /**
     * Converts the simple type name into a real SS CSS class.
     *
     * @return string
     */
    public function getUIClass()
    {
        if ($this->Type === 'good') {
            return 'btn-primary';
        }

        return '';
    }

    /**
     * Gets the HTML link
     *
     * @return string
     */
    #[Override]
    public function forTemplate(): string
    {
        return $this->renderWith($this->getViewerTemplates());
    }

    /**
     * A template accessor used to render this object
     *
     * @return string
     */
    public function Action()
    {
        return $this->forTemplate();
    }
}
