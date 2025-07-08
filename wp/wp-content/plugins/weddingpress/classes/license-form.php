<?php
$license_key = '';
$field_name  = $this->license_field_name;
$license_data = get_option( wdp_connect_key() . '_connect_site_data' );
$license_key          = $this->get_hidden_license();
$license_activated    = $this->is_active();
$this->check_license();
?>
<div class="wdp-license-page-wrapper">
	<?php if ( $license_activated || $this->is_expired() ) : ?>
	<div class="wdp-license-card wdp-license-active-card">
		<div class="wdp-d-flex wdp-align-center wdp-justify-between wdp-flex-column wdp-flex-sm-row wdp-gap-2 wdp-mb-40">
			<img src="<?php echo esc_url( WEDDINGPRESS_ELEMENTOR_URL . '/assets/images/wdp-icon.png' ); ?>" alt="Key icon">
			<?php if ( $this->is_active() ) : ?>
			<div class="wdp-license-status wdp-license-active">
				<?php require_once dirname( __DIR__ ) . '/assets/images/icons/checked-filled.svg'; ?>
				<?php esc_html_e( 'License is activated', 'weddingpress' ); ?>
			</div>
			<?php endif;?>
			<?php if($this->is_expired()) :?>
			<div class="wdp-license-status wdp-license-expired">
				<?php require_once dirname( __DIR__ ) . '/assets/images/icons/clock-fill.svg'; ?>
				<?php esc_html_e( 'License is Expired', 'weddingpress' ); ?>
			</div>
			<?php endif; ?>
		</div>

		<div class="wdp-license-info">
			<div class="wdp-license-info-item">
				<div class="wdp-license-info-item-label">
					<?php require_once dirname( __DIR__ ) . '/assets/images/icons/handshake-outline.svg'; ?>
					<?php esc_html_e( 'Licensed to', 'weddingpress' ); ?>
				</div>
				<div class="wdp-license-info-item-value">
					<?php echo esc_html( $license_data->customer_email ); ?>
				</div>
			</div>
			<div class="wdp-license-info-item">
				<div class="wdp-license-info-item-label">
					<?php require_once dirname( __DIR__ ) . '/assets/images/icons/google-doc.svg'; ?>
					<?php esc_html_e( 'License Count', 'weddingpress' ); ?>
				</div>
				<div class="wdp-license-info-item-value">	
					<?php $site_count = $license_data->site_count; $license_limit = $license_data->license_limit;
					if ( 0 == $license_limit ) {
						$license_limit = '∞ Unlimited Websites';
					}
					elseif ( $license_limit >= 1 ) {
						$license_limit = '' . $site_count.' / '.$license_limit.' Website';
					}
					?>
					<?php echo $license_limit; ?>
				</div>
			</div>
			<div class="wdp-license-info-item">
				<div class="wdp-license-info-item-label">
					<?php require_once dirname( __DIR__ ) . '/assets/images/icons/clock-light.svg'; ?>
					<?php esc_html_e( 'Expiration Date', 'weddingpress' ); ?>
				</div>
				<div class="wdp-license-info-item-value">
					<?php if ( isset( $license_data->expires ) && $license_data->expires ) : ?>
						<?php if ( $license_data->expires == 'lifetime' ) : ?>  
							OTP (One Time Payment)* <a href="https://weddingpress.net/syarat-ketentuan/" target="_blank" style="color:#cc9222">S&K Klik Disini!</a>
						<?php else : ?>
							<?php echo date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) ); ?>
						<?php endif; ?>
					<?php endif; ?>    
				</div>
			</div>
		</div>

		<div class="wdp-license-key-wrapper">
			<div class="wdp-license-key-content">
				<h6 class="wdp-fs-6 wdp-color-black wdp-m-0"><?php esc_html_e( 'License Key', 'weddingpress' ); ?></h6>
				<div class="wdp-fs-6 wdp-color-subdued"><?php echo esc_html( $license_key ); ?></div>
			</div>
			<?php if ( isset( $license_data->expires ) && $license_data->expires ) : ?>
				<?php if ( $license_data->expires == 'lifetime' ) : ?>  
				<?php else : ?>
				<div class="wdp-license-key-buttons">
					<a href="<?php echo $this->renew_url();?>" target="_blank">
					<button id="wdp-license-edit-button" class="wdp-btn wdp-btn-secondary">
						Renewal
					</button>
					</a>
				</div>
				<?php endif; ?>
			<?php endif; ?>
			<div class="wdp-license-key-buttons">
				<a href="<?php echo esc_url($this->deactivate_url());?>">
				<button id="wdp-license-edit-button" class="wdp-btn wdp-btn-primary">
					Deactivate
				</button>
				</a>
			</div>
		</div>
	</div>
	
	<?php else : ?>
		<div class="wdp-license-card wdp-license-empty-card">
		<div class="wdp-row">
			<div class="wdp-col-sm-5">
				<div>
					<h6 class="wdp-fs-4 wdp-mb-8 wdp-mt-32" style="color:#cc9222"><?php esc_html_e( 'Verify License', 'weddingpress' ); ?></h6>
					<p class="wdp-fs-6 wdp-color-subdued wdp-m-0"><?php esc_html_e( 'Untuk Aktivasi WeddingPress', 'weddingpress' ); ?></p>
				</div>
			</div>
			<div class="wdp-col-sm-7">
				<form method="post" id="wdp-license-key-form">
					<?php wp_nonce_field( WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce', WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce' ); ?>
					<div class="wdp-form-group">
						<label class="wdp-d-block wdp-fs-7 wdp-color-secondary wdp-mb-4">
							<?php esc_html_e( 'License Key', 'weddingpress' ); ?>
						</label>
						<input type="text" name="<?php echo esc_attr( $field_name ); ?>" class="wdp-form-control">
						<div class="wdp-fs-7 wdp-color-secondary wdp-mt-12">
							<p><?php _e( 'Masukkan kode lisensi, untuk mengaktifkan <strong>WeddingPress</strong>, untuk auto update, premium support dan akses WeddingPress template library.' ); ?></p>
							<ol>
								<li><?php printf( __( 'Masuk <a href="%s" target="_blank" style="color:#cc9222">Member Area</a> untuk mendapatkan kode lisensi.' ), 'https://akses.weddingpress.net/dashboard' ); ?></li>
								<li><?php _e( __( 'Copy kode lisensi di bawah ini' ) ); ?></li>
								<li><?php _e( __( 'Klik tombol <strong>"Verify License"</strong>' ) ); ?></li>
							</ol>
						</div>
					</div>
					<div class="wdp-text-right">
						<button type="submit" class="wdp-btn wdp-btn-primary">
							<?php esc_html_e( 'Verify License', 'weddingpress' ); ?>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
