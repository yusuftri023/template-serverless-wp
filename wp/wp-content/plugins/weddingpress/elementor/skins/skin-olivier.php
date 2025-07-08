<?php
namespace WeddingPress\elementor\Skins;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Olivier extends Elementor_Skin_Base {
	public function get_id() {
		return 'bdt-olivier';
	}

	public function get_title() {
		return __( 'Horizontal', 'weddingpress' );
	}

	public function render_script() {
		$settings = $this->parent->get_settings_for_display();

		$this->parent->add_render_attribute( 'timeline', 'class', [ 'weddingpress-timeline', 'weddingpress-timeline-skin-olivier' ] );
		$this->parent->add_render_attribute( 'timeline', 'data-visible_items', $settings['visible_items'] );
	}

	public function render_custom() {
		$id             = $this->parent->get_id();
		$settings       = $this->parent->get_settings_for_display();
		$timeline_items = $settings['twae_list'];
		
		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'timeline' ); ?>>
			<div class="weddingpress-timeline-wrapper">
				<div class="weddingpress-timeline-items">					
					
					<?php foreach ( $timeline_items as $item ) : ?>							
						
						<div class="weddingpress-timeline-item">
							<div class="weddingpress-timeline-content">
								<?php $this->parent->render_item( '', '', $item ); ?>
							</div>
						</div>

					<?php endforeach; ?>

				</div>
			</div>
		</div>
 		<?php
	}

	public function render() {

		$settings = $this->parent->get_settings_for_display();

		$this->render_script();

		$this->render_custom();

	}
}