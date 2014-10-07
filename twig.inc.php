<?php

$twig;
require_once( __DIR__ . '/Twig/lib/Twig/Autoloader.php' );
Twig_Autoloader::register();

// setup twig environment
$loader = new Twig_Loader_Filesystem( BASE . $config->micro->view_directory );
$loader->addPath( __DIR__ . '/templates' );
$loader->addPath( BASE . $config->micro->view_partials_directory );
foreach ( $config->micro->components as $key => $component ) {
	$loader->addPath( BASE . $component->path );
}
if ( isset( $twigAdditionalPaths ) && is_array( $twigAdditionalPaths ) ) {
	for ( $i = 0; $i < count( $twigAdditionalPaths ); $i ++ ) {
		$loader->addPath( $twigAdditionalPaths[ $i ] );
	}
}
$twig = new Twig_Environment( $loader );

// other functions
$twig->addFunction(
	new Twig_SimpleFunction( 'text', function ( $count ) {
		$words = array('lorem','ipsum','dolor','sit','amet','consectetur','adipiscing','elit','curabitur','vel','hendrerit','libero','eleifend','blandit','nunc','ornare','odio','ut','orci','gravida','imperdiet','nullam', 'purus', 'lacinia', 'a', 'pretium', 'quis', 'congue', 'praesent', 'sagittis', 'laoreet', 'auctor', 'mauris', 'non', 'velit', 'eros', 'dictum', 'proin', 'accumsan', 'sapien', 'nec', 'massa', 'volutpat', 'venenatis', 'sed', 'eu', 'molestie', 'lacus', 'quisque', 'porttitor', 'ligula', 'dui', 'mollis', 'tempus', 'at', 'magna', 'vestibulum', 'turpis', 'ac', 'diam', 'tincidunt', 'id', 'condimentum', 'enim', 'sodales', 'in', 'hac', 'habitasse', 'platea', 'dictumst', 'aenean', 'neque', 'fusce', 'augue', 'leo', 'eget', 'semper', 'mattis', 'tortor', 'scelerisque', 'nulla', 'interdum', 'tellus', 'malesuada', 'rhoncus', 'porta', 'sem', 'aliquet', 'et', 'nam', 'suspendisse', 'potenti', 'vivamus', 'luctus', 'fringilla', 'erat', 'donec', 'justo', 'vehicula', 'ultricies', 'varius', 'ante', 'primis', 'faucibus', 'ultrices', 'posuere', 'cubilia', 'curae', 'etiam', 'cursus', 'aliquam', 'quam', 'dapibus', 'nisl', 'feugiat', 'egestas', 'class', 'aptent', 'taciti', 'sociosqu', 'ad', 'litora', 'torquent', 'per', 'conubia', 'nostra', 'inceptos', 'himenaeos', 'phasellus', 'nibh', 'pulvinar', 'vitae', 'urna', 'iaculis', 'lobortis', 'nisi', 'viverra', 'arcu', 'morbi', 'pellentesque', 'metus', 'commodo', 'ut', 'facilisis', 'felis', 'tristique', 'ullamcorper', 'placerat', 'aenean', 'convallis', 'sollicitudin', 'integer', 'rutrum', 'duis', 'est', 'etiam', 'bibendum', 'donec', 'pharetra', 'vulputate', 'maecenas', 'mi', 'fermentum', 'consequat', 'suscipit', 'aliquam', 'habitant', 'senectus', 'netus', 'fames', 'quisque', 'euismod', 'curabitur', 'lectus', 'elementum', 'tempor', 'risus', 'cras');
		$arr  = array();
		for ( $i = 0; $i < $count; $i ++ ) {
			$word = $words[ array_rand( $words ) ];
			if ( $i > 0 && $arr[ $i - 1 ] == $word ) {
				$i --;
			}
			else {
				$arr[ $i ] = $word;
			}
		}

		return ucfirst( implode( ' ', $arr ) );
	} )
);
$twig->addFunction(
	new Twig_SimpleFunction( 'id', function ( $key = null, $uselast = false ) {
		if ( $uselast === false ) {
			$_SESSION['lastid'][ $key ] = uniqid();
		}
		$prefix = is_null( $key ) ? "" : $key . "-";

		return $prefix . $_SESSION['lastid'][ $key ];
	} )
);
$containingTest = new Twig_SimpleTest( 'containing', function ( $value, $needle ) {
	return strpos( $value, $needle ) !== false;
} );
$twig->addTest( $containingTest );
$dashFilter = new Twig_SimpleFilter( 'dash', function ( $value ) {
	return strtolower( preg_replace( array( '/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/' ), array(
				'\\1-\\2',
				'\\1-\\2'
			), $value ) );
} );
$twig->addFilter( $dashFilter );

if ( isset( $twigAdditionalFunctions ) && is_callable( $twigAdditionalFunctions ) ) {
	$twigAdditionalFunctions( $twig );
}

// add tc.module macro to global scope
$twig->addGlobal( 'tc', $twig->loadTemplate( 'terrific-module.twig' ) );
$twig->addGlobal( '_REQUEST', $_REQUEST );
$twig->addGlobal( 'view_file_extension', $config->micro->view_file_extension );


// use twig as view template renderer
function render_view_template( $view ) {
	global $twig, $config;
	$view = str_replace( BASE . $config->micro->view_directory . '/', '', $view );
	try {
		echo $twig->render( $view );
	} catch ( Twig_Error_Loader $e ) {
		?>
		<h1>Twig Error</h1>
		<pre style="max-width: 100%; white-space: normal;">
			<?php
			echo $e->getMessage();
			?>
			</pre>
	<?php
	} catch ( Twig_Error $e ) {
		?>
		<h1>Twig Error</h1>
		<pre style="max-width: 100%; white-space: normal;">
			<?php
			echo $e->getMessage();
			?>
			</pre>
	<?php
	}
}
