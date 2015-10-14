<?php
/**
 * Shows the admin search frontend for FAQs
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
 * @copyright 2011-2015 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2011-09-29
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    $protocol = 'http';
    if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) === 'ON'){
        $protocol = 'https';
    }
    header('Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

printf(
    '<header><h2><i class="icon-pencil"></i> %s</h2><header>',
    $PMF_LANG['ad_menu_searchfaqs']
);

if ($permission['editbt'] || $permission['delbt']) {

    $searchcat  = PMF_Filter::filterInput(INPUT_POST, 'searchcat', FILTER_VALIDATE_INT);
    $searchterm = PMF_Filter::filterInput(INPUT_POST, 'searchterm', FILTER_SANITIZE_STRIPPED);

    $category = new PMF_Category($faqConfig, array(), false);
    $category->setUser($currentAdminUser);
    $category->setGroups($currentAdminGroups);
    $category->transform(0);

    // Set the Category for the helper class
    $categoryHelper = new PMF_Helper_Category();
    $categoryHelper->setCategory($category);

    $category->buildTree();
    
    $linkVerifier = new PMF_Linkverifier($faqConfig, $user->getLogin());
?>

    <form action="?action=view" method="post" class="form-horizontal form-search" accept-charset="utf-8">

        <div class="control-group">
            <label class="control-label"><?php print $PMF_LANG["msgSearchWord"]; ?>:</label>
            <div class="input-append" style="margin-left: 20px;">
                <input class="search-query" type="search" name="searchterm" autofocus
                       value="<?php print $searchterm; ?>" />
                <button class="btn btn-primary" type="submit" name="submit">
                    <?php print $PMF_LANG["msgSearch"]; ?>
                </button>
            </div>
        </div>

        <?php if ($linkVerifier->isReady() == true): ?>
        <div class="control-group">
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" name="linkstate" value="linkbad" />
                    <?php print $PMF_LANG['ad_linkcheck_searchbadonly']; ?>
                </label>
            </div>
        </div>
        <?php endif; ?>

        <div class="control-group">
            <label class="control-label"><?php print $PMF_LANG["msgCategory"]; ?>:</label>
            <div class="controls">
                <select name="searchcat">
                    <option value="0"><?php print $PMF_LANG["msgShowAllCategories"]; ?></option>
                    <?php print $categoryHelper->renderOptions($searchcat); ?>
                </select>
            </div>
        </div>

    </form>

<?php
} else {
    print $PMF_LANG['err_NotAuth'];
}