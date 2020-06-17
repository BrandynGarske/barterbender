<?php


namespace Apps\Core_MobileApi\Version1_6\Api\Form\Event;

use Apps\Core_MobileApi\Api\Form\GeneralForm;
use Apps\Core_MobileApi\Api\Form\Type\AttachmentType;
use Apps\Core_MobileApi\Api\Form\Type\DateTimeType;
use Apps\Core_MobileApi\Api\Form\Type\FileType;
use Apps\Core_MobileApi\Api\Form\Type\HierarchyType;
use Apps\Core_MobileApi\Api\Form\Type\LocationType;
use Apps\Core_MobileApi\Api\Form\Type\SubmitType;
use Apps\Core_MobileApi\Api\Form\Type\TextareaType;
use Apps\Core_MobileApi\Api\Form\Type\TextType;
use Apps\Core_MobileApi\Api\Form\Validator\RequiredValidator;
use Apps\Core_MobileApi\Api\Form\Validator\StringLengthValidator;
use Apps\Core_MobileApi\Api\Form\Validator\TypeValidator;

class EventForm extends GeneralForm
{
    protected $categories;
    protected $countries;
    protected $tags;
    protected $action = "event";

    /**
     * @param null  $options
     * @param array $data
     *
     * @return mixed|void
     * @throws \Apps\Core_MobileApi\Api\Exception\ErrorException
     * @throws \Apps\Core_MobileApi\Api\Exception\ValidationErrorException
     */
    function buildForm($options = null, $data = [])
    {
        $sectionName = 'basic';
        $this->addSection($sectionName, 'basic_info')
            ->addField('title', TextType::class, [
                'label'       => 'event_name',
                'placeholder' => 'fill_title_for_event',
                'required'    => true
            ], [new StringLengthValidator(1, 250)], $sectionName)
            ->addField('categories', HierarchyType::class, [
                'label'    => 'categories',
                'rawData'  => $this->categories,
                'multiple' => false
            ], [new TypeValidator(TypeValidator::IS_ARRAY_NUMERIC)], $sectionName)
            ->addField('text', TextareaType::class, [
                'label'       => 'description',
                'placeholder' => 'add_description_to_event',
            ], null, $sectionName)
            ->addField('attachment', AttachmentType::class, [
                'label'               => 'attachment',
                'item_type'           => "event",
                'item_id'             => (isset($this->data['id']) ? $this->data['id'] : null),
                'current_attachments' => $this->getAttachments()
            ], [new TypeValidator(TypeValidator::IS_ARRAY_NUMERIC)], $sectionName);

        $sectionName = 'additional_info';
        $this->addSection($sectionName, 'additional_info')
            ->addField('start_time', DateTimeType::class, [
                'label'       => 'start_time',
                'placeholder' => 'select_time',
                'required'    => true
            ], [new RequiredValidator()], $sectionName)
            ->addField('end_time', DateTimeType::class, [
                'label'       => 'end_time',
                'placeholder' => 'select_time',
                'required'    => true
            ], [new RequiredValidator()], $sectionName)
            ->addField('location', LocationType::class, [
                'label'         => 'location_venue',
                'placeholder'   => 'enter_location',
                'use_transform' => true,
                'required'      => true
            ], [new RequiredValidator()], $sectionName)
            ->addField('file', FileType::class, [
                'label'               => 'banner',
                'file_type'           => 'photo',
                'item_type'           => 'event',
                'preview_url'         => $this->getPreviewImage(),
                'max_upload_filesize' => $this->getSizeLimit($this->setting->getUserSetting('event.max_upload_size_event'))
            ], null, $sectionName);

        $sectionName = 'settings';
        $this
            ->addSection($sectionName, 'settings');
        if (empty($this->data['item_id'])) {
            $this->addPrivacyField([
                'description'    => 'control_who_can_see_this_event',
                'disable_custom' => true
            ], $sectionName, $this->privacy->getValue('event.display_on_profile'));
        }
        $this
            ->addModuleFields([
                'module_value' => 'event'
            ])
            ->addField('submit', SubmitType::class, [
                'label' => 'save'
            ]);
    }


    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getPreviewImage()
    {
        if (isset($this->data['image'])) {
            if (isset($this->data['image']['200'])) {
                return $this->data['image']['200'];
            } else if (isset($this->data['image']['image_url'])) {
                return $this->data['image']['image_url'];
            }
        }
        return null;
    }

    public function getAttachments()
    {
        return (isset($this->data['attachments']) ? $this->data['attachments'] : null);
    }
}