<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2018 BuzzingPixel, LLC
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
     * @param mixed $data
     * @return string
     */
    public function display_field($data)
    {
        return 'TODO: Display Field';
    }
}
