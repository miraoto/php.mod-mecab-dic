<?php
/**
 * Frequent using model.
 *
 * Copyright (c) 2012 miraoto. All rights reserved.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012 miraoto. All rights reserved.
 * @link http://log.miraoto.com/
 * @package mod-mecab-dic.libs
 * @since File available since Release 0.0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

define('TARGET_CSV_FILE',SYSTEM_TMP_DIR . '/mecab-dic.csv');
define('TARGET_DIC_FILE',SYSTEM_TMP_DIR . '/mecab-dic.dic');

class Model {

    /**
     * Check defined parameter.
     *
     * @access public
     */
    public function __construct() {
        if (!defined('TARGET_URL')) {
            die('TARGET URL undefined.');
        }
        if (!defined('TARGET_FILE')) {
            die('TARGET FILE undefined.');
        }
    }

    /**
     * Prepare target file.
     *  -append method.
     *
     * @access public
     */
    public function parseTargetFile() {
    }

    /**
     * Delete the unnecessary files.
     *
     * @access public
     */
    public function __destruct() {
        if (file_exists(TARGET_FILE)) {
            unlink(TARGET_FILE);
        }
/*
        if (file_exists(TARGET_CSV_FILE)) {
            unlink(TARGET_CSV_FILE);
        }
*/
    }
}
