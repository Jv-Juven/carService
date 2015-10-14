/**
 * JavaScript functions for all FAQ record administration stuff
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 * @package   Administration
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2013 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2013-11-17
 */

$(document).ready(function() {
    "use strict";
    $(".showhideCategory").click(function(event) {
        var categoryId = $("#category_" + $(this).data("category-id"));
        if (categoryId.css("display") === "none") {
            categoryId.fadeIn("slow");
        } else {
            categoryId.fadeOut("slow");
        }
    });
});