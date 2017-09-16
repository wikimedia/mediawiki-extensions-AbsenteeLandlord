<?php
/**
 * Main class for the AbsenteeLandlord MediaWiki extension.
 * This extension will automatically lock the database from any further changes
 * if a sysop has not been on the wiki recently (as determined by the global
 * variable $wgAbsenteeLandlordMaxDays; 90 days by default).
 *
 * @file
 * @ingroup Extensions
 * @see https://www.mediawiki.org/wiki/Extension:AbsenteeLandlord
 */
class AbsenteeLandlord {

	public static function setup() {
		global $wgAbsenteeLandlordMaxDays;

		// # days * 24 hours * 60 minutes * 60 seconds
		$timeout = $wgAbsenteeLandlordMaxDays * 24 * 60 * 60;
		$lastTouched = filemtime( __DIR__ . '/lasttouched.txt' );
		$check = time() - $lastTouched;

		if ( $check >= $timeout ) {
			global $wgUser;
			$groups = $wgUser->getGroups();

			if ( !in_array( 'sysop', $groups ) ) {
				global $wgReadOnly;

				# Set the reason why the database is locked
				$wgReadOnly = wfMessage( 'absenteelandlord-reason' )->text();
			}
		}

		return true;
	}

	public static function maybeDoTouch( OutputPage &$out, Skin &$skin ) {
		$groups = $out->getUser()->getGroups();
		if ( in_array( 'sysop', $groups ) ) {
			touch( __DIR__ . '/lasttouched.txt' );
		}
		return true;
	}

}
