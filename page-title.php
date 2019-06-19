<?php

$page_title = engage_get_title();

$post_id = engage_get_id();

$css_classes = array();

// Custom Page Title Styling

$custom_title = false;

if ( get_post_meta( get_the_ID(), 'custom_pagetitle', true ) == 'custom_title' ) {
	$custom_title = true;
}

// Text Alignment

$text_align = 'left';

if ( !class_exists( 'Engage_Core' ) ) {
} elseif ( get_post_meta( $post_id, 'custom_pagetitle_align', true ) == '' && is_single() && get_post_type() == 'post' ) {
	$text_align = engage_option('pagetitle_blog_align');
} elseif ( get_post_meta( $post_id, 'custom_pagetitle_align', true ) == ''  ) {
	$text_align = engage_option('pagetitle_align');
} elseif ( get_post_meta( $post_id, 'custom_pagetitle_align', true ) != '' && get_post_meta( $post_id, 'pagetitle_align', true ) != 'default' ) {
	$text_align = get_post_meta( $post_id, 'custom_pagetitle_align', true );
}

$css_classes[] = 'title-align-' . $text_align;

// Begin Custom Page Title Styling

$pagetitle_css = '<style type="text/css">';

$page_title_container = '#page-title{';

// Page Title Line Separator

if ( engage_pagetitle_meta( 'pagetitle_separator' ) == true ) {

	$css_classes[] = 'page-title-with-separator';

}

$page_title_container .= '}';

if ( $page_title_container != '#page-title{}' ) {
	$pagetitle_css .= $page_title_container;
}

// Heading / Breadcrumbs color

if ( ( $value = engage_pagetitle_meta('pagetitle_color') ) != '' ) {
	$pagetitle_css .= '#breadcrumbs a, #breadcrumbs li,#breadcrumbs li::after { color:' . esc_attr( $value ) . '; }';
}

// Top Padding

if ( engage_pagetitle_enabled() == false ) return null;

$padding_css = array();

// Page Content Top and Bottom Padding

$padding_meta = get_post_meta( get_the_ID(), 'page_content_padding', true );
$padding = '';

if ( $padding_meta && ( array_key_exists( 'padding-top', $padding_meta ) && $padding_meta[ 'padding-top' ] != '' || array_key_exists( 'padding-bottom', $padding_meta ) && $padding_meta[ 'padding-bottom' ] != '' ) ) {
	$padding = $padding_meta;
} elseif( engage_option( 'p_content_padding' ) ) {
	$padding = engage_option( 'p_content_padding' );
}

if ( $padding != '' ) {
	$page_content_padding = $padding;

	// Padding Top

	if ( $page_content_padding['padding-top'] != '' ) {
		$padding_css['top'] = 'padding-top:' . str_replace( 'px', '', $page_content_padding['padding-top'] ) . 'px;';
	}

	// Padding Bottom

	if ( $page_content_padding['padding-bottom'] != '' ) {
		$padding_css['bottom'] = 'padding-bottom:' . str_replace( 'px', '', $page_content_padding['padding-bottom'] ) . 'px;';
	}

}

// Print inline CSS if necessary

if ( !empty( $padding_css ) ) {
	if ( engage_vc_active() && engage_page_layout() == 'no_sidebar' ) {
		if ( array_key_exists( 'top', $padding_css ) ) {
			$selector = '#wrapper .section-page .page-content > .vc_row:first-child';
			$pagetitle_css .= $selector . '{' . esc_attr( $padding_css['top'] ) . '}';
		}
		if ( array_key_exists( 'bottom', $padding_css ) ) {
			$selector = '#wrapper .section-page:not(.page-width-stretch):not(.page-layout-two-sidebars):not(.page-layout-one-sidebar)';
			$pagetitle_css .= $selector . '{' . esc_attr( $padding_css['bottom'] ) . '}';
		}
	} else {
		$selector = '#wrapper .section-page:not(.page-width-stretch):not(.page-layout-two-sidebars):not(.page-layout-one-sidebar)';
		$pagetitle_css .= $selector . '{' . esc_attr( implode( '', $padding_css ) ) . '}';
	}
}

// Print Dynamic Stylesheet

$pagetitle_css .= '</style>';

if ( $pagetitle_css != '<style type="text/css"></style>' ) {
	echo '' . $pagetitle_css;
}

// Page Subtitle

$page_subtitle = '';

if ( get_post_meta( get_the_ID(), 'page_subtitle', true ) != '' ) {
	$page_subtitle = get_post_meta( get_the_ID(), 'page_subtitle', true );
}

// End Custom Page Title Styling

// Inline CSS

$pagetitle_inline_css = '';
$pagetitle_wrapper_css = '';
$inline_css = array();
$title_bg_css = array();

// Background Color

$has_bg = false;

if ( ( $color1 = get_post_meta( $post_id, 'custom_pagetitle_bg_color', true ) ) != '' ) {
	$inline_css[] = 'background-color:' . esc_attr( $color1 ) . ';';
	$has_bg = true;

	if ( ( $color2 = get_post_meta( $post_id, 'custom_pagetitle_bg_color2', true ) ) != '' ) { // Gradient
		//$inline_css[] = 'background: linear-gradient( -30deg,' . esc_attr( $color2 ) . ',' . esc_attr( $color1 ) . ');';
		$angle = -32;
		$inline_css[] = engage_css_gradient( $color1, $color2, $angle );
	}
} elseif ( ( $color1 = engage_option( 'pagetitle_bg_color' ) ) != '' ) {
	$inline_css[] = 'background-color:' . esc_attr( $color1 ) . ';';
	$css_classes[] = 'page-title-def-bg';

	if ( ( $color2 = engage_option( 'pagetitle_bg_color2' ) ) != '' ) { // Gradient
		$angle = -32;
		$inline_css[] = engage_css_gradient( $color1, $color2, $angle );
	}
}

// Background Image

$bg_image = $bg_img_url = '';

if ( engage_pagetitle_meta( 'pagetitle_bg_image' ) != '' || engage_option( 'blog-single-pagetitle' ) == 'featured_img' && is_single() && get_post_type() == 'post' && has_post_thumbnail() ) {

	$has_img = false;
	$individual = false;

	if ( ( $bg_image = get_post_meta( $post_id, 'custom_pagetitle_bg_image', true ) ) && $bg_image['url'] != '' ) {
		$bg_image = get_post_meta( $post_id, 'custom_pagetitle_bg_image', true );
		$has_bg = true;
		$has_img = true;
		$individual = true;
	} elseif ( engage_option( 'blog-single-pagetitle' ) == 'featured_img' && is_single( $post_id ) && get_post_type( $post_id ) == 'post' && has_post_thumbnail( $post_id ) ) {
		$bg_image = array(
		        'url' => get_the_post_thumbnail_url( $post_id, 'full' )
        );
		$has_img = true;
		$has_bg = true;
	} elseif ( ( $bg_image = engage_option( 'pagetitle_bg_image' ) ) && $bg_image['url'] != '' && get_post_meta( $post_id, 'custom_pagetitle_bg_color', true ) == '' ) {
        $bg_image = engage_option( 'pagetitle_bg_image' );
        $has_img = true;
    }

	if ( $has_img && $bg_image['url'] != '' ) {

		$title_bg_css[] = 'background-image: url(' . esc_url( $bg_image['url'] ) . ');';
		$bg_img_url = $bg_image['url'];

		// Background Image Overlay

		$title_bg_overlay = '';

		if ( engage_pagetitle_meta('pagetitle_bg_image_overlay') != 'none' ) {
			$title_bg_overlay .= ' bg-overlay';
			$title_bg_overlay .= ' bg-overlay-' . engage_pagetitle_meta( 'pagetitle_bg_image_overlay' );
		}

        $bg_options = get_post_meta( $post_id, 'custom_pagetitle_bg_options', true );

        if (  $bg_options != '' && is_array( $bg_options ) ) {

            $atts = array( 'background-repeat', 'background-position', 'background-attachment', 'background-size' );

            foreach( $atts as $att ) {
                if ( isset( $bg_options[ $att ] ) && $bg_options[ $att ] != '' ) {
                    $title_bg_css[] = $att . ': ' . $bg_options[$att] . ';';
                }
            }

        }

	}

}

if ( $has_bg == true ) {
	$css_classes[] = 'page-title-with-bg';
}

// Page Title Height

$side_header = false;

if ( engage_header_position() == 'left' || engage_header_position() == 'right' ) $side_header = true;


if ( get_post_meta( $post_id, 'custom_pagetitle_fullscreen', true ) == true ) {

    $css_classes[] = 'page-title-fullscreen';

} else if ( get_post_meta( $post_id, 'custom_pagetitle_height', true ) != '' ) {
	$height = get_post_meta( $post_id, 'custom_pagetitle_height', true );

    if ( $side_header == false ) {
        $height = $height + 90;
        if ( engage_option( 'topbar' ) ) {
            $height = $height + 45;
        }
    }

	$inline_css[] = 'height: ' . esc_attr( $height ) . 'px;';
	$pagetitle_wrapper_css = 'style="height: ' . esc_attr( $height ) . 'px;"';
} elseif( engage_option( 'pagetitle_height' ) != '' ) {
	$height = engage_option( 'pagetitle_height' );
	if ( $side_header == false ) {
        $height = $height + 90;
        if ( engage_option( 'topbar' ) ) {
            $height = $height + 45;
        }
    }
	$inline_css[] = 'height: ' . esc_attr( $height ) . 'px;';
	$pagetitle_wrapper_css = 'style="height: ' . esc_attr( $height ) . 'px;"';
}

// Container Inline CSS

if ( $inline_css ) {
	$pagetitle_inline_css = 'style="' . implode( '', $inline_css ) . '"';
}

// Parallax Effect

$parallax_atts = $parallax_container_atts = $scroll_classes = '';
$parallax_container = $parallax_content = '';
$parallax = false;

if ( get_post_meta( $post_id, 'pagetitle_parallax', true ) == 'yes' ) {

	$parallax = true;

	engage_page_title_parallax();

	$css_classes[] = 'page-title-parallax';

	$parallax_content = 'data-0="opacity:1;transform:translateY(0px);" data-400="opacity:0;transform:translateY(-110px);"';
	$parallax_container = 'data-0="transform: translateY(0px);" data-end="transform: translateY(-250px);"';

}

?>

<section id="page-title" class="page-title <?php echo implode(' ', $css_classes ); ?>"<?php echo '' . $pagetitle_inline_css . $parallax_atts; ?>>
	<div class="page-title-wrapper"<?php if ( $parallax == true ) echo '' . $parallax_container; ?><?php if ( $pagetitle_wrapper_css != '' ) echo '' . $pagetitle_wrapper_css; ?>>
		<?php if ( $title_bg_css ) { ?>
		<div class="page-title-bg<?php echo esc_attr( $title_bg_overlay ); ?>"<?php echo 'style="' . implode( '', $title_bg_css ) . '"'; ?>><img src="<?php echo esc_url( $bg_img_url ); ?>"></div>
		<?php } ?>
		<div class="page-title-inner">
			<div class="container<?php echo esc_attr( $scroll_classes ); ?>"<?php if ( $parallax == true ) echo '' . $parallax_content; ?>>

				<div class="page-title-txt">

                    <?php
                    $page_title_inline = $page_subtitle_inline = '';
                    $title_size = get_post_meta( engage_get_ID(), 'custom_pagetitle_heading_size', true );

                    $pt_inline_css = '';

                    if ( is_array( $title_size ) && array_key_exists( 'font-size', $title_size ) && $title_size [ 'font-size' ] != '' ) {
                        $pt_inline_css .= 'font-size:' . esc_attr( $title_size [ 'font-size' ] ) . ';';
                    }

                    $title_color = get_post_meta( engage_get_ID(), 'custom_pagetitle_color', true );

                    if ( $title_color != '' ) {
                        $pt_inline_css .= 'color: ' . esc_attr( $title_color ) . ';';
                    }

                    if ( $pt_inline_css != '' ) {
                        $page_title_inline = ' style="' . $pt_inline_css . '"';
                    }

                    ?>
					<h1<?php if ( $page_title_inline != '' ) echo '' . $page_title_inline; ?>><?php echo esc_html( $page_title ); ?></h1>

					<?php

					if ( $page_subtitle != '' ) {

                        $subtitle_size = get_post_meta( engage_get_ID(), 'custom_pagetitle_subtitle_size', true );

                        $ps_inline_css = '';

                        if ( is_array( $subtitle_size ) && array_key_exists( 'font-size', $subtitle_size ) && $subtitle_size [ 'font-size' ] != '' ) {

                            $ps_inline_css .= 'font-size:' . esc_attr( $subtitle_size [ 'font-size' ] ) . ';';
                        }

                        $subtitle_color = get_post_meta( engage_get_ID(), 'custom_pagetitle_subtitle_color', true );

                        if ( $subtitle_color != '' ) {
                            $ps_inline_css .= 'color: ' . esc_attr( $subtitle_color ) . ';';
                        }

                        if ( $ps_inline_css != '' )  {
                            $page_subtitle_inline = ' style=" ' . $ps_inline_css . '"';
                        }

					    ?>
						<p class="page-subtitle"<?php if ( $page_subtitle_inline != '' ) echo '' . $page_subtitle_inline; ?>><?php echo esc_html( $page_subtitle ); ?></p>
					<?php
					}

					// Single blog post

					if ( is_single() && get_post_type( get_the_ID() ) == 'post' ) {

						if ( engage_option('blog_single_meta') != false && get_post_meta( get_the_ID(), 'page_title_blog_meta', true ) != 'no' || !class_exists( 'Engage_Core' ) ) {
							engage_blog_post_title_meta();
						}
					}

					?>

	            </div>

	            <?php

	            if ( engage_option( 'breadcrumbs' ) == 'yes' && get_post_meta( engage_get_id(), 'custom_pagetitle_breadcrumbs', true ) != 'no' || !class_exists( 'Engage_Core' ) ) {
                    if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb( '<span id="breadcrumbs" class="breadcrumbs">','</span>' );
                    }                    
	            }

	            ?>

			</div>
		</div>
	</div>

</section>
