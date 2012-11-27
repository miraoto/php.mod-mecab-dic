<?php
/**
 * Frequent using module to make mecab dictionary.
 *
 * Copyright (c) 2012 miraoto. All rights reserved.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012 miraoto. All rights reserved.
 * @link http://log.miraoto.com/
 * @package mod-mecab-dic
 * @since File available since Release 0.0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

define('SYSTEM_DIR',dirname(__FILE__));
define('SYSTEM_TMP_DIR',SYSTEM_DIR . '/' . 'tmp');

require_once SYSTEM_DIR . '/libs/model.php';
require_once SYSTEM_DIR . '/libs/csv.php';
require_once SYSTEM_DIR . '/libs/dictionary.php';

/**
 *
 */
if ($argc <= 1) {
    die('dictionary parameter not found.' . "\n");
}
$modelClassName = ucfirst($argv['1']);
$modelFile      = SYSTEM_DIR . '/models/' . $argv['1'] . '.php';
if (!file_exists($modelFile)) {
    die('"' . $modelFile . '" model file not found.' . "\n");
}
require_once $modelFile;

$modelClass = new $modelClassName();
if (!is_subclass_of($modelClass,'Model')) {
    die('"' . $modelClassName . '" must be a subclass of "Model".');
}
$modelClass->parseTargetFile();
/**
 *
 */
$csvClass = new Csv(TARGET_CSV_FILE);
$csvClass->make();
/**
 *
 */
$dictionaryClass = new Dictionary();
$dictionaryClass->make();

exit('finish' . "\n");
