<?php

require __DIR__ . '/bootstrap.php';

use MomentPHP\MomentPHP;
use Tester\Assert;
use Tester\TestCase;

class MomentPHPTest extends TestCase
{
  public function testValidDateTime()
  {
    $type = 'MomentPHP\MomentPHP';

    Assert::type($type, new MomentPHP(null));

    Assert::type($type, new MomentPHP(new DateTime));

    Assert::type($type, new MomentPHP('now'));

    Assert::type($type, new MomentPHP(1));
  }


  public function testInvalidDateTime()
  {
    $exception = 'MomentPHP\InvalidArgumentException';

    Assert::exception(function() {
      new MomentPHP(true);
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(function(){});
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(array());
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(1.1);
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(-1);
    }, $exception);

    Assert::exception(function() {
      new MomentPHP('');
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(new stdClass);
    }, $exception);
  }


  public function testValidFormat()
  {
    $type = 'MomentPHP\MomentPHP';

    // format use only if dateTime is a string

    Assert::type($type, new MomentPHP('2000', array('Y')));

    Assert::type($type, new MomentPHP('2000', 'Y'));
  }


  public function testInvalidFormat()
  {
    $exception = 'MomentPHP\InvalidArgumentException';

    Assert::exception(function() {
      new MomentPHP(null, 1);
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, 1.1);
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, function(){});
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, true);
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, new stdClass());
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, '');
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, array());
    },$exception);
  }


  public function testValidTimeZone()
  {
    $type = 'MomentPHP\MomentPHP';

    Assert::type($type, new MomentPHP(null, null, null));

    Assert::type($type, new MomentPHP(null, null, 'Europe/London'));

    Assert::type($type, new MomentPHP(null, null, new DateTimeZone('Europe/London')));
  }


  public function testInvalidTimeZone()
  {
    $exception = 'MomentPHP\InvalidArgumentException';

    Assert::exception(function() {
      new MomentPHP(null, null, array());
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, null, true);
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, null, function(){});
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, null, 1.1);
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, null, 1);
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, null, new stdClass());
    }, $exception);

    Assert::exception(function() {
      new MomentPHP(null, null, '');
    }, $exception);
  }


  public function testFormat()
  {
    $moment = new MomentPHP(1000000000);
    Assert::equal('2001-09-09', $moment->format('Y-m-d'));

    $moment = new MomentPHP('20000101', 'Ymd');
    Assert::equal('2000-01-01', $moment->format('Y-m-d'));

    $moment = new MomentPHP('20002010', array('Ymd', 'Ydm'));
    Assert::equal('2001-08-10', $moment->format('Y-m-d'));

    $moment = new MomentPHP('20000101', array('d', 'Ymd'));
    Assert::equal('2000-01-01', $moment->format('Y-m-d'));

    $moment = new MomentPHP('1. Jan 2000');
    Assert::equal('2000-01-01', $moment->format('Y-m-d'));

    $moment = new MomentPHP('today is 2000 January 1', '\t\o\d\a\y \i\s Y F j');
    Assert::equal('2000-01-01', $moment->format('Y-m-d'));

    $expression = 'next month';
    $timestamp = strtotime($expression);
    $expect = date('m', $timestamp);
    $moment = new MomentPHP($expression);
    Assert::equal($expect, $moment->format('m'));

    Assert::exception(function() {
      new MomentPHP('2000', 'Ym');
    }, 'MomentPHP\ErrorException', 'DateTime not create. Probably the wrong format.');
  }
}

$testCase = new MomentPHPTest;
$testCase->run();