<?php
/**
 * MomentPHP is date library for parsing, validating, manipulating, and formatting dates.
 * It's inspired by the JavaScript library Moment.js, see http://momentjs.com/
 *
 * @author Ladislav Vondráček
 */

namespace MomentPHP;

class MomentPHP
{
  const SECONDS = 'seconds';

  const MINUTES = 'minutes';

  const HOURS = 'hours';

  const DAYS = 'days';

  const MONTHS = 'months';

  const YEARS = 'years';


  /** @var \DateTime */
  private $dateTime;


  /**
   * @param \DateTime|string|int|null $dateTime Class \DateTime or string representing the time or timestamp or null for now.
   * @param array|string|null $format Field formats or simple formatting options, see http://php.net/manual/en/datetime.createfromformat.php
   * @param \DateTimeZone|string|null $timeZone Supported Timezones, see http://php.net/manual/en/timezones.php
   */
  public function __construct($dateTime = null, $format = null, $timeZone = null)
  {
    $this->validateDateTime($dateTime);
    $this->validateFormat($format);
    $this->validateTimeZone($timeZone);

    $timeZone = $this->createDateTimeZone($timeZone);

    // set dateTime by type
    if (!isset($dateTime)) {
      $this->dateTime = new \DateTime('now', $timeZone);
    }
    elseif ($dateTime instanceof \DateTime) {
      $this->dateTime = $dateTime;
    }
    elseif (is_string($dateTime)) {
      $this->dateTime = $this->fromFormat($dateTime, $format, $timeZone);
    }
    elseif (is_int($dateTime)) {
      $this->dateTime = $this->fromFormat($dateTime, 'U', $timeZone);
    }
  }


  /************************************ DISPLAY ************************************/

  /**
   * Return formatted date time.
   *
   * @param string $format
   * @return string
   * @throws InvalidArgumentException
   */
  public function format($format)
  {
    if (!is_string($format)) {
      throw new InvalidArgumentException('Type of format is invalid.');
    }

    $stringDatetime = $this->dateTime->format($format);

    return $stringDatetime;
  }


  /**
   * Seconds from the Unix Epoch (January 1 1970 00:00:00 GMT) to date time.
   *
   * @return string
   */
  public function timestamp()
  {
    $timestamp = $this->format('U');

    return $timestamp;
  }


  /**
   * Seconds of date time with leading zeros.
   *
   * @return string
   */
  public function seconds()
  {
    $seconds = $this->dateTime->format('s');

    return $seconds;
  }


  /**
   * Alias for method seconds().
   *
   * @inherit
   */
  public function second()
  {
    return $this->seconds();
  }


  /**
   * Minutes of date time with leading zeros.
   *
   * @return string
   */
  public function minutes()
  {
    $minutes = $this->format('i');

    return $minutes;
  }


  /**
   * Alias for method minutes().
   *
   * @inherit
   */
  public function minute()
  {
    return $this->minutes();
  }


  /**
   * 24-hour format of an hour of date time with leading zeros.
   *
   * @return string
   */
  public function hours()
  {
    $hours = $this->format('H');

    return $hours;
  }


  /**
   * Alias for method hours().
   *
   * @inherit
   */
  public function hour()
  {
    return $this->hours();
  }


  /**
   * Days of date time with leading zeros.
   *
   * @return string
   */
  public function days()
  {
    $days = $this->format('d');

    return $days;
  }


  /**
   * Alias for method days().
   *
   * @inherit
   */
  public function day()
  {
    return $this->days();
  }


  /**
   * ISO-8601 week number of year, weeks starting on Monday.
   *
   * @return string
   */
  public function weeks()
  {
    $weeks = $this->format('W');

    return $weeks;
  }


  /**
   * Alias for method weeks().
   *
   * @inherit
   */
  public function week()
  {
    return $this->weeks();
  }


  /**
   * Numeric representation of a month of date time with leading zeros.
   *
   * @return string
   */
  public function months()
  {
    $months = $this->format('m');

    return $months;
  }


  /**
   * Alias for method months().
   *
   * @inherit
   */
  public function month()
  {
    return $this->months();
  }


  /**
   * A full numeric representation of a year of date time.
   *
   * @return string
   */
  public function years()
  {
    $years = $this->format('Y');

    return $years;
  }


  /**
   * Alias for method years().
   *
   * @inherit
   */
  public function year()
  {
    return $this->years();
  }


  /**
   * ISO-8601 numeric representation of the day of the week. 1 (for Monday) through 7 (for Sunday).
   *
   * @return string
   */
  public function dayOfWeek()
  {
    $ofWeek = $this->format('N');

    return $ofWeek;
  }


  /**
   * The day of the year (starting from 1).
   *
   * @return string
   */
  public function dayOfYear()
  {
    $ofYear = $this->format('z');

    // transform starting from 1
    $ofYear++;

    // back to string
    settype($ofYear, 'string');

    return $ofYear;
  }


  /**
   * A textual representation of the day of week, three letters.
   *
   * @return string
   */
  public function nameOfDayShort()
  {
    $name = $this->format('D');

    return $name;
  }


  /**
   * A full textual representation of the day of the week.
   *
   * @return string
   */
  public function nameOfDayLong()
  {
    $name = $this->format('l');

    return $name;
  }


  /**
   * English ordinal suffix for the day of the month, 2 characters, st, nd, rd or th.
   *
   * @return string
   */
  public function dayWithSuffix()
  {
    $suffix = $this->format('S');
    $day = $this->format('j');

    return $day . $suffix;
  }


  /**
   * Number of days in the given month, 28 through 31.
   *
   * @return string
   */
  public function daysInMonth()
  {
    $count = $this->format('t');

    return $count;
  }


  /**
   * A short textual representation of a month, three letters.
   *
   * @return string
   */
  public function nameOfMonthShort()
  {
    $name = $this->format('M');

    return $name;
  }


  /**
   * A full textual representation of a month.
   *
   * @return string
   */
  public function nameOfMonthLong()
  {
    $name = $this->format('F');

    return $name;
  }


  /**
   * 12-hour format of an hour AM or PM suffix.
   *
   * @return string
   */
  public function hourWithSuffix()
  {
    $hour = $this->format('gA');

    return $hour;
  }


  /**
   * ISO 8601 format date.
   *
   * @return string
   */
  public function isoDate()
  {
    $isoDate = $this->format('c');

    return $isoDate;
  }


  /************************************ MANIPULATE ************************************/

  /**
   * Adds an amount of days, months, years, hours, minutes and seconds.
   *
   * @param int $number
   * @param string $unit
   * @return $this
   */
  public function add($number, $unit)
  {
    $expression = $this->getIntervalExpression($number, $unit);
    $interval = \DateInterval::createFromDateString($expression);

    $this->dateTime->add($interval);

    return $this;
  }


  /************************************ INTERNAL ************************************/

  /**
   * @param mixed $dateTime
   * @throws InvalidArgumentException
   */
  private function validateDateTime($dateTime)
  {
    // invalid if...
    if (
      isset($dateTime) && // ...exists and...
      !($dateTime instanceof \DateTime) && // ...not \DateTime
      !is_string($dateTime) && // ...not string
      !is_int($dateTime) || // ...not integer
      (is_string($dateTime) && strlen($dateTime) === 0) || // ...not empty string
      (is_int($dateTime) && $dateTime < 0) // ...not negative integer
    ) {
      throw new InvalidArgumentException('Type of datetime is invalid.');
    }
  }


  /**
   * @param mixed $format
   * @throws InvalidArgumentException
   */
  private function validateFormat($format)
  {
    // invalid if...
    if (
      isset($format) && // ...exists and...
      !is_array($format) && // ...not array
      !is_string($format) || // ...not string
      (is_array($format) && count($format) === 0) || // ...not empty array
      (is_string($format) && strlen($format) === 0) // ...not empty string
    ) {
      throw new InvalidArgumentException('Type of format is invalid.');
    }
  }


  /**
   * @param mixed $timeZone
   * @throws InvalidArgumentException
   */
  private function validateTimeZone($timeZone)
  {
    // invalid if...
    if (
      isset($timeZone) && // ...exists and...
      !($timeZone instanceof \DateTimeZone) && // ...not \DateTimeZone
      !is_string($timeZone) || // ...not string
      (is_string($timeZone) && strlen($timeZone) === 0) // ...not empty string
    ) {
      throw new InvalidArgumentException('Type of timezone is invalid.');
    }
  }


  /**
   * Create DateTime
   *
   * @param string $dateTime
   * @param array|string|null $format
   * @param \DateTimeZone $timeZone
   * @return \DateTime
   * @throws ErrorException
   */
  private function fromFormat($dateTime, $format, $timeZone)
  {
    // without format
    if (!isset($format)) {
      $return = new \DateTime($dateTime, $timeZone);
    }
    // simple format
    elseif (is_string($format)) {
      $return = \DateTime::createFromFormat($format, $dateTime, $timeZone);
    }
    // walk all formats
    elseif (is_array($format)) {
      foreach ($format as $item) {
        $return = \DateTime::createFromFormat($item, $dateTime, $timeZone);

        // return first acceptable format
        if ($return instanceof \DateTime) {
          break;
        }
      }
    }

    if ($return === false) {
      throw new ErrorException('DateTime not create. Probably the wrong format.');
    }

    return $return;
  }

  /**
   * @param \DateTimeZone|string|null $timeZone
   * @return \DateTimeZone
   */
  private function createDateTimeZone($timeZone)
  {
    if (!isset($timeZone)) {
      $defaultTimeZone = date_default_timezone_get();
      $return = new \DateTimeZone($defaultTimeZone);
    }
    elseif (is_string($timeZone)) {
      $return = new \DateTimeZone($timeZone);
    }
    elseif ($timeZone instanceof \DateTimeZone) {
      $return = $timeZone;
    }

    return $return;
  }


  /**
   * @param int $number
   * @param string $unit
   * @return string
   * @throws InvalidArgumentException
   */
  private function getIntervalExpression($number, $unit)
  {
    $validUnits = array(
      'sec' => self::SECONDS,
      'second' => self::SECONDS,
      'seconds' => self::SECONDS,
      'min' => self::MINUTES,
      'minute' => self::MINUTES,
      'minutes' => self::MINUTES,
      'hour' => self::HOURS,
      'hours' => self::HOURS,
      'day' => self::DAYS,
      'days' => self::DAYS,
      'month' => self::MONTHS,
      'months' => self::MONTHS,
      'year' => self::YEARS,
      'years' => self::YEARS
    );

    if (!is_int($number)) {
      throw new InvalidArgumentException('The number must be integer.');
    }

    if (!array_key_exists($unit, $validUnits)) {
      $options = array_keys($validUnits);
      $options = join(', ', $options);
      throw new InvalidArgumentException('The unit must be from this options: ' . $options);
    }

    $unit = $validUnits[$unit];
    $expression = $number . ' ' . $unit;

    return $expression;
  }
}


class InvalidArgumentException extends \InvalidArgumentException {};

class ErrorException extends \ErrorException {};
