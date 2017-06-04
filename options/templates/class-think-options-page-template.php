<?php
if ( ! class_exists( 'Think_Options_Page_Template' ) ) {
	/**
	 * Render template of custom theme options page
	 *
	 * Class Think_Theme_Page_Template
	 *
	 * @package wp-think-framework
	 */
	class Think_Options_Page_Template implements Think_Template {
		/**
		 * Render theme_page
		 *
		 * @param array $data ['slug' => $slug]
		 *
		 * @throws Think_Exception_Bad_Args_For_Called_Func
		 *
		 * @return string|void
		 */
		public static function render( array $data ) {
			ob_start();

			if ( empty( $data['slug'] ) ) {
				throw new Think_Exception_Bad_Args_For_Called_Func( 'Required argument "slug" don\'t exist or empty' );
			}

			$slug        = $data['slug'];
			$options_key = $data['options_key'];
			?>
            <div class="wrap custom_theme_options">
                <h2><?= __( 'Edit Options', 'wp-think-framework' ) ?></h2>

				<?php global $wp_settings_sections, $wp_settings_fields;

				if ( ! isset( $wp_settings_sections[ $slug ] ) ) {
					return;
				} ?>

                <h2 class="nav-tab-wrapper">
					<?php
					$count = 0;

					foreach ( (array) $wp_settings_sections[ $slug ] as $id => $section ) {
						?><a class="nav-tab <?= ( $count === 0 ) ? 'nav-tab-active' : '' ?>" href="javascript:;"
                             data-tab="<?= $id ?>"><?= $section['title'] ?></a>
						<?php $count ++;
					}
					?>
                </h2>

                <div id="tabs">
                    <form method="POST" action="<?= 'options.php'; ?>">
						<?php
						foreach ( (array) $wp_settings_sections[ $slug ] as $id => $section ) {

							if ( $section['callback'] ) {
								call_user_func( $section['callback'], $section );
							}

							if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $slug ] ) || ! isset( $wp_settings_fields[ $slug ][ $section['id'] ] ) ) {
								continue;
							}

							settings_fields( $options_key . '_' . $section['id'] ); ?>

                            <section class="tab_content" id="<?= $id ?>">
                                <table class="form-table">
									<?php do_settings_fields( $slug, $section['id'] ); ?>
                                </table>
                            </section>

						<?php }
						submit_button();
						?>
                    </form>
                </div>
            </div>
			<?php

			$content = ob_get_contents();

			return $content;
		}
	}
}