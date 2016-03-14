<?php
 * section FOOTER CONTENT
 */

$wp_customize->add_section( 'tesseract_footer_content' , array(
	'title'    => __( 'Footer Content', 'tesseract' ),
	'priority' => 3,
  'panel'    => 'tesseract_footer_options'
) );

$wp_customize->add_setting( 'tesseract_footer_content_header', array(
	'default'           => '',
	'type'              => 'option',
	'transport'         => 'refresh',
	'sanitize_callback' => '__return_false'
) );

$wp_customize->add_control(
		$wp_customize,
		'tesseract_footer_content_header_control',
		array(
			'label'       =>  __( 'Left Footer Area:', 'tesseract' ),
			'description' =>  __( 'Choose the content to be displayed on the left area of the footer.', 'tesseract' ),
			'section'     => 'tesseract_footer_content',
			'settings'    => 'tesseract_footer_content_header',
			'priority'    => 1
		)
	)
);

$wp_customize->add_setting( 'tesseract_footer_additional_content', array(
	'sanitize_callback' => 'tesseract_sanitize_radio_nextToMenu_left',
	'default' => 'nothing'
) );

$wp_customize->add_control(
		$wp_customize,
		'tesseract_footer_additional_content_control',
		array(
			'section'   => 'tesseract_footer_content',
			'settings'  => 'tesseract_footer_additional_content',
			'type'      => 'radio',
			'choices'   => array(
				'nothing' => __( 'Nothing', 'tesseract' ),
				'logo'    => __( 'Logo', 'tesseract' ),
				'social'  => __( 'Social Icons', 'tesseract' ),
				'search'  => __( 'Search Bar', 'tesseract' ),
			),
			'priority'  => 2,
			''
		)
	)
);

$tesseract_menu_selector_menus = get_terms( 'nav_menu' );
	if ( $tesseract_menu_selector_menus ) :
		$tesseract_menu_selector_items = array();

		$item_keys = array( 'none' ); $item_values = array( 'None' );
		foreach ( $tesseract_menu_selector_menus as $items ) {

			array_push( $item_values, $items->name);

		$tesseract_menu_selector_items = array_combine( $item_keys, $item_values );
		$wp_customize->add_setting( 'tesseract_footer_menu_select', array(
		) );

		$wp_customize->add_control(

				$wp_customize,
				array(
					'label'    => __( 'Footer Left Menu', 'tesseract' ),
					'section'  => 'tesseract_footer_content',
					'settings' => 'tesseract_footer_menu_select',
					'type'     => 'select',
					'choices'  => $tesseract_menu_selector_items,
					'priority' => 3
				)
			)
		);

		endif;
		if( !class_exists('Tesseract_Remove_Branding_Customizer') ):
			$wp_customize->add_setting( 'tesseract_footer_content_right', array(
				'default'           => 'themeby',
				'type'              => 'option',
				'transport'         => 'refresh',
				'sanitize_callback' => '__return_false'
			)
		);

		$wp_customize->add_setting( 'tesseract_footer_additional_content_right', array(
			//'sanitize_callback' => 'tesseract_sanitize_radio_nextToMenu_right',
			'default' => 'themeby'
		) );

		$wp_customize->add_control(
				$wp_customize,
				'tesseract_footer_content_control_right',
				array(
					'label'       =>  __( 'Right Footer Area:', 'tesseract' ),
					'description' =>  __( 'Choose the content to be displayed on the right area of the footer.', 'tesseract' ),
					'section'     => 'tesseract_footer_content',
					'settings'    => 'tesseract_footer_content_right',
					'priority'    => 4
				)
			)
		);

		$wp_customize->add_control(
				$wp_customize,
				'tesseract_footer_additional_content_right',
				array(
					'section'   => 'tesseract_footer_content',
					'settings'  => 'tesseract_footer_content_right',
					'type'      => 'radio',
					'choices'   => array(
						'themeby' => __( 'Theme by Tesseract', 'tesseract' ),
						'nothing' => __( 'Nothing', 'tesseract' ),
						'html'    => __( 'Text or HTML', 'tesseract' ),
						'logo'    => __( 'Logo', 'tesseract' ),
						'social'  => __( 'Social Icons', 'tesseract' ),
						'search'  => __( 'Search Bar', 'tesseract' ),
						'menu'    => __( 'Menu', 'tesseract' ),
					),
					'priority'  => 4,
					''
				)
			)
		);

		$wp_customize->add_setting( 'tesseract_footer_additional_content_right2' );
		$wp_customize->add_control(
			$wp_customize,
			'tesseract_footer_additional_content_right2',
			array(
				'label'       =>  __( 'Right Footer Area:', 'tesseract' ),
				'description' =>  sprintf( __( '<a href="%s" target="_blank"><img src="https://s3.amazonaws.com/tesseracttheme/unlock.png" /></a>', 'tesseract' ), 'http://tesseracttheme.com/unbranding-plugin-3/' ),
				'section'     => 'tesseract_footer_content',
				'settings'    => 'tesseract_footer_content_right',
				'priority'    => 5
				)
			)
		);

		endif;