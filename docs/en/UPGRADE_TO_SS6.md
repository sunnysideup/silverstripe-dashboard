# Upgrade Guide: sunnysideup/dashboard for Silverstripe 6

This document outlines the necessary changes to upgrade your project to the Silverstripe 6 compatible version of `sunnysideup/dashboard`.

## ⚠️ BREAKING CHANGE: Project Requirements

- **PHP**: This version requires PHP 8.1 or higher.
- **Silverstripe Framework**: The dependency on `silverstripe/framework` has been updated from `^4.0 || ^5.0` to `^6.0`.

## ⚠️ BREAKING CHANGE: Configuration

- **Database Administration Class**: The deprecated `SilverStripe\ORM\DatabaseAdmin` class has been replaced with `SilverStripe\Dev\DbBuild`. If you have custom configurations or extensions related to `DatabaseAdmin`, you must update them.

  In `_config/legacy.yml`, the mapping for `classname_value_remapping` is now under `SilverStripe\Dev\DbBuild`:

  ```yaml
  SilverStripe\Dev\DbBuild:
    classname_value_remapping:
      DashboardPanel: 'Sunnysideup\Dashboard\DashboardPanel'
      DashboardPanelDataObject: 'Sunnysideup\Dashboard\DashboardPanelDataObject'
  ```

## ⚠️ BREAKING CHANGE: API Updates & Deprecations

Several classes and methods have been updated to align with Silverstripe 6 conventions. Review your custom dashboard panels and components for the following changes:

- **Type Hinting**: Stricter type hinting has been enforced. Methods like `forTemplate()` now return `: string`.
- **PHP `#[Override]` Attribute**: The native PHP `#[Override]` attribute is now used to mark overridden methods.
- **Class Inheritance**:
  - `DashboardChart` now extends `SilverStripe\Model\ModelData` instead of `SilverStripe\View\ViewableData`.
  - `DashboardPanelAction` now extends `SilverStripe\Model\ModelData` instead of `SilverStripe\View\ViewableData`.
- **Namespace Updates for Exceptions**: `SilverStripe\ORM\ValidationException` has been replaced with `SilverStripe\Core\Validation\ValidationException`. Update any `try...catch` blocks that catch this exception.
- **Namespace Updates for Lists**: `SilverStripe\ORM\ArrayList` has been replaced with `SilverStripe\Model\List\ArrayList`.
- **Dashboard Model Class**: In the `Dashboard` admin class, the static property `$tree_class` has been renamed to `$model_class`.
  ```php
  // Before
  private static $tree_class = 'DashboardPanel';

  // After
  private static $model_class = 'DashboardPanel';
  ```
