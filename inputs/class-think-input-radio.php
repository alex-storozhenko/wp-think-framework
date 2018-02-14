<?php

if (!class_exists('Think_Input_Radio')) {
    /**
     * Input type radio.
     *
     * Class Think_Input_Radio
     */
    class Think_Input_Radio extends Think_Abstract_Input
    {
        /** Render */
        public function render()
        {
            ?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab(get_class($this->initiator)); ?> input-area input-area-radio input-area-radio-<?= $this->id.' '.Think_Helper::str_snake_to_kebab(get_class($this)); ?>">
				<?php foreach ($this->options as $title => $value) {
                $db_value = $this->get_value();
                $checked = ($db_value == $value) ? 'checked="checked"' : ''; ?>
                    <label class="wp-think-framework input-label label-radio label-radio<?= $this->id.' '.Think_Helper::str_snake_to_kebab(get_class($this)); ?>">
                        <input class="wp-think-framework input input-radio input-radio-<?= $this->id.' '.Think_Helper::str_snake_to_kebab(get_class($this)); ?>"
                               type="radio" name="<?= $this->initiator->get_key(); ?>[<?= $this->id; ?>]"
                               value="<?= $value ?>" <?= $checked; ?> />
                        <span class="wp-think-framework label-title label-title-radio label-title-radio-<?= $this->id.' '.Think_Helper::str_snake_to_kebab(get_class($this)); ?>"><?= $title ?></span>
                    </label>
				<?php
            } ?>
            </div>
			<?php
        }
    }
}
