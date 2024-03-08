<?php

namespace block_googlesucheadvanced\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class googleform extends \moodleform {
    public function definition() {
        $googleform = $this->_form;

        $googleform->addElement('text', 'name', get_string('name', 'block_googlesucheadvanced'));
        $googleform->setType('name', PARAM_TEXT);
        $googleform->addRule('name', get_string('required'), 'required');
        $googleform->setDefault('name', '');

        $this->add_action_buttons(false, get_string('search', 'block_googlesucheadvanced'));
    }
}
