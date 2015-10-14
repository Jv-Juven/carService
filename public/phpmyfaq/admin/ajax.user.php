<?php
/**
 * AJAX: handling of Ajax user calls
 *
 * PHP Version 5.3
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 * @package   Administration
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2009-2015 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2009-04-04
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    $protocol = 'http';
    if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) === 'ON'){
        $protocol = 'https';
    }
    header('Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$ajaxAction = PMF_Filter::filterInput(INPUT_GET, 'ajaxaction', FILTER_SANITIZE_STRING);
$userId     = PMF_Filter::filterInput(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
$usersearch = PMF_Filter::filterInput(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
$csrfToken  = PMF_Filter::filterInput(INPUT_GET, 'csrf', FILTER_SANITIZE_STRING);

// Send headers
$http = new PMF_Helper_Http();
$http->setContentType('application/json');
$http->addHeader();

if ($permission['adduser'] || $permission['edituser'] || $permission['deluser']) {

    $user = new PMF_User($faqConfig);
    
    switch ($ajaxAction) {

        case 'get_user_list':
            $users = array();
            foreach ($user->searchUsers($usersearch) as $singleUser) {
                $users[] = array(
                    'user_id' => $singleUser['user_id'],
                    'name'    => $singleUser['login']
                );
            }
            echo json_encode($users);
            break;

        case 'get_user_data':
            $user->getUserById($userId, true);
            $userdata           = array();
            $userdata           = $user->userdata->get('*');
            $userdata['status'] = $user->getStatus();
            $userdata['login']  = $user->getLogin();
            print json_encode($userdata);
            break;

        case 'get_user_rights':
            $user->getUserById($userId, true);
            print json_encode($user->perm->getUserRights($userId));
            break;

        case 'delete_user':

            if (!isset($_SESSION['phpmyfaq_csrf_token']) || $_SESSION['phpmyfaq_csrf_token'] !== $csrfToken) {
                $http->sendJsonWithHeaders(array('error' => $PMF_LANG['err_NotAuth']));
                exit(1);
            }

            $user->getUserById($userId, true);
            if ($user->getStatus() == 'protected' || $userId == 1) {
                $message = '<p class="error">' . $PMF_LANG['ad_user_error_protectedAccount'] . '</p>';
            } else {
                if (!$user->deleteUser()) {
                    $message = $PMF_LANG['ad_user_error_delete'];
                } else {
                    $category = new PMF_Category($faqConfig, array(), false);
                    $category->moveOwnership($userId, 1);

                    // Remove the user from groups
                    if ('medium' == $faqConfig->get('security.permLevel')) {
                        $permissions = PMF_Perm::selectPerm('medium', $faqConfig);
                        $permissions->removeFromAllGroups($userId);
                    }
    
                    $message = '<p class="success">' . $PMF_LANG['ad_user_deleted'] . '</p>';
                }
            }
            print json_encode($message);
            break;

    }
    
}