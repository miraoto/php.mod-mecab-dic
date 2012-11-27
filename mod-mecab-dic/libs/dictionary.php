<?php
/**
* Create Mecab dictionary file class.
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
class Dictionary {

    /**
     * Make mecab dictionary file.
     *
     * @access public
     */
    public function make() {
        $command  = '/usr/local/libexec/mecab/mecab-dict-index -d ';
        $command .= '/usr/local/lib/mecab/dic/ipadic/ -u ';
        $command .= TARGET_DIC_FILE . ' -f utf8 -t utf8 ' . TARGET_CSV_FILE;
        exec($command);
    }
}
