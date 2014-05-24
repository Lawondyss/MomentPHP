<?php

require __DIR__ . '/bootstrap.php';

use MomentPHP\MomentPHP;
use Tester\Assert;
use Tester\TestCase;

class MomentPHPTest extends TestCase
{
  /** @var MomentPHP/MomentPHP */
  private $moment;


  protected function setUp()
  {
    $this->moment = new MomentPHP('1980-12-07 19:21:42', null, 'Europe/Prague');
  }

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


  public function testTimestamp()
  {
    Assert::same('345061302', $this->moment->timestamp());
  }


  public function testSeconds()
  {
    Assert::same('42', $this->moment->seconds());
    Assert::same('42', $this->moment->second());
  }


  public function testMinutes()
  {
    Assert::same('21', $this->moment->minutes());
    Assert::same('21', $this->moment->minute());
  }


  public function testHours()
  {
    Assert::same('19', $this->moment->hours());
    Assert::same('19', $this->moment->hour());
  }


  public function testDays()
  {
    Assert::same('07', $this->moment->days());
    Assert::same('07', $this->moment->day());
  }


  public function testWeeks()
  {
    Assert::same('49', $this->moment->weeks());
    Assert::same('49', $this->moment->week());
  }


  public function testMonths()
  {
    Assert::same('12', $this->moment->months());
    Assert::same('12', $this->moment->month());
  }


  public function testYears()
  {
    Assert::same('1980', $this->moment->years());
    Assert::same('1980', $this->moment->year());
  }


  public function testDayOfWeek()
  {
    Assert::same('7', $this->moment->dayOfWeek());
  }


  public function testDayOfYear()
  {
    Assert::same('342', $this->moment->dayOfYear());
  }


  public function testNameOfDayShort()
  {
    Assert::same('Sun', $this->moment->nameOfDayShort());
  }


  public function testNameOfDayLong()
  {
    Assert::same('Sunday', $this->moment->nameOfDayLong());
  }


  public function testDayWithSuffix()
  {
    Assert::same('7th', $this->moment->dayWithSuffix());
  }


  public function testDaysInMonth()
  {
    Assert::same('31', $this->moment->daysInMonth());
  }


  public function testNameOfMonthShort()
  {
    Assert::same('Dec', $this->moment->nameOfMonthShort());
  }


  public function testNameOfMonthLong()
  {
    Assert::same('December', $this->moment->nameOfMonthLong());
  }


  public function testHourWithSuffix()
  {
    Assert::same('7PM', $this->moment->hourWithSuffix());
  }


  public function testIsoDate()
  {
    Assert::same('1980-12-07T19:21:42+01:00', $this->moment->isoDate());
  }


  /**
   * @dataProvider getValidIntervalUnits
   */
  public function testValidIntervalUnits($unit)
  {
    Assert::type('MomentPHP\MomentPHP', $this->moment->add(1, $unit));
  }

  public function getValidIntervalUnits()
  {
    return array(
      array('sec'),
      array('second'),
      array('seconds'),
      array('min'),
      array('minute'),
      array('minutes'),
      array('hour'),
      array('hours'),
      array('day'),
      array('days'),
      array('month'),
      array('months'),
      array('year'),
      array('years'),
    );
  }


  /**
   * @dataProvider getInvalidIntervalUnits
   */
  public function testInvalidIntervalUnits($unit)
  {
    Assert::exception(function() use ($unit) {
      $this->moment->add(1, $unit);
    }, 'MomentPHP\InvalidArgumentException');
  }

  public function getInvalidIntervalUnits()
  {
    return array(
      array('_seconds'),
      array('_minutes'),
      array('_hours'),
      array('_days'),
      array('_months'),
      array('_years'),
    );
  }


  public function testAdd()
  {
    Assert::type('MomentPHP\MomentPHP', $this->moment->add(1, 'day'));
    Assert::same('08', $this->moment->days());

    Assert::type('MomentPHP\MomentPHP', $this->moment->add(1, 'days'));
    Assert::same('09', $this->moment->days());

    $interval = DateInterval::createFromDateString('1 day');
    Assert::type('MomentPHP\MomentPHP', $this->moment->add($interval));
    Assert::same('10', $this->moment->days());

    $field = array('days' => 1, 'years' => 1);
    Assert::type('MomentPHP\MomentPHP', $this->moment->add($field));
    Assert::same('11|1981', $this->moment->format('d|Y'));
  }


  public function testSub()
  {
    Assert::type('MomentPHP\MomentPHP', $this->moment->sub(1, 'day'));
    Assert::same('06', $this->moment->days());

    Assert::type('MomentPHP\MomentPHP', $this->moment->sub(1, 'days'));
    Assert::same('05', $this->moment->days());

    $interval = DateInterval::createFromDateString('1 day');
    Assert::type('MomentPHP\MomentPHP', $this->moment->sub($interval));
    Assert::same('04', $this->moment->days());

    $field = array('days' => 1, 'years' => 1);
    Assert::type('MomentPHP\MomentPHP', $this->moment->sub($field));
    Assert::same('03|1979', $this->moment->format('d|Y'));
  }


  public function testIsLeapYear()
  {
    $moment = new MomentPHP('2012', 'Y');
    Assert::true($moment->isLeapYear());

    $moment = new MomentPHP('2013', 'Y');
    Assert::false($moment->isLeapYear());
  }


  public function testIsDaylightSavingTime()
  {
    $moment = new MomentPHP('06', 'm');
    Assert::true($moment->isDST());

    $moment = new MomentPHP('12', 'm');
    Assert::false($moment->isDST());
  }


  public function testIsMomentPHP()
  {
    Assert::true($this->moment->isMomentPHP(new MomentPHP));

    Assert::false($this->moment->isMomentPHP(new DateTime));
  }
}

$testCase = new MomentPHPTest;
$testCase->run();