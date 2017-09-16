<?php
/** \file
* \brief Contains code for the AbsenteeLandlord extension by Ryan Schmidt and Tim Laqua.
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is an extension to the MediaWiki software and cannot be used standalone\n";
	die( 1 );
}

$wgAbsenteeLandlordMaxDays = 90; // how many days do the sysops have to be inactive for?

$wgExtensionCredits['other'][] = [
	'path' => __FILE__,
	'name' => 'Absentee Landlord',
	'author' => [ 'Ryan Schmidt', 'Tim Laqua' ],
	'license-name' => 'GPL-2.0+',
	'version' => '1.3.0',
	'descriptionmsg' => 'absenteelandlord-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AbsenteeLandlord',
];

$wgAutoloadClasses['AbsenteeLandlord'] = __DIR__ . '/AbsenteeLandlord.class.php';

$wgExtensionFunctions[] = 'AbsenteeLandlord::setup';
$wgHooks['BeforePageDisplay'][] = 'AbsenteeLandlord::maybeDoTouch';

$wgMessagesDirs['AbsenteeLandlord'] = __DIR__ . '/i18n';
