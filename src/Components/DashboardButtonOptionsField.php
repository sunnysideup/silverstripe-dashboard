<?php

namespace Sunnysideup\Dashboard\Components;

use Override;
use SilverStripe\Forms\OptionsetField;

class DashboardButtonOptionsField extends OptionsetField
{
    protected $size;

    #[Override]
    public function FieldHolder($attributes = [])
    {
        return parent::FieldHolder($attributes);
    }

    public function setSize($size): self
    {
        $this->size = $size;
        return $this;
    }
}
