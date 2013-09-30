<?php

use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
  public function indexAction($year)
  {
    if ($this->is_leap_year($year)) {
      return new Response('Yep, '.$year.' is a leap year!');
    }

    return new Response('Nope, '.$year.' is not a leap year.');
  }

  protected function is_leap_year($year = null) {
    if (null === $year) {
      $year = date('Y');
    }

    return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
  }
}