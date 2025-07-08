<?php

namespace WeddingPress\elementor;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WeddingPress_Widget_Audio extends Widget_Base {

	public function get_name() {
		return 'weddingpress-audio';
	}

	public function get_title() {
		return __( 'Audio MP3', 'weddingpress' );
	}

	public function get_icon() {
		return 'wdp_icon eicon-headphones';
	}

	public function get_categories() {
		return [ 'weddingpress' ];
	}

	public function get_custom_help_url() {
        return 'https://weddingpress.net/panduan';
	}

	/**
     * Register button widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 0.1.0
     * @access protected
     */

	protected function register_controls() {


		$this->start_controls_section(
			'section_audio',
			[
				'label' => __( 'Audio MP3', 'weddingpress' ),
			]
		);

		$this->add_control(
            'src_type',
            [
                'label' => esc_html__( 'Audio Source', 'weddingpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'upload',
                'options' => [
                    'upload' => esc_html__( 'Upload Audio', 'weddingpress' ),
                    'link' => esc_html__( 'Audio Link', 'weddingpress' ),
					'youtube' => esc_html__( 'Youtube Video', 'weddingpress' ),
                ],
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
            'audio_upload',
            array(
                'label' => esc_html__( 'Upload Audio', 'weddingpress' ),
                'type'  => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'audio',
                'condition' => array(
                    'src_type' => 'upload',
                ),
				'dynamic' => [
					'active' => true,
				],
            )
        );

        $this->add_control(
            'audio_link',
            [
                'label' => esc_html__( 'Audio Link', 'weddingpress' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://example.com/music-name.mp3', 'weddingpress' ),
                'show_external' => false,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'src_type'    =>  'link',
                ],
				'dynamic' => [
					'active' => true,
				],
            ]
        );
		
		$this->add_control(
            'youtube_link',
            [
                'label' => esc_html__( 'Youtube Video', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'https://youtu.be/qY3SKja1yz8', 'weddingpress' ),
                "default" => "https://youtu.be/qY3SKja1yz8",
                "placeholder" => "https://youtu.be/qY3SKja1yz8",
                "label_block" => true,
				'condition' => [
                    'src_type'    =>  'youtube',
                ],
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
			'start',
			[
				'label' => esc_html__( 'Start Time', 'weddingpress' ),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Specify a start time (in seconds)', 'weddingpress' ),
				'frontend_available' => true,
				// 'condition' => [
                //     'src_type'    =>  'youtube',
                // ],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'end',
			[
				'label' => esc_html__( 'End Time', 'weddingpress' ),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Specify an end time (in seconds)', 'weddingpress' ),
				// 'condition' => [
                //     'src_type'    =>  'youtube',
                // ],
				'dynamic' => [
					'active' => true,
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'audio_options',
			[
				'label' => esc_html__( 'Options', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'weddingpress' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'disable',
				'options' => [
					'' => __( 'Yes', 'weddingpress' ),
					'disable' => __( 'No', 'weddingpress' ),
				],
				'condition' => [
                    'src_type'    =>  ['link', 'upload'],
                ],
				
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Loop', 'weddingpress' ),
				'type' => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'condition' => [
                    'src_type'    =>  ['upload','link'],
                ],
			]
		);
				
		$this->add_control(
			'pause_icon',
			[
				'label' => __( 'Icon Play', 'weddingpress' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fa fa-play-circle',
					'library' => 'fa-solid',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'play_icon',
			[
				'label' => __( 'Icon Stop', 'weddingpress' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fa fa-stop-circle',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'weddingpress' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'weddingpress' ),
					'stacked' => __( 'Stacked', 'weddingpress' ),
					'framed' => __( 'Framed', 'weddingpress' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-view-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'weddingpress' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'weddingpress' ),
					'square' => __( 'Square', 'weddingpress' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'default',
				],
				'prefix_class' => 'elementor-shape-',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'weddingpress' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'weddingpress' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'weddingpress' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'weddingpress' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'weddingpress' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_normal',
			[
				'label' => __( 'Normal', 'weddingpress' ),
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __( 'Secondary Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[
				'label' => __( 'Hover', 'weddingpress' ),
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => __( 'Primary Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => __( 'Secondary Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'weddingpress' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'size',
			[
				'label' => __( 'Size', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Padding', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'rotate',
			[
				'label' => __( 'Rotate', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */

	protected function render() {
	
		$settings = $this->get_settings_for_display();	
		
		$this->add_render_attribute( 'wrapper', 'class', 'elementor-icon-wrapper' );

		$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon' );


		if ( ! empty( $settings['hover_animation'] ) ) {
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		$icon_tag = 'div';

		if ( empty( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fa fa-music';
		}

		if ( ! empty( $settings['icon'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		// audio link
		$yt = false;
        if($settings['src_type'] == 'upload'){
            $audio_link = $settings['audio_upload']['url'];
			$yt = false;
        } elseif($settings['src_type'] == 'link'){
            $audio_link = $settings['audio_link']['url'];
			$yt = false;
        } else {
		
			$audio_link = $settings['youtube_link'];
			$yt = true;
		}
		
        if($audio_link):
			?>
			<script>
				var settingAutoplay = '<?php echo $settings['autoplay']; ?>';
				window.settingAutoplay = settingAutoplay === 'disable' ? false : true;
			</script>

			<div id="audio-container" class="audio-box">

			<?php
				if($yt):
			?>
		<!-- YOUTUBE VIDEO IFRAME START-->
		<div data-video="<?=esc_url($audio_link);?>" id="youtube-audio"></div>
		<script src="https://www.youtube.com/iframe_api"></script>
		<script>
		var player;
		var startSeconds = '<?php echo $settings['start'];?>';
		var endSeconds = '<?php echo $settings['end'];?>';
		function onYouTubeIframeAPIReady() {
		var ytplay = document.getElementById("youtube-audio");
		ytplay.innerHTML = '<div id="youtube-player"></div>';
		ytplay.style.cssText = 'visibility:hidden;';
		ytplay.onclick = toggleAudio;
		player = new YT.Player('youtube-player', {
			height: '20',
			width: '20',
			videoId: extractVideoID(ytplay.dataset.video),
			playerVars: {
			autoplay: ytplay.dataset.autoplay,
			loop: ytplay.dataset.loop,
			start: startSeconds,
			end: endSeconds,
			playsinline:1

			},
			events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange 
			} 
		});
		}
		function toggleAudio() {
			if ( player.getPlayerState() == 1 || player.getPlayerState() == 3 ) {
				player.pauseVideo(); 
			} else {
				player.playVideo();
			} 
		} 
		function onPlayerReady(event) {
			event.target.playVideo();
			// player.seekTo(startSeconds);
			player.setPlaybackQuality("small");
		}
		function onPlayerStateChange(event) {
			if (event.data === 0) {
				player.playVideo(); 
				startSeconds: startSeconds;
				endSeconds: endSeconds;
				var duration = startSeconds - endSeconds;
				setTimeout(restartVideoSection, duration * 1000);
			}
		}
		function restartVideoSection() {
			player.seekTo(startSeconds);
		}
		function extractVideoID(url) {
			var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
			var match = url.match(regExp);
			if (match && match[7].length == 11) {
			return match[7];
			} else {
			console.log('Could not extract video ID.');
			}
		}
		</script>
		<!-- YOUTUBE VIDEO IFRAME END-->
		 
		<?php
			else:
				$arr = explode('.', $audio_link);
				$file_ext = end($arr);

		?>	

		<?php if ( $settings['loop'] ) :?>
		<audio id="song" loop>
			<source src="<?php echo esc_url($audio_link); ?>"
			type="audio/<?php echo esc_attr($file_ext); ?>">
		</audio>  
		<?php else: ?>
				<audio id="song">
				<source src="<?php echo esc_url($audio_link); ?>"
				type="audio/<?php echo esc_attr($file_ext); ?>">
			</audio> 
		<?php endif; ?>	

		<?php endif; ?>
			
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> id="unmute-sound" style="display: none;">
				<<?php echo $icon_tag . ' ' . $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
				<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['pause_icon'], [ 'aria-hidden' => 'true' ] );
				else : ?>
					<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
				<?php endif; ?>
				</<?php echo $icon_tag; ?>>
			</div> 

			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> id="mute-sound" style="display: none;">
				<<?php echo $icon_tag . ' ' . $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
				<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['play_icon'], [ 'aria-hidden' => 'true' ] );
				else : ?>
					<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
				<?php endif; ?>
				</<?php echo $icon_tag; ?>>
			</div>
			
		</div>

		<?php if($settings['src_type'] == 'youtube'):?>
		<script>
		jQuery("document").ready(function($) {
			var e = window.settingAutoplay;
			if(e) {
				$("#mute-sound").show();
				if(document.body.contains(document.getElementById("song"))) {
					document.getElementById("song").play();
				}
			} else { 
				$("#unmute-sound").show();
			}
			$("#audio-container").click(function(u) {
				if(e) {
					$("#mute-sound").hide();
					$("#unmute-sound").show();
					playAud();//document.getElementById("song").pause();
					e = !1
				} else {
					$("#unmute-sound").hide();
					$("#mute-sound").show();
					//document.getElementById("song").play();
					playAud();
					e = !0;
				}
			})
			function playAud(){
				if(document.body.contains(document.getElementById("song"))) {
					if(e){
						document.getElementById("song").pause();
					} else {
						document.getElementById("song").play();
					}
				} else {
					toggleAudio();
				}
			}
		});
		</script>
		<?php else :
			if(!empty($settings['start'] && $settings['end'])):?>
			<script>
			jQuery(document).ready(function ($) {
				var startSeconds = parseFloat('<?php echo $settings['start']; ?>');
				var endSeconds = parseFloat('<?php echo $settings['end']; ?>');
				var audio = document.getElementById("song");
				var playButton = $("#unmute-sound");
				var pauseButton = $("#mute-sound");
				var audioContainer = $("#audio-container");
				var settingAutoplay = window.settingAutoplay; // Assuming this variable is set globally
				var settingLoop = <?php echo json_encode($settings['loop']); ?>; // Assuming loop setting comes from PHP as boolean

				// Ensure the audio element and container exist
				if (!audio) {
					console.error("Audio element with ID 'song' not found.");
					$("#unmute-sound, #mute-sound").hide();
					return; // Stop script execution if audio element is missing
				}

				if (!audioContainer.length) {
					console.error("Audio container element with ID 'audio-container' not found.");
					$("#unmute-sound, #mute-sound").hide();
					return; // Stop script execution if container is missing
				}


				// Initial setup based on autoplay setting
				if (settingAutoplay) {
					// Attempt to play if autoplay is enabled
					// Set current time to startSeconds for the initial autoplay attempt
					audio.currentTime = startSeconds;
					audio.play().then(function() {
						// Autoplay successful, button state will be set correctly by the 'play' event listener
					}).catch(function(err) {
						console.warn("Autoplay blocked:", err);
						// Autoplay was blocked by the browser, so the audio is paused.
						// Ensure the play button is shown.
						showPlayButton();
					});
				} else {
					// Autoplay disabled, ensure the play button is shown initially.
					showPlayButton();
				}

				// Create a container click handler for play/pause toggle
				audioContainer.on("click", function(e) {
					// Toggle playback state with a single click anywhere in the container
					if (audio.paused) {
						playAudio();
					} else {
						pauseAudio();
					}
					e.stopPropagation(); // Prevent event bubbling if the container is nested
				});

				// Monitor audio time for looping or pausing at endSeconds
				audio.addEventListener('timeupdate', function() {
					// Check if the current time has reached or exceeded the end time
					if (audio.currentTime >= endSeconds) {
						if (settingLoop) {
							// If looping is enabled, reset current time to the start time.
							// The audio continues playing, so the button state remains 'pause'.
							audio.currentTime = startSeconds;
						} else {
							// If not looping, pause the audio at the end time.
							// The button state will be updated to show 'play' by the 'pause' event listener.
							pauseAudio();
						}
					}
				});

				// Listen for the 'ended' event. This fires when the playback reaches the
				// end of the media resource. It's primarily useful when not looping,
				// or if the natural end of the file is before endSeconds.
				audio.addEventListener('ended', function() {
					if (!settingLoop) {
						// If not looping, playback has truly ended, show the play button.
						showPlayButton();
						// Optionally reset current time to the start when playback ends naturally and not looping.
						audio.currentTime = startSeconds;
					}
					// If looping via timeupdate, the 'ended' event typically won't fire at the loop point.
				});


				// Listen for the 'play' event to ensure the pause button is shown when playback starts.
				audio.addEventListener('play', function() {
					showPauseButton();
				});

				// Listen for the 'pause' event to ensure the play button is shown when playback pauses.
				audio.addEventListener('pause', function() {
					// When paused (either by user interaction or reaching the end time when not looping),
					// show the play button.
					showPlayButton();
				});

				// Function to play audio
				function playAudio() {
					// Before playing, check if we should reset the current time.
					// Reset if audio is paused and the current time is at the very beginning (0),
					// beyond the intended end time, or before the start time.
					// This ensures playback starts from the defined segment or from the beginning
					// if it wasn't previously playing within the segment.
					if (audio.paused) { // Only modify currentTime and attempt play if currently paused
						if (audio.currentTime >= endSeconds || audio.currentTime < startSeconds || audio.currentTime === 0) {
							audio.currentTime = startSeconds; // Reset to start time for new playback
						}
						// If paused within the segment (startSeconds <= audio.currentTime < endSeconds and not 0),
						// the currentTime is not modified, and playback will resume from there.

						// Attempt to play the audio.
						audio.play().catch(function(err) {
							console.warn("Audio playback error:", err);
							// If play fails (e.g., due to browser autoplay policies),
							// ensure the play button is visible as the audio is not playing.
							showPlayButton();
						});
					}
				}

				// Function to pause audio
				function pauseAudio() {
					// Only attempt to pause if the audio is currently playing.
					if (!audio.paused) {
						audio.pause();
					}
					// The button state will be updated to show 'play' by the 'pause' event listener.
				}

				// Functions to update the visible buttons
				function showPlayButton() {
					pauseButton.hide();
					playButton.show();
				}

				function showPauseButton() {
					playButton.hide();
					pauseButton.show();
				}
			});
		</script>
			<?php else : ?>
				<script>
					jQuery("document").ready(function($) {
						var e = window.settingAutoplay;
						if(e) {
							$("#mute-sound").show();
							if(document.body.contains(document.getElementById("song"))) {
								document.getElementById("song").play();
							}
						} else { 
							$("#unmute-sound").show();
						}
						$("#audio-container").click(function(u) {
							if(e) {
								$("#mute-sound").hide();
								$("#unmute-sound").show();
								playAud();//document.getElementById("song").pause();
								e = !1
							} else {
								$("#unmute-sound").hide();
								$("#mute-sound").show();
								//document.getElementById("song").play();
								playAud();
								e = !0;
							}
						})
						function playAud(){
							if(document.body.contains(document.getElementById("song"))) {
								if(e){
									document.getElementById("song").pause();
								} else {
									document.getElementById("song").play();
								}
							} else {
								toggleAudio();
							}
						}
					});
				</script>
			<?php endif;?>
		<?php endif;?>
		
		<script>
		// Ambil elemen audio dengan ID "song"
		const audioElement = document.getElementById("song");

		// Event listener untuk visibility change
		document.addEventListener("visibilitychange", () => {
			if (document.visibilityState === "hidden") {
				// Pause audio jika tab berpindah
				if (audioElement && !audioElement.paused) {
					audioElement.pause();
				}

				// Pause video YouTube jika tab berpindah
				if (typeof player !== "undefined" && player.getPlayerState) {
					if (player.getPlayerState() === YT.PlayerState.PLAYING || player.getPlayerState() === YT.PlayerState.BUFFERING) {
						player.pauseVideo();
					}
				}
			} else if (document.visibilityState === "visible") {
				// Play audio jika tab kembali aktif
				if (audioElement && audioElement.paused) {
					audioElement.play().catch((err) => {
						console.log("Error saat mencoba memutar audio:", err);
					});
				}

				// Play video YouTube jika tab kembali aktif
				if (typeof player !== "undefined" && player.getPlayerState) {
					if (player.getPlayerState() !== YT.PlayerState.PLAYING) {
						player.playVideo();
					}
				}
			}
		});

		// Memastikan audio langsung diputar saat halaman dimuat
		window.addEventListener("load", () => {
			if (audioElement) {
				audioElement.play().catch((err) => {
					console.log("Error saat mencoba memutar audio saat halaman dimuat:", err);
				});
			}
		});

		</script>

		<?php 

		else:
            echo '<div class="weddingpress_not_found">';
            echo "<span>". esc_html__('No Audio File Selected/Uploaded', 'weddingpress') ."</span>";
            echo '</div>';
        endif;
	}

	/**
   * Render the widget output in the editor.
   *
   * Written as a Backbone JavaScript template and used to generate the live preview.
   *
   * @since 1.1.0
   *
   * @access protected
   */

	protected function content_template() {
		?>
		<# 
				iconHTML = elementor.helpers.renderIcon( view, settings.pause_icon, { 'aria-hidden': true }, 'i' , 'object' ),
				migrated = elementor.helpers.isIconMigrated( settings, 'pause_icon' ),
				iconTag = 'div';
		#>
		<div class="elementor-icon-wrapper">
			<{{{ iconTag }}} class="elementor-icon elementor-animation-{{ settings.hover_animation }}" >
				<# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
					{{{ iconHTML.value }}}
				<# } else { #>
					<i class="{{ settings.icon }}" aria-hidden="true"></i>
				<# } #>
			</{{{ iconTag }}}>
		</div>
		<?php
	}
}
