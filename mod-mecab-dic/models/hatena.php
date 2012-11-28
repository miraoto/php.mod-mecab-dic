<?php
/**
* Make 'Hatena keywords' mecab dictionary.
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

define('TARGET_URL', 'http://d.hatena.ne.jp/images/keyword/keywordlist_furigana.csv');
define('TARGET_FILE', SYSTEM_TMP_DIR . '/' . 'keywordlist_furigana.csv');

class Hatena extends Model {

    /**
     * Prepare target file.
     *  -append method.
     *
     * @access public
     */
    public function parseTargetFile() {
        $titleListFile = file_get_contents(TARGET_URL);
        file_put_contents(TARGET_FILE,$titleListFile);
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
            $line  = fgets($fp);
            $line  = mb_convert_encoding($line, 'utf-8','eucjp-win');
            $tmp   = explode("\t",$line);
            $tmp   = array_map("trim",$tmp);

            $title = $tmp[1];
            $hira  = ($tmp[0]) ? $tmp[0] : $tmp[1];
            $kana  = mb_convert_kana($hira,'C','utf8');
            
            if (preg_match('/^\./',$title)) {
                continue;
            }
            elseif (preg_match('/^[0-9]{1,100}$/',$title)) {
                continue;
            }
            elseif (preg_match('/[0-9]{4}./',$title)) {
                continue;
            }
            if (strlen($title)) {
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
                $line[] = $hira;
                $line[] = $kana;
                $line[] = $kana;
                $line[] = 'hatena_word';
                file_put_contents(TARGET_CSV_FILE,$this->_makeCsvString($line) . "\n",FILE_APPEND);
            }
        }
        fclose($fp);
    }
}
