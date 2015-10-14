<?php
/**
 * Sitemap frontend
 *
 * PHP Version 5.3
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 * @package   Frontend
 * @author    Thomas Zeithaml <seo@annatom.de>
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2005-2015 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2005-08-21
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    $protocol = 'http';
    if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) === 'ON'){
        $protocol = 'https';
    }
    header('Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$faqsession->userTracking('sitemap', 0);

$letter = PMF_Filter::filterInput(INPUT_GET, 'letter', FILTER_SANITIZE_STRIPPED);
if (!is_null($letter) && (1 == PMF_String::strlen($letter))) {
    $currentLetter = strtoupper(PMF_String::substr($letter, 0, 1));
} else {
    $currentLetter = '';
}

$sitemap = new PMF_Sitemap($faqConfig);
$sitemap->setUser($current_user);
$sitemap->setGroups($current_groups);

$tpl->parse (
    'writeContent',
    array(
        'writeLetters'       => $sitemap->getAllFirstLetters(),
        'writeMap'           => $sitemap->getRecordsFromLetter($currentLetter),
        'writeCurrentLetter' => empty($currentLetter) ? $PMF_LANG['msgSitemap'] : $currentLetter
    )
);

$tpl->merge('writeContent', 'index');