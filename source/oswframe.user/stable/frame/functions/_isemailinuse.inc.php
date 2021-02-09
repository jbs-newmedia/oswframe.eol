<?php

/*
 * Author: Juergen Schwind
 * Copyright: 2011 Juergen Schwind
 * Link: http://oswframe.com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/gpl.html
 *
 */

/*
 *  status
 *  1 - email in use but not activated
 *  2 - email in use and activated
 */
function _isEmailInUse($var) {
	if (!isset($var[1])) {
		$var[1]='%';
	}

	$Quser=osW_Database::getInstance()->query('SELECT user_id, user_status FROM :table_user: WHERE user_email=:user_email: AND user_status LIKE :user_status:');
	$Quser->bindTable(':table_user:', 'user');
	$Quser->bindValue(':user_email:', $var[0]);
	if ($var[1]=='%') {
		$Quser->bindValue(':user_status:', $var[1]);
	} else {
		$Quser->bindInt(':user_status:', $var[1]);
	}
	$Quser->execute();
	if ($Quser->numberOfRows()===1) {
		$Quser->next();
		if ($Quser->Value('user_status')==0) {
			return ['status'=>2, 'message'=>tnOut('email_inusebutnotactivated_error')];
		} else {
			return ['status'=>1, 'message'=>tnOut('email_inuse_error')];
		}
	} else {
		return true;
	}
}

?>