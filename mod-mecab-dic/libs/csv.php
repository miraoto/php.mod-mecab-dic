<?php
/**
 * Create CSV file class.
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

class Csv {

    /**
     * Target Csv file name
     *
     * @var string
     */
    public $fileName = null;



    /**
     * Set csv file name.
     *
     * @access public
     * @param  string $fileName Csv file name
     */
    public function __construct($fileName) {
        $this->fileName = $fileName;
    }

    /**
     * Make Csv file.
     *
     * @access public
     */
    public function make() {
        if (!file_exists(TARGET_FILE)) {
            die('Target file "' . $this->fileName . '" not found.' . "\n");
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
                $line[] = $this->__cost(-36000,-400 * (strlen($title)^1.5));
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
                file_put_contents($this->fileName,$this->__makeCsvString($line) . "\n",FILE_APPEND);
            }
        }
        fclose($fp);
    }

    /**
     * Make word cost.
     *
     * @access private
     * @param  integer $comp
     * @param  integer $val
     */
    private function __cost($comp, $val) {
        $max  = $comp;
        if ( $comp <= $val ) {
            $max = $val;
        }
        return (int)$max;
    }

    /**
     * Make csv string
     *
     * @access private
     * @param  array $data
     */
    private function __makeCsvString($data) {
        foreach ($data as $k => $v) {
            if (preg_match("/[\",\n]/", $v)) {
                $data[$k] = '"' . str_replace('"', '""', $v) . '"';
            }
        }
        $line = implode(',', $data);
        return $line;
    }
}
