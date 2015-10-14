<?php
/**
 * This is the page there a user can view all glossary items
 *
 * PHP Version 5.3
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 * @package   Frontend
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2012-2015 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2012-09-03
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    $protocol = 'http';
    if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) === 'ON'){
        $protocol = 'https';
    }
    header('Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$page = PMF_Filter::filterInput(INPUT_GET, 'page' , FILTER_VALIDATE_INT, 1);

$glossary      = new PMF_Glossary($faqConfig);
$glossaryItems = $glossary->getAllGlossaryItems();
$numItems      = count($glossaryItems);
$itemsPerPage  = 10;

$baseUrl = sprintf(
    '%s?action=glossary&amp;page=%d',
    PMF_Link::getSystemRelativeUri(),
    $page
);

// Pagination options
$options = array(
    'baseUrl'         => $baseUrl,
    'total'           => count($glossaryItems),
    'perPage'         => $itemsPerPage,
    'pageParamName'   => 'page'
);
$pagination = new PMF_Pagination($faqConfig, $options);

if (0 < $numItems) {
        
    $output       = array();
    $visibleItems = array_slice($glossaryItems, ($page - 1) * $itemsPerPage, $itemsPerPage);

    foreach ($visibleItems as $item) {
        $output['item'][]       = $item['item'];
        $output['definition'][] = $item['definition'];
        $i++;
    }
    
    $tpl->parseBlock(
        'writeContent',
        'glossaryItems',
        array(
            'item' => $output['item'],
            'desc' => $output['definition']
        )
    );
}

$tpl->parse(
    'writeContent',
    array(
        'msgGlossary'            => $PMF_LANG['ad_menu_glossary'],
        'msgGlossrayItem'        => $PMF_LANG['ad_glossary_item'],
        'msgGlossaryDescription' => $PMF_LANG['ad_glossary_definition'],
        'pagination'             => $pagination->render(),
        'glossaryData'           => ''
    )
);

$tpl->merge('writeContent', 'index');