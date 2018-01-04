<?php
/**
 * Date setting class for the fields manager.
 *
 * @package    CustomContentTeam
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Date setting class.
 *
 * @since  1.0.0
 * @access public
 */
class CCT_Fields_Setting_Date extends CCT_Fields_Setting {

	/**
	 * Gets the posted value of the setting.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed
	 */
	public function get_posted_value() {

		// Get the posted year, month, and day.
		$year  = ! empty( $_POST[ "cct_{$this->manager->name}_setting_{$this->name}_year" ] )  ? zeroise( absint( $_POST[ "cct_{$this->manager->name}_setting_{$this->name}_year" ]  ), 4 ) : '';
		$month = ! empty( $_POST[ "cct_{$this->manager->name}_setting_{$this->name}_month" ] ) ? zeroise( absint( $_POST[ "cct_{$this->manager->name}_setting_{$this->name}_month" ] ), 2 ) : '';
		$day   = ! empty( $_POST[ "cct_{$this->manager->name}_setting_{$this->name}_day" ] )   ? zeroise( absint( $_POST[ "cct_{$this->manager->name}_setting_{$this->name}_day" ]   ), 2 ) : '';

		$new_date = $year && $month && $day ? "{$year}-{$month}-{$day} 00:00:00" : '';

		return $new_date;
	}
}
