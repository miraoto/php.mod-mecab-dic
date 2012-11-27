<?php
/**
* Make 'Wikipedia' mecab dictionary.
*
* Copyright (c) 2012 miraoto. All rights reserved.
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @copyright Copyright (c) 2012 miraoto. All rights reserved.
* @link http://log.miraoto.com/
* @package mod-mecab-dic.models
* @since File available since Release 0.0.1
* @license MIT License (http://www.opensource.org/licenses/mit-license.php)
*/

define('TARGET_URL', 'http://dumps.wikimedia.org/jawiki/latest/jawiki-latest-all-titles-in-ns0.gz');
define('TARGET_FILE', SYSTEM_TMP_DIR . '/' . 'jawiki-latest-all-titles-in-ns0');

class Wikipedia extends Model {

    /**
     * Prepare target file.
     *  -append method.
     *
     * @access public
     */
    public function parseTargetFile() {
        $titleListFile = file_get_contents(TARGET_URL);
        if (file_put_contents(TARGET_FILE . '.gz',$titleListFile)) {
            exec('gunzip ' . TARGET_FILE . '.gz');
        }
    }
}