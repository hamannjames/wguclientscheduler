<?php

namespace Database\Enums;

enum MeetingTypes:string {
  case MEETANDGREET = 'Meet & Greet';
  case SUPPORT = 'Support';
  case SCHEDULING = 'Scheduling';
  case REPORTING = 'Reporting';
  case CONTRACT = 'Contract';
}