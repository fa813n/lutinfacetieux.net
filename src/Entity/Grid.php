<?php
namespace Workshop\Entity;


class Grid {
  private $type //calendar, board, single, set
  private $startDate;
  private $endDate;
  private $interval;
  private int $calendarId;
}