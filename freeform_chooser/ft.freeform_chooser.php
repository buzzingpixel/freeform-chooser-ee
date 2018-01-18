<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2018 BuzzingPixel, LLC
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

use EllisLab\ExpressionEngine\Service\View\View;
use EllisLab\ExpressionEngine\Service\View\ViewFactory;
use Solspace\Addons\FreeformNext\Repositories\FormRepository;

/**
 * Class Freeform_chooser_ft
 */
class Freeform_chooser_ft extends EE_Fieldtype
{
    /** @var array $info */
    public $info = array(
        'name' => FIELD_LIMITS_NAME,
        'version' => FIELD_LIMITS_VER
    );

    /**
     * Specifies compatibility
     * @param string $name
     * @return bool
     */
    public function accepts_content_type($name)
    {
        $compatibility = array(
            'blocks/1',
            'channel',
            'fluid_field',
            'grid',
            'low_variables',
        );

        return in_array($name, $compatibility, false);
    }

    /**
     * Display field
     * @param string $data
     * @return string
     */
    public function display_field($data)
    {
        /** @var ViewFactory $viewFactory */
        $viewFactory = ee('View');

        /** @var View $view */
        $view = $viewFactory->make('ee:_shared/form/fields/dropdown');

        $choices = [
            '' => '--',
        ];

        $freeform = ee('Addon')->get('freeform_next');

        if ($freeform && $freeform->isInstalled()) {
            $formRepository = FormRepository::getInstance();
            $forms = $formRepository->getAllForms();
            foreach ($forms as $form) {
                $choices[$form->handle] = $form->name;
            }
        }

        $value = is_string($data) ? $data : '';

        return $view->render([
            'field_name' => $this->field_name,
            'empty_text' => '--',
            'choices' => $choices,
            'value' => $value,
        ]);
    }
}
