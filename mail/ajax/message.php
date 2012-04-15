<?php
/**
 * ownCloud - Addressbook
 *
 * @author Thomas Tanghus
 * @copyright 2012 Jakob Sack <mail@jakobsack.de>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

// Init owncloud
require_once('../../../lib/base.php');

// Check if we are a user
OC_JSON::checkLoggedIn();
OC_JSON::checkAppEnabled('mail');

$account_id = isset( $_GET['account_id'] ) ? $_GET['account_id'] : null;
$folder_id = isset( $_GET['folder_id'] ) ? $_GET['folder_id'] : null;
$message_id = isset( $_GET['message_id'] ) ? $_GET['message_id'] : null;

$message = OC_Mail::getMessage( OC_User::getUser(), $account_id, $folder_id, $message_id );

if( $message['error'] ){
	OC_JSON::error(array('data' => array('message' => $message['error'] )));
	exit();
}

$tmpl = new OC_Template('mail','part.message');
$tmpl->assign('message', $message['message'] );
$page = $tmpl->fetchPage();

OC_JSON::success(array('data' => $page ));
