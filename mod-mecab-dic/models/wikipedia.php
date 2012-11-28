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

    /**
     * Make Csv file.
     * 
     * @access public
     */
    public function makeCsvFileForMecabDic() {
        if (!file_exists(TARGET_FILE)) {
            die('Target file "' . TARGET_FILE . '" not found.' . "\n");
        }
        $fp = fopen(TARGET_FILE, "r");
        while (!feof($fp)) {
            $title = fgets($fp);
            $title = trim($title);
            $title = mb_convert_encoding($title, 'utf-8');
            if (preg_match('/^\./',$title)) {
                continue;
            }
            elseif (preg_match('/^[0-9]{1,100}$/',$title)) {
                continue;
            }
            elseif (preg_match('/[0-9]{4}./',$title)) {
                continue;
            }
            if (strlen($title) > 3) {
                $line   = array();
                $line[] = $title;
                $line[] = 0;
                $line[] = 0;
                $line[] = $this->_cost(-36000,-400 * (strlen($title)^1.5));
                $line[] = '名詞' ;
                $line[] = '固有名詞';
                $line[] = '*';
                $line[] = '*';
                $line[] = '*';
                $line[] = '*';
                $line[] = $title;
                $line[] = '*';
                $line[] = '*';
                $line[] = 'wikipedia_word';
                file_put_contents(TARGET_CSV_FILE,$this->_makeCsvString($line) . "\n",FILE_APPEND);
            }
        }
        fclose($fp);
    }
}
