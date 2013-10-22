<?php
class DateUtil {
	
	 

		// Will return the number of days between the two dates passed in
		public static function _count_days( $a, $b )
		{
			
			if( function_exists( 'date_default_timezone_set' ) ) {
					// Set the default timezone to US/Eastern
					date_default_timezone_set( 'US/Eastern' );
			}
			// First we need to break these dates into their constituent parts:
			$gd_a = getdate( $a );
			$gd_b = getdate( $b );

			// Now recreate these timestamps, based upon noon on each day
			// The specific time doesn't matter but it must be the same each day
			$a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] );
			$b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] );

			// Subtract these two numbers and divide by the number of seconds in a
			//  day. Round the result since crossing over a daylight savings time
			//  barrier will cause this time to be off by an hour or two.
			return round( abs( $a_new - $b_new ) / 86400 );
		}
		
		public static function test() {
			// Prepare a few dates
			$date1 = mktime(0, 0, 0, 5, 1, 2010);//strtotime( '2010-05-01 0:00:00' );
			$date2 = mktime(0, 0, 0, 6, 30, 2010);//strtotime( '2010-06-30 0:00:00' );
			$date3 = mktime(0, 0, 0, 10, 31, 2010);//strtotime( '2010-08-01 0:00:00' );

			// Calculate the differences, they should be 43 & 11353
			echo "<p>".date("d/m/Y H:i", $date1). "-".date("d/m/Y H:i", $date2).", There are ", DateUtil::_count_days( $date1, $date2 ), " days.</p>\n";
			echo "<p>".date("d/m/Y H:i", $date2). "-".date("d/m/Y H:i", $date3).", There are ", DateUtil::_count_days( $date2, $date3 ), " days.</p>\n";
		}
}

//DateUtil::test();
?>
