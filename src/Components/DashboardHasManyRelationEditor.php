<?php

namespace Sunnysideup\Dashboard\Components;

use SilverStripe\Core\Validation\ValidationException;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\Model\ArrayData;
use SilverStripe\Control\HTTPResponse_Exception;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FormField;
use SilverStripe\ORM\DataList;
use Sunnysideup\Dashboard\DashboardPanelDataObject;
use Sunnysideup\Dashboard\Panels\DashboardPanel;

/**
 * A custom FormField object used to manage has_many relations to a DashboardPanel.
 *
 * Note: All has_many relations must be descendants of {@link DashboardPanelDataObject}
 *
 * @package Dashboard
 * @author  Uncle Cheese <unclecheese@leftandmain.com>
 */
class DashboardHasManyRelationEditor extends FormField
{
    private static $allowed_actions = [
        'handleItem',
    ];

    private static $url_handlers = [
        'item/$ID' => 'handleItem',
        '$Action!' => '$Action',
    ];

    /**
     * @var DataList The current list of records in the relation
     */
    protected $records;

    /**
     * The contructor for the editor. Sets member properties and checks for major errors.
     *
     * @param DashboardPanel The owner of the editor
     * @param string The name of the relation managed by the editor
     * @param string The class of the related object managed by the editor
     * @param string The title (label) of the editor
     * @param DashboardPanel $controller
     * @param string $relationName
     * @param string $relationClass
     */
    public function __construct(
        /**
         * @var DashboardPanel The {@link DashboardPanel} that owns this editor
         */
        protected $controller,
        /**
         * @var string The name of the relationship that is managed by this editor
         */
        protected $relationName,
        /**
         * @var string The class of the related object
         */
        protected $relationClass,
        $title = null
    ) {
        $this->title = $title;

        if (! $this->controller instanceof DashboardPanel) {
            user_error('DashboardHasManyRelationEditor must be passed an instance of DashboardPanel', E_USER_ERROR);
        }

        if (! isset($this->controller->hasMany()[$this->relationName])) {
            user_error(sprintf('DashboardHasManyRelationEditor must be passed a valid has_many relation for the panel. %s is not in the has_many array.', $this->relationName), E_USER_ERROR);
        }

        if (! is_subclass_of($this->relationClass, DashboardPanelDataObject::class)) {
            user_error('DashbordHasManyRelationEditor can only manage subclasses of DashboardPanelDataObject', E_USER_ERROR);
        }

        $this->records = $this->controller->{$this->relationName}();

        parent::__construct($this->relationName, $title);
    }

    /**
     * Gets all of the items in the relation and provides edit/delete links for the table
     */
    public function getItems(): ArrayList
    {
        $items = ArrayList::create();
        $labelField = Config::inst()->get($this->relationClass, 'label_field');

        foreach ($this->records as $record) {
            $items->push(
                ArrayData::create([
                    'Label' => $record->$labelField,
                    'DeleteLink' => Controller::join_links(
                        $this->Link('item'),
                        $record->ID,
                        'delete'
                    ),
                    'EditLink' => $this->Link('item/' . $record->ID),
                    'ID' => $record->ID,
                ])
            );
        }

        return $items;
    }

    /**
     * Handles a request for a record in the table
     *
     * @param  HTTPRequest
     * @return HTTPResponse
     * @throws HTTPResponse_Exception
     */
    public function handleItem(HTTPRequest $r)
    {
        if ($r->param('ID') == 'new') {
            $item = Injector::inst()->create($this->relationClass);
        } else {
            $item = DataList::create($this->relationClass)->byID((int) $r->param('ID'));
        }

        if ($item) {
            $handler = DashboardHasManyRelationEditorItemRequest::create($this->controller->getDashboard(), $this->controller, $this, $item);
            return $handler->handleRequest($r);
        }

        return $this->httpError(404);
    }

    /**
     * A default controller action that renders the editor
     *
     * @param  HTTPRequest
     * @return DBHTMLText
     */
    public function index(HTTPRequest $r)
    {
        return $this->FieldHolder();
    }

    /**
     * A controller action that handles the reordering of the list
     *
     * @param  HTTPRequest
     * @return HTTPResponse
     * @throws ValidationException
     */
    public function sort(HTTPRequest $r)
    {
        if ($items = $r->getVar('item')) {
            foreach ($items as $position => $id) {
                if ($item = DataList::create($this->relationClass)->byID((int) $id)) {
                    $item->SortOrder = $position;
                    $item->write();
                }
            }

            return HTTPResponse::create('OK');
        }

        return null;
    }
}
