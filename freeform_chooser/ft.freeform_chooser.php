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
     * Freeform_chooser_ft constructor
     */
    public function __construct()
    {
        parent::__construct();

        /** @var \EE_Session $session */
        $session = ee()->session;

        $assetsSet = $session->cache('freeformChooser', 'cpAssetsSet');

        $isCp = defined('REQ') && REQ === 'CP';

        if (! $isCp || $assetsSet) {
            return;
        }

        $jsPath = PATH_THIRD . 'freeform_chooser/resources/script.js';
        $jsContents = file_get_contents($jsPath);

        $jsTag = "<script type=\"text/javascript\">{$jsContents}</script>";

        /** @var \Cp $cp */
        $cp = ee()->cp;

        $cp->add_to_foot($jsTag);

        $session->set_cache('freeformChooser', 'cpAssetsSet', true);
    }

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
     * Displays the field
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

    /**
     * Displays the field in Low Variables
     * @param $data
     * @return string
     */
    public function var_display_field($data)
    {
        return $this->display_field($data);
    }

    /**
     * Saves the data
     * @param $data
     * @return string
     */
    public function save($data)
    {
        $int = (int) $data;

        if (is_numeric($data) && $int === 0) {
            return '';
        }

        return parent::save($data);
    }
}
