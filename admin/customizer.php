<?php
function krakatoa_theme_customizer( $wp_customize ) {

  //Scripts
  $wp_customize->add_section(
    'krakatoa_scripts',
    array(
      'title'     => 'Scripts',
      'priority'  => 200
    )
  );

    //Header Scripts
    $wp_customize->add_setting(
      'krakatoa_header_scripts',
      array(
        'default'    =>  '',
        'transport'  =>  'refresh'
      )
    );

    $wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'krakatoa_header_scripts', array(
          'section'   => 'krakatoa_scripts',
          'settings' => 'krakatoa_header_scripts',
          'label'     => 'Custom Header Scripts',
          'description' => 'Add any scripts that you\'d like in the <head> section below.',
          'code_type' => 'php'
        )
      )
    );

    //Footer Scripts
    $wp_customize->add_setting(
      'krakatoa_footer_scripts',
      array(
        'default'    =>  '',
        'transport'  =>  'refresh'
      )
    );

    $wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'krakatoa_footer_scripts', array(
          'section'   => 'krakatoa_scripts',
          'settings' => 'krakatoa_footer_scripts',
          'label'     => 'Custom Footer Scripts',
          'description' => 'Add any scripts that you\'d like in the footer section below.',
          'code_type' => 'php'
        )
      )
    );
}

add_action( 'customize_register', 'krakatoa_theme_customizer' );
?>
