<?php

namespace Database\Enums;

enum FirstLevelDivisions:string {
  case NEW_ENGLAND = 'New England';
  case MIDDLE_ATLANTIC = "New Atlantic";
  case EAST_NORTH_CENTRAL = 'East North Central';
  case WEST_NORTH_CENTRAL = 'West North Central';
  case SOUTH_ATLANTIC = 'South Atlantic';
  case EAST_SOUTH_CENTRAL = 'East South Central';
  case WEST_SOUTH_CENTRAL = 'West South Central';
  case MOUNTAIN = 'Mountain';
  case PACIFIC = 'Pacific';
}