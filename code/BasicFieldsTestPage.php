<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\FrameworkTest\Model\TestCategory;
use SilverStripe\FrameworkTest\Model\TestPage;
use SilverStripe\FrameworkTest\Model\TestPage_Controller;
use SilverStripe\Core\Object;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\SelectionGroup_Item;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\AssetField;
use SilverStripe\Forms\UploadField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\RequiredFields;


class BasicFieldsTestPage extends TestPage
{
    private static $db = array(
        'AjaxUniqueText' => 'Varchar',
        'Autocomplete' => 'Varchar',
        'BankNumber' => 'Varchar',
        'CalendarDate' => 'Date',
        'Checkbox' => 'Boolean',
        'CompositeDate' => 'Date',
        'ConfirmedPassword' => 'Varchar',
        'CreditCard' => 'Varchar',
        'Date' => 'Date',
        'DateTime' => 'Datetime',
        'DateTimeWithCalendar' => 'Datetime',
        'DBFile' => 'DBFile',
        'DMYCalendarDate' => 'Date',
        'DMYDate' => 'Date',
        'Email' => 'Varchar',
        'GSTNumber' => 'Varchar',
        'HTMLField' => 'HTMLText',
        'HTMLOneLine' => 'HTMLVarchar',
        'Money' => 'Money',
        'Number' => 'Int',
        'OptionSet' => 'Int',
        'Password' => 'Varchar',
        'PhoneNumber' => 'Varchar',
        'Price' => 'Double',
        'Readonly' => 'Varchar',
        'Required' => 'Text',
        'Text' => 'Varchar',
        'Textarea' => 'Text',
        'Time' => 'Time',
        'UniqueRestrictedText' => 'Varchar',
        'UniqueText' => 'Varchar',
        'Validated' => 'Text',
    );

    private static $has_one = array(
        'AttachedFile' => 'SilverStripe\\Assets\\File',
        'Dropdown' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
        'File' => 'SilverStripe\\Assets\\File',
        'GroupedDropdown' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
        'Image' => 'SilverStripe\\Assets\\Image',
    );

    private static $has_many = array(
        'HasManyFiles' => 'SilverStripe\\Assets\\File',
    );

    private static $many_many = array(
        'ManyManyFiles' => 'SilverStripe\\Assets\\File',
        'MultipleListboxField' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
    );

    private static $defaults = array(
        'Validated' => 2
    );

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        if ($inst = DataObject::get_one('BasicFieldsTestPage')) {
            $data = $this->getDefaultData();
            $inst->update($data);
            $inst->write();
        }
    }

    public function getDefaultData()
    {
        $cats = TestCategory::get();
        if (!$cats->Count()) {
            return array();
        } // not initialized yet

        $firstCat = $cats->offsetGet(0);
        $thirdCat = $cats->offsetGet(2);

        return array(
            'CalendarDate' => "2002-10-23",
            'Checkbox' => 1,
            'CheckboxSetID' => $firstCat->ID,
            'CreditCard' => '4000400040004111',
            'Date' => "2002-10-23",
            'DateTime' => "2002-10-23 23:59",
            'DateTimeWithCalendar' => "2002-10-23 23:59",
            'DMYDate' => "2002-10-23",
            'DropdownID' => $firstCat->ID,
            'Email' => 'test@test.com',
            'GroupedDropdownID' => $firstCat->ID,
            'HTMLField' => 'My <strong>value</strong> (ä!)',
            'MoneyAmount' => 99.99,
            'MoneyCurrency' => 'EUR',
            'MultipleListboxFieldID' => join(',', array($thirdCat->ID, $firstCat->ID)),
            'MyCompositeField1' => 'My value (ä!)',
            'MyCompositeField2' => 'My value (ä!)',
            'MyCompositeField3' => 'My value (ä!)',
            'MyCompositeFieldCheckbox' => true,
            'MyFieldGroup1' => 'My value (ä!)',
            'MyFieldGroup2' => 'My value (ä!)',
            'MyFieldGroup3' => 'My value (ä!)',
            'MyFieldGroupCheckbox' => true,
            'Number' => 99,
            'OptionSet' => join(',', array($thirdCat->ID, $firstCat->ID)),
            'Password' => 'My value (ä!)',
            'PhoneNumber' => '021 1235',
            'Price' => 99.99,
            'Readonly' => 'My value (ä!)',
            'Required' => 'My required value (delete to test)',
            'Text' => 'My value (ä!)',
            'Textarea' => 'My value (ä!)',
            'Textarea' => 'My value (ä!)',
            'Time' => "23:59",
            'Validated' => '1',
        );
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $description = 'This is <strong>bold</strong> help text';
        $rightTitle = 'This is right title';

        $fields->addFieldsToTab('Root.Text', array(
            Object::create('SilverStripe\\Forms\\TextField', 'Required', 'Required field')
                ->setRightTitle('right title'),
            Object::create('SilverStripe\\Forms\\TextField', 'Validated', 'Validated field (checks range between 1 and 3)'),
            Object::create('SilverStripe\\Forms\\ReadonlyField', 'Readonly', 'ReadonlyField'),
            Object::create('SilverStripe\\Forms\\TextareaField', 'Textarea', 'TextareaField - 8 rows')
                ->setRows(8),
            Object::create('SilverStripe\\Forms\\TextField', 'Text'),
            Object::create('SilverStripe\\Forms\\HTMLEditor\\HTMLEditorField', 'HTMLField', 'HTMLField'),
            Object::create('SilverStripe\\Forms\\EmailField', 'Email'),
            Object::create('SilverStripe\\Forms\\PasswordField', 'Password'),
            Object::create('SilverStripe\\Forms\\ConfirmedPasswordField', 'ConfirmedPassword')
        ));

        $fields->addFieldsToTab('Root.Numeric', array(
            Object::create('SilverStripe\\Forms\\NumericField', 'Number'),
            Object::create('SilverStripe\\Forms\\CurrencyField', 'Price'),
            Object::create('SilverStripe\\Forms\\MoneyField', 'Money', 'Money', array('Amount' => 99.99, 'Currency' => 'EUR')),
            Object::create('SilverStripe\\Forms\\PhoneNumberField', 'PhoneNumber'),
            Object::create('SilverStripe\\Forms\\CreditCardField', 'CreditCard')
        ));

        $fields->addFieldsToTab('Root.Option', array(
            Object::create('SilverStripe\\Forms\\CheckboxField', 'Checkbox'),
            Object::create('SilverStripe\\Forms\\CheckboxSetField', 'CheckboxSet', 'CheckboxSet', TestCategory::map()),
            Object::create('SilverStripe\\Forms\\DropdownField', 'DropdownID', 'DropdownField', TestCategory::map())
                ->setHasEmptyDefault(true),
            Object::create('SilverStripe\\Forms\\GroupedDropdownField', 'GroupedDropdownID',
                'GroupedDropdown', array('Test Categories' => TestCategory::map())
            ),
            Object::create('SilverStripe\\Forms\\ListboxField', 'MultipleListboxFieldID', 'ListboxField (multiple)', TestCategory::map())
                ->setSize(3),
            Object::create('SilverStripe\\Forms\\OptionsetField', 'OptionSet', 'OptionSetField', TestCategory::map()),
            Object::create('SilverStripe\\Forms\\SelectionGroup', 'SelectionGroup', array(
                new SelectionGroup_Item(
                    'one',
                    TextField::create('SelectionGroupOne', 'one view'),
                    'SelectionGroup Option One'
                ),
                    new SelectionGroup_Item(
                    'two',
                    TextField::create('SelectionGroupOneTwo', 'two view'),
                    'SelectionGroup Option Two'
                )
            )),
            Object::create('SilverStripe\\Forms\\ToggleCompositeField', 'ToggleCompositeField', 'ToggleCompositeField', new FieldList(
                Object::create('SilverStripe\\Forms\\TextField', 'ToggleCompositeTextField1'),
                Object::create('SilverStripe\\Forms\\TextField', 'ToggleCompositeTextField2'),
                Object::create('SilverStripe\\Forms\\DropdownField', 'ToggleCompositeDropdownField', 'ToggleCompositeDropdownField', TestCategory::map()),
                Object::create('SilverStripe\\Forms\\TextField', 'ToggleCompositeTextField3')
            ))
        ));

        // All these date/time fields generally have issues saving directly in the CMS
        $fields->addFieldsToTab('Root.DateTime', array(
            $calendarDateField = Object::create('SilverStripe\\Forms\\DateField', 'CalendarDate', 'DateField with calendar'),
            Object::create('SilverStripe\\Forms\\DateField', 'Date', 'DateField'),
            $dmyDateField = Object::create('SilverStripe\\Forms\\DateField', 'DMYDate', 'DateField with separate fields'),
            Object::create('SilverStripe\\Forms\\TimeField', 'Time', 'TimeField'),
            Object::create('SilverStripe\\Forms\\DatetimeField', 'DateTime', 'DateTime'),
            $dateTimeShowCalendar = Object::create('SilverStripe\\Forms\\DatetimeField', 'DateTimeWithCalendar', 'DateTime with calendar')
        ));
        $calendarDateField->setConfig('showcalendar', true);
        $dmyDateField->setConfig('dmyfields', true);
        $dateTimeShowCalendar->getDateField()->setConfig('showcalendar', true);
        $dateTimeShowCalendar->getTimeField()->setConfig('showdropdown', true);
        $dateTimeShowCalendar->setRightTitle('Right title');

        $fields->addFieldsToTab('Root.File', array(
            AssetField::create('DBFile'),
            $bla = UploadField::create('File', 'FileUploadField')
                ->setDescription($description)
                ->setRightTitle($rightTitle)
                ->setConfig('allowedMaxFileNumber', 1)
                ->setConfig('canPreviewFolder', false),
            UploadField::create('AttachedFile', 'UploadField with canUpload=false')
                ->setDescription($description)
                ->setRightTitle($rightTitle)
                ->setConfig('canUpload', false),
            UploadField::create('Image', 'UploadField for image')
                ->setDescription($description)
                ->setRightTitle($rightTitle),
            UploadField::create('HasManyFiles', 'UploadField for has_many')
                ->setRightTitle($rightTitle)
                ->setDescription($description),
            UploadField::create('ManyManyFiles', 'UploadField for many_many')
                ->setDescription($description)
                ->setRightTitle($rightTitle),
        ));

        $data = $this->getDefaultData();
        foreach ($fields->dataFields() as $field) {
            $name = $field->getName();
            if (isset($data[$name])) {
                $field->setValue($data[$name]);
            }
        }

        $blacklist = array(
            'DMYDate', 'Required', 'Validated', 'ToggleCompositeField', 'SelectionGroup'
        );

        $tabs = array('Root.Text', 'Root.Numeric', 'Root.Option', 'Root.DateTime', 'Root.File');
        foreach ($tabs as $tab) {
            $tabObj = $fields->fieldByName($tab);
            foreach ($tabObj->FieldList() as $field) {
                $field
                    ->setDescription($description)
                    ->setRightTitle($rightTitle);
                    // ->addExtraClass('cms-description-tooltip');

                if (in_array($field->getName(), $blacklist)) {
                    continue;
                }

                $disabledField = $field->performDisabledTransformation();
                $disabledField->setTitle($disabledField->Title() . ' (disabled)');
                $disabledField->setName($disabledField->getName() . '_disabled');
                $disabledField->setValue($field->Value());
                $tabObj->insertAfter($disabledField, $field->getName());

                $readonlyField = $field->performReadonlyTransformation();
                $readonlyField->setTitle($readonlyField->Title() . ' (readonly)');
                $readonlyField->setName($readonlyField->getName() . '_readonly');
                $readonlyField->setValue($field->Value());
                $tabObj->insertAfter($readonlyField, $field->getName());
            }
        }

        $noLabelField = new TextField('Text_NoLabel', false, 'TextField without label');
        $noLabelField->setDescription($description);
        $noLabelField->setRightTitle($rightTitle);
        $fields->addFieldToTab('Root.Text', $noLabelField, 'Text_disabled');

        $fields->addFieldToTab('Root.Text',
            LabelField::create('SilverStripe\\Forms\\LabelField', 'LabelField')
        );

        $fields->addFieldToTab('Root.Text',
            LiteralField::create('SilverStripe\\Forms\\LiteralField', '<div class="form__divider">LiteralField with <b>some bold text</b> and <a href="http://silverstripe.com">a link</a></div>')
        );

        $fields->addFieldToTab('Root.Text',
            FieldGroup::create(
                TextField::create('MyFieldGroup1'),
                TextField::create('MyFieldGroup2'),
                DropdownField::create('MyFieldGroup3', false, TestCategory::map()),
                CheckboxField::create('MyFieldGroupCheckbox')
            )
                ->setDescription($description)
                ->setRightTitle($rightTitle)
        );
        $fields->addFieldToTab('Root.Text',
            FieldGroup::create(
                'MyLabelledFieldGroup',
                array(
                    TextField::create('MyLabelledFieldGroup1'),
                    TextField::create('MyLabelledFieldGroup2'),
                    DropdownField::create('MyLabelledFieldGroup3', null, TestCategory::map()),
                    CheckboxField::create('MyLabelledFieldGroupCheckbox')
                )
            )
                ->setTitle('My Labelled Field Group')
                ->setDescription($description)
                ->setRightTitle($rightTitle)
        );

        $fields->addFieldToTab('Root.Text',
            CompositeField::create(
                TextField::create('MyCompositeField1'),
                TextField::create('MyCompositeField2'),
                DropdownField::create('MyCompositeField3', 'MyCompositeField3', TestCategory::map()),
                CheckboxField::create('MyCompositeFieldCheckbox')
            )
        );

        return $fields;
    }

    public function getCMSValidator()
    {
        return new RequiredFields('Required');
    }

    public function validate()
    {
        $result = parent::validate();
        if (!$this->Validated || $this->Validated < 1 || $this->Validated > 3) {
            $result->error('"Validated" field needs to be between 1 and 3');
        }
        return $result;
    }
}

class BasicFieldsTestPage_Controller extends TestPage_Controller
{
    public function AutoCompleteItems()
    {
        $items = array(
            'TestItem1',
            'TestItem2',
            'TestItem3',
            'TestItem4',
        );
        return implode(',', $items);
    }
}
