<?php

if (!class_exists('Think_Input_Textarea')) {
    /**
     * Input type textarea.
     *
     * Class Think_Input_Textarea
     */
    class Think_Input_Textarea extends Think_Abstract_Input
    {
        /** Render */
        public function render()
        {
            ?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab(get_class($this->initiator)); ?> input-area input-area-textarea input-area-textarea-<?= $this->id.' '.Think_Helper::str_snake_to_kebab(get_class($this)); ?>">
                <label class="wp-think-framework input-label label-textarea label-textarea-<?= $this->id.' '.Think_Helper::str_snake_to_kebab(get_class($this)); ?>">
                <textarea
                        class="wp-think-framework textarea large-text input-textarea input-textarea-<?= $this->id.' '.Think_Helper::str_snake_to_kebab(get_class($this)); ?>"
                        rows="5"
                        name="<?= $this->initiator->get_key(); ?>[<?= $this->id; ?>]"><?= $this->get_value(); ?></textarea>
                    <span class="wp-think-framework label-title label-title-textarea label-title-textarea-<?= $this->id.' '.Think_Helper::str_snake_to_kebab(get_class($this)); ?>"><?= $this->label; ?></span>
                </label>
            </div>
			<?php
        }
    }
}
