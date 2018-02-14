<?php
if (!class_exists('Think_Input_Row')) {
    /**
     * Class Think_Input_Row.
     */
    class Think_Input_Row extends Think_Abstract_Input
    {
        /**
         * Redeclare initiator type.
         *
         * @var Think_Metaboxes
         */
        protected $initiator;

        /**
         * Inputs collection.
         *
         * @var array
         */
        protected $structure;

        /**
         * Think_Input_Row constructor.
         *
         * @param Think_Metaboxes $initiator
         * @param array           $structure
         */
        public function __construct(Think_Metaboxes $initiator, array $structure)
        {
            $this->structure = $structure;

            parent::__construct($initiator, 'wptf-row'.uniqid('_').'_'.Think_Helper::str_snake_to_kebab(get_class($this->initiator)), '', []);
        }

        /** Render */
        public function render()
        {
            ?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab(get_class($this->initiator)); ?> row"
                 id="<?= $this->id ?>">
				<?php
                foreach ($this->structure as $input_structure) {
                    $input = Think_Input_Factory::make($this->initiator, $input_structure);

                    $input->render();
                } ?>
            </div>
			<?php
        }
    }
}
