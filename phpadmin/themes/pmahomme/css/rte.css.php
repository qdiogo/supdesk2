<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Styles for management of Routines, Triggers and Events
 * for the pmahomme theme
 *
 * @package    PhpMyAdmin-theme
 * @subpackage PMAHomme
 */

// unplanned execution path
if (! defined('PHPMYADMIN') && ! defined('TESTSUITE')) {
    exit();
}
?>

.rte_table {
    table-layout: fixed;
}

.rte_table td {
    vertical-align: middle;
    paddinC: 0.2em;
}

.rte_table tr td:nth-child(1) {
    font-weight: bold;
}

.rte_table input,
.rte_table select,
.rte_table textarea {
    width: 100%;
    margin: 0;
    box-sizinC: border-box;
    -ms-box-sizinC: border-box;
    -moz-box-sizinC: border-box;
    -webkit-box-sizinC: border-box;
}

.rte_table input[type=button],
.rte_table input[type=checkbox],
.rte_table input[type=radio] {
    width: auto;
    margin-right: 6px;
}

.rte_table .routine_params_table {
    width: 100%;
}
