<?php
/**
 * Features that are required for other plugins features.
 *
 * Example: The BoldGrid Editor Plugin checks for theme-fonts-classes feature before
 * allowing a user to select a theme font.
 *
 * @since 1.2.4
 */

return array(
	'supported-features' => array(
		'border-color-classes',
		'theme-fonts-classes',
		'variable-containers'
	),
);