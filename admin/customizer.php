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

  //Site Options
  $wp_customize->add_section(
    'krakatoa_site_options',
    array(
      'title'     => 'Site Options',
      'priority'  => 20
    )
  );

    //Sitemap Link
    $wp_customize->add_setting(
      'krakatoa_sitemap_link_on',
      array(
        'default'    =>  'no',
        'transport'  =>  'refresh'
      )
    );

    $wp_customize->add_control( 'krakatoa_sitemap_link_on', array(
        'type' => 'radio',
        'section' => 'krakatoa_site_options',
        'settings' => 'krakatoa_sitemap_link_on',
        'label' => 'Show Sitemap Link?',
        'description' => 'Displays a custom link to the sitemap in the footer',
        'choices' => array(
          'yes' => 'Yes',
          'no' => 'No',
        ),
      )
    );

    function krakatoa_is_sitemap_link_on() {
      if(get_theme_mod('krakatoa_sitemap_link_on') == 'yes') {
        return true;
      } else {
        return false;
      }
    }

    $wp_customize->add_setting(
      'krakatoa_sitemap_link',
      array(
        'default'    =>  '',
        'transport'  =>  'refresh'
      )
    );

    $wp_customize->add_control( 'krakatoa_sitemap_link', array(
        'type' => 'text',
        'section' => 'krakatoa_site_options',
        'settings' => 'krakatoa_sitemap_link',
        'label' => 'Sitemap Link URL',
        'active_callback' => 'krakatoa_is_sitemap_link_on'
        )
      );

      //Site Credits
      $wp_customize->add_setting(
        'krakatoa_site_credits_on',
        array(
          'default'    =>  'no',
          'transport'  =>  'refresh'
        )
      );

      $wp_customize->add_control( 'krakatoa_site_credits_on', array(
          'type' => 'radio',
          'section' => 'krakatoa_site_options',
          'settings' => 'krakatoa_site_credits_on',
          'label' => 'Show Site Credits?',
          'description' => 'Displays a logo in the footer for whoever built the site.',
          'choices' => array(
            'yes' => 'Yes',
            'no' => 'No',
          ),
        )
      );

      function krakatoa_is_site_credits_on() {
        if(get_theme_mod('krakatoa_site_credits_on') == 'yes') {
          return true;
        } else {
          return false;
        }
      }

      $wp_customize->add_setting(
        'krakatoa_site_credits_logo',
        array(
          'default'    =>  '',
          'transport'  =>  'refresh'
        )
      );

      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'krakatoa_site_credits_logo', array(
    				'settings'		=> 'krakatoa_site_credits_logo',
    				'section'		=> 'krakatoa_site_options',
    				'label'			=> 'Site Credit Logo',
    				'description'	=> 'Logo of the company or person who built the site',
            'active_callback' => 'krakatoa_is_site_credits_on'
    			)
    		)
    	);

      $wp_customize->add_setting(
        'krakatoa_site_credits_link',
        array(
          'default'    =>  '',
          'transport'  =>  'refresh'
        )
      );

      $wp_customize->add_control( 'krakatoa_site_credits_link', array(
          'type' => 'text',
          'section' => 'krakatoa_site_options',
          'settings' => 'krakatoa_site_credits_link',
          'label' => 'Site Credit Link',
          'active_callback' => 'krakatoa_is_site_credits_on'
          )
        );

}

add_action( 'customize_register', 'krakatoa_theme_customizer' );
?>
