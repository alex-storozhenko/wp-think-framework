<?php

if ( ! class_exists( 'Think_Options' ) ) {
	/** Class Think_Options */
	class Think_Options {

		/** @var array $fields */
		protected $fields;

		/** @var string $options_name */
		protected $options_name;

		/** @var string $parent_slug */
		protected $parent_slug;

		/** @var string $title */
		protected $title;

		/** @var  string $slug */
		protected $slug;

		/**
		 * Options constructor
		 *
		 * @param array $fields
		 * @param string $title
		 * @param string $parent_slug
		 * @param string $options_name
		 */
		final protected function __construct( array $fields, $title, $parent_slug, $options_name ) {
			$this->fields       = array_unique( $fields, SORT_REGULAR );
			$this->title        = $title;
			$this->parent_slug  = $parent_slug;
			$this->options_name = $options_name;
			$this->slug         = 'edit' . str_replace( '_', '-', $this->options_name ) . '-theme-options';

			add_action( 'admin_menu', array( $this, 'options_page' ) );
			add_action( 'admin_init', array( $this, 'register_settings' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		}

		/** Add js and css */
		public function enqueue_assets() {
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'options_style', THINK_FRAMEWORK_URI . '/options/assets/css/options.css', [], THINK_FRAMEWORK_VERSION );
			wp_enqueue_script( 'options_script', THINK_FRAMEWORK_URI . '/options/assets/js/theme.options.js', [ 'jquery' ], THINK_FRAMEWORK_VERSION );
			wp_enqueue_script( 'options_media_uploader', THINK_FRAMEWORK_URI . 'options/assets/js/media.uploader.js', [ 'jquery' ], THINK_FRAMEWORK_VERSION );
		}

		/** Create theme menu item function */
		public function options_page() {
			add_submenu_page(
				$this->parent_slug,
				$this->title,
				$this->title,
				'edit_theme_options',
				$this->slug,
				array( $this, 'theme_options_page' )
			);
		}

		/**
		 * Callback add_submenu_page()
		 * Render options HTML
		 */
		public function theme_options_page() { ?>
            <div class="wrap custom_theme_options">
                <h2><?= __( 'Edit Options', 'wp-think-framework' ) ?></h2>

				<?php $this->tabbed_settings_sections( $this->slug ); ?>
            </div>
			<?php
		}

		/**
		 * Render tabs on options page
		 *
		 * @param $page
		 */
		public function tabbed_settings_sections( $page ) {
			global $wp_settings_sections, $wp_settings_fields;

			if ( ! isset( $wp_settings_sections[ $page ] ) ) {
				return;
			} ?>

            <h2 class="nav-tab-wrapper">
				<?php
				$count = 0;

				foreach ( (array) $wp_settings_sections[ $page ] as $id => $section ) {
					?><a class="nav-tab <?= ( $count === 0 ) ? 'nav-tab-active' : '' ?>" href="#"
                         data-tab="<?= $id ?>"><?= $section['title'] ?></a>
					<?php $count ++;
				}
				?>
            </h2>

            <div id="tabs">
				<?php foreach ( (array) $wp_settings_sections[ $page ] as $id => $section ) {

					if ( $section['callback'] ) {
						call_user_func( $section['callback'], $section );
					}

					if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
						continue;
					}
					?>

                    <form method="post" action="options.php">
						<?php settings_fields( $section['id'] ); ?>

                        <section class="tab_content" id="<?= $id ?>">
                            <table class="form-table">
								<?php do_settings_fields( $page, $section['id'] ); ?>
                            </table>

							<?php submit_button(); ?>
                        </section>

                    </form>
				<?php } ?>
            </div>
			<?php
		}

		/**
		 * Callback admin_init()
		 *
		 * Register all settings
		 */
		public function register_settings() {
			foreach ( $this->fields as $section_id => $section ) {
				add_settings_section( $section_id, $section['title'], null, $this->slug );

				foreach ( $section['fields'] as $field ) {
					add_settings_field( $field['id'], $field['title'], array(
						$this,
						'settings_field_callback'
					), $this->slug, $section_id, $field );

					register_setting( $section_id, $field['id'] );
				}
			}
		}

		/**
		 * Call field render function depends on field type
		 *
		 * @param $args
		 *
		 * @throws \Exception
		 */
		public function settings_field_callback( $args ) {
			$method = $args['type'] . '_callback';

			if ( ! method_exists( static::class, $method ) ) {
				throw new Exception( 'Method not exists. You should add them to Options class' );
			}

			$this->$method( $args );
		}

		/**
		 * Render Input
		 *
		 * @param $args
		 */
		protected function input_callback( $args ) { ?>
            <input type='text' name='<?= $args['id'] ?>' id='<?= $args['id'] ?>'
                   value='<?= get_option( $args['id'] ) ?>'/>
			<?php
		}

		/**
		 * Render Textarea
		 *
		 * @param $args
		 */
		protected function textarea_callback( $args ) { ?>
            <textarea class="large-text" rows="5" name="<?= $args['id'] ?>" id="<?= $args['id'] ?>"><?php
				echo get_option( $args['id'] )
				?></textarea>
			<?php
		}

		/**
		 * Render WP Editor
		 *
		 * @param $args
		 */
		protected function wp_editor_callback( $args ) {
			wp_editor( get_option( $args['id'] ), $args['id'] . '_editor', array(
				'textarea_name' => $args['id'],
				'wpautop'       => false,
				'tinymce'       => true,
				'teeny'         => false,
				'quicktags'     => true,
				'media_buttons' => true,
				'textarea_rows' => 20,
			) );
		}

		/**
		 * Render Uploader
		 *
		 * @param $args
		 */
		protected function image_callback( $args ) {
			$src = get_option( $args['id'] ); ?>

            <input type='text' name='<?= $args['id'] ?>' id='<?= $args['id'] ?>' value='<?= $src ?>'/>
            <button class="button st_upload_button"><?= __( 'Select image' ) ?></button>
            <button class="button st_delete_upload_button"><?= __( 'Remove image' ) ?></button>

			<?php if ( ! empty( $src ) ) { ?>
                <img class="image" alt="Uploaded image" src="<?= $src ?>"/>
			<?php }
		}

		/**
		 * Render Radio button
		 *
		 * @param $args
		 */
		protected function radio_callback( $args ) { ?>
            <fieldset>
				<?php foreach ( $args['values'] as $id => $title ) {
					$value   = get_option( $args['id'] );
					$cheched = ( $value[0] == $id ) ? 'checked="checked"' : '';
					?>

                    <label>
                        <input type="radio" name="<?= $args['id'] ?>[]" value="<?= $id ?>" <?= $cheched ?>>
                        <span><?= $title ?></span>
                    </label><br>

				<?php } ?>
            </fieldset>
			<?php
		}

		/**
		 * Render Checkbox
		 *
		 * @param $args
		 */
		protected function checkbox_callback( $args ) { ?>
            <fieldset>
				<?php foreach ( $args['values'] as $id => $title ) {
					$value   = get_option( $args['id'] );
					$cheched = ( ! empty( $value ) && in_array( $id, $value ) ) ? 'checked="checked"' : '';
					?>

                    <label>
                        <input type="checkbox" name="<?= $args['id'] ?>[]" value="<?= $id ?>" <?= $cheched ?>>
                        <span><?= $title ?></span>
                    </label>

				<?php } ?>
            </fieldset>
			<?php
		}

		/**
		 * Render Select
		 *
		 * @param $args
		 */
		protected function select_callback( $args ) { ?>
            <select name="<?= $args['id'] ?>" id="<?= $args['id'] ?>">

				<?php foreach ( $args['values'] as $id => $title ) {
					$value    = get_option( $args['id'] );
					$selected = ( $value == $id ) ? 'selected' : '';
					?>

                    <option value="<?= $id ?>" <?= $selected ?>><?= $title ?></option>
				<?php } ?>
            </select>
			<?php
		}

		/**
		 * Render Separator
		 *
		 * @param $args
		 */
		protected function separator_callback( $args ) {
			echo $args['values'][0];
		}

		/**
		 * Render Colorpicker
		 *
		 * @param $args
		 */
		protected function colorpicker_callback( $args ) {
			$color = get_option( $args['id'] );

			foreach ( $args['values'] as $id => $default ) {
				$set_color = ( ! empty( $color ) && ! empty( $color[ $id ] ) ) ? $color[ $id ] : $default; ?>

                <input type="text" name="<?= $args['id'] ?>[]" class="theme_colorpicker" value="<?= $set_color ?>"
                       data-default-color="<?= $default ?>"/>
				<?php
			}
		}

		/**
		 * @param string $options_name
		 * @param array $fields
		 *
		 * Attention! id must always be unique, otherwise the result will be unexpected
		 * Code example:
		 *
		 * [
		 *      'social'   =>
		 *      [
		 *          'title'  => 'Social',
		 *          'fields' =>
		 *          [
		 *              [
		 *                  'id'    => 'facebook',
		 *                  'title' => 'Facebook',
		 *                  'type'  => 'input',
		 *              ],
		 *              [
		 *                  'id'    => 'twitter',
		 *                  'title' => 'Twitter',
		 *                  'type'  => 'input',
		 *              ],
		 *          ]
		 *      ],
		 *      'contacts' =>
		 *      [
		 *          'title'  => 'Contacts page',
		 *          'fields' =>
		 *          [
		 *              [
		 *                  'id'    => 'contacts_map_location',
		 *                  'title' => 'Contacts Map Location',
		 *                  'type'  => 'image',
		 *              ],
		 *              [
		 *                  'id'    => 'contacts',
		 *                  'title' => 'Contacts',
		 *                  'type'  => 'wp_editor',
		 *              ],
		 *          ]
		 *      ],
		 * ];
		 *
		 *
		 * @param string|null $parent_slug (default options.php)
		 * @param string $title
		 *
		 * @return static
		 */
		public static function create( $fields, $title, $parent_slug = 'options-general.php', $options_name = '_think_options_general' ) {
			return new static( $fields, $title, $parent_slug, $options_name );
		}
	}
}