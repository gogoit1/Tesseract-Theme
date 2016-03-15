<?php
/**
 * @param boolean $cont
 * @param boolean $contClass
 * @param string $location
 * @param integer $depth
 */
function tesseract_output_menu($cont, $contClass, $location, $depth) {
	switch ($location) {
		case 'primary':
      $hblox = 'header';
      break;

		case 'primary_right':
      $hblox = 'header_right';
      break;

		case 'secondary':
      $hblox = 'footer';
      break;

		case 'secondary_right':
      $hblox = 'footer_right';
      break;
	}

  $locs = get_theme_mod('nav_menu_locations');

	$menu = get_theme_mod('tesseract_'.$hblox.'_menu_select');

  $isMenu = get_terms('nav_menu') ? TRUE : FALSE;
  $locReserved = ($locs[$location]) ? TRUE : FALSE;
	$menuSelected = (is_string($menu)) ? TRUE : FALSE;

  // IF the location set as parameter has an associated menu, it's returned as a key-value pair in the $locs array - where the key is the location and the value is the menu ID. We need this latter to get the menu slug required later -in some cases- in the wp_nav_menu params array.
  if ($locReserved) {
   $menu_id = $locs[$location]; // $value = $array[$key]
   $menuObject = wp_get_nav_menu_object($menu_id);
   $menu_slug = $menuObject->slug;
  }

	$custSet = ($menuSelected && ($menu !== 'none'));

  if (empty($isMenu)) { //Case 1 - IF THERE'S NO MENU CREATED -> easy scenario: no location setting, no customizer setting ( this latter only appears if there IS at least one menu created by the theme user ) => display basic menu
    wp_nav_menu(array(
      'theme_location' => 'primary',
      'menu_class' => 'nav-menu',
      'container_class' => '',
      'container' => FALSE,
      'depth' => $depth
    ));
  } elseif ( ! empty($isMenu)) { //Case 2 - THERE'S AT LEAST ONE MENU CREATED
    if ( ! $custSet && $locReserved) { //no setting in customizer OR dropdown is set to blank value, location SET in Menus section => display menu associated with this location in Appearance ->
      wp_nav_menu(array(
        'menu' => $menuSlug,
        'theme_location' => $location,
        'menu_class' => 'nav-menu',
        'container_class' => $contClass,
        'container' => $cont,
        'depth' => $depth
      ));
    } else if ( ! $custSet && ! $locReserved) { //no setting in customizer OR dropdown is set to blank value, location NOT SET in Menus section => display basic menu
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_class' => 'nav-menu',
        'container_class' => '',
        'container' => FALSE,
        'depth' => $depth
      ));
    } else if ($custSet) { //menu set in customizer AND dropdown is NOT set to blank value, location SET OR NOT SET in Menus section => display menu set in customizer ( setting a menu to the given location in customizer will update any existing location-menu association in Appearance -> Menus, see function tesseract_set_menu_location() in functions.php )
      wp_nav_menu(array(
        'menu' => $menu,
        'theme_location' => $location,
        'menu_class' => 'nav-menu',
        'container_class' => $contClass,
        'container' => $cont,
        'depth' => $depth
      ));
    }
  }
}

function tesseract_set_menu_location_menuupdate() {
  $selectorLocs = array(
    'tesseract_header_menu_select' => 'primary',
    'tesseract_footer_menu_select' => 'secondary',
    'tesseract_header_right_menu_select' => 'primary_right'
  );

  //Location 'secondary_right' is available ONLY if the branding removal plugin is installed
  if (is_plugin_active('tesseract-remove-branding/tesseract-remove-branding.php')) {
    $selectorLocs = array_merge($selectorLocs, array('tesseract_footer_right_menu_select' => 'secondary_right'));
  }

  //Returns the array of locations reserved
  $locs = get_theme_mod('nav_menu_locations');

	foreach ($selectorLocs as $selector => $loc) {
		$selection = get_theme_mod($selector); // = menu slug

		if ($selection !== 'none') {
			//Let's see if there's a menu associated with current location (if any)
			$locReserved = ! empty($locs[$loc]);

			switch ($loc) {
				case 'primary_right' :
          $hiderSect = 'tesseract_header_right_content';
          break;

				case 'secondary_right' :
          $hiderSect = 'tesseract_footer_right_content';
          break;
			}

			if ($locReserved) {
				$menu_id = $locs[$loc]; // $value = $array[$key]
				$menuObject = wp_get_nav_menu_object($menu_id);
				$menu_slug = $menuObject->slug;

				//Update customizer setting
				set_theme_mod($selector, $menu_slug);

			} elseif ( ! $locReserved && is_string($selection)) { // if no location set at Appearance -> Menus AND WE'RE NOT IN INSTALL PHASE ( when there's no $selection value )
				set_theme_mod($selector, 'none');

        //Update visibility
				switch ($loc) {
					case 'primary_right' :
            if (get_theme_mod($hiderSect) == 'menu') {
              set_theme_mod($hiderSect, 'nothing');
            }
            break;

					case 'secondary_right' :
            if (get_theme_mod($hiderSect) == 'menu') {
              set_theme_mod($hiderSect, 'nothing');
            }
            break;
        }

			}

		}

	}
}

function tesseract_set_menu_location_customizerupdate() {
	$selectorLocs = array(
		'tesseract_header_menu_select' => 'primary',
		'tesseract_footer_menu_select' => 'secondary',
		'tesseract_header_right_menu_select' => 'primary_right'
		);

	//Location 'secondary_right' is available ONLY if the branding removal plugin is installed
	if (is_plugin_active('tesseract-remove-branding/tesseract-remove-branding.php')) {
		$selectorLocs = array_merge($selectorLocs, array('tesseract_footer_right_menu_select' => 'secondary_right'));
	}

	// Returns the array of locations reserved
	$locs = get_theme_mod('nav_menu_locations');

	foreach ($selectorLocs as $selector => $loc) {
		$selection = get_theme_mod($selector); // = menu slug

		if ($selection !== 'none') {
			//Let's see if there's a menu associated with current location (if any)
			$locReserved = ! empty($locs[$loc]);

			switch ($loc) {
				case 'primary_right': 	$hiderSect = 'tesseract_header_right_content'; break;
				case 'secondary_right': $hiderSect = 'tesseract_footer_right_content'; break;
			}

			if ($locReserved) {
				$menu_id = $locs[$loc]; // $value = $array[$key]
				$menuObject = wp_get_nav_menu_object($menu_id);
				$menu_slug = $menuObject->slug;

				//Update customizer setting
				set_theme_mod($selector, $menu_slug);
			} elseif ( ! $locReserved && is_string($selection)) { // if no location set at Appearance -> Menus AND WE'RE NOT IN INSTALL PHASE ( when there's no $selection value )
				set_theme_mod($selector, 'none');

				//Update visibility
				switch ($loc) {
					case 'primary_right' :
            if (get_theme_mod($hiderSect) == 'menu') {
              set_theme_mod($hiderSect, 'nothing');
            }
            break;

					case 'secondary_right' :
            if (get_theme_mod($hiderSect) == 'menu') {
              set_theme_mod($hiderSect, 'nothing');
            }
            break;
        }

			}
		}

	}
}

//Let's call this on both side's init action
add_action('customize_save_after', 'tesseract_set_menu_location_customizerupdate', 77);
add_action('init', 'tesseract_set_menu_location_menuupdate', 77);
