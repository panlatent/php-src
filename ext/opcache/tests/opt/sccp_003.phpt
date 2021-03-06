--TEST--
SCCP 003: Conditional Constant Propagation of non-escaping array elements
--INI--
opcache.enable=1
opcache.enable_cli=1
opcache.optimization_level=-1
opcache.opt_debug_level=0x20000
opcache.preload=
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php
function foo() {
	$a = [1,2,3];
	$i = 1;
	$c = $i < 2;
	if ($c) {
		$k = 2 * $i;
		$a[$k] = $i;
		echo $a[$k];
	}
	echo $a[2];
}
?>
--EXPECTF--
$_main: ; (lines=1, args=0, vars=0, tmps=0)
    ; (after optimizer)
    ; %ssccp_003.php:1-14
L0 (14):    RETURN int(1)

foo: ; (lines=3, args=0, vars=0, tmps=0)
    ; (after optimizer)
    ; %ssccp_003.php:2-12
L0 (9):     ECHO int(1)
L1 (11):    ECHO int(1)
L2 (12):    RETURN null
