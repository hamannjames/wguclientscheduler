<?php

namespace Database\Enums;

use Database\Enums\FirstLevelDivisions;

enum States:string {
  case AL = "Alabama";
  case AK = "Alaska";  
  case AZ = "Arizona";  
  case AR = "Arkansas";  
  case CA = "California";  
  case CO = "Colorado";  
  case CT = "Connecticut";  
  case DE = "Delaware";  
  case DC = "District Of Columbia"; 
  case FL = "Florida";  
  case GA = "Georgia";  
  case HI = "Hawaii";  
  case ID = "Idaho";  
  case IL = "Illinois";
  case IN = "Indiana";  
  case IA = "Iowa";  
  case KS = "Kansas";  
  case KY = "Kentucky";  
  case LA = "Louisiana";
  case ME = "Maine";  
  case MD = "Maryland";
  case MA = "Massachusetts";  
  case MI = "Michigan";  
  case MN = "Minnesota";  
  case MS = "Mississippi";  
  case MO = "Missouri";  
  case MT = "Montana";
  case NE = "Nebraska";
  case NV = "Nevada";
  case NH = "New Hampshire";
  case NJ = "New Jersey";
  case NM = "New Mexico";
  case NY = "New York";
  case NC = "North Carolina";
  case ND = "North Dakota";
  case OH = "Ohio";  
  case OK = "Oklahoma";  
  case OR = "Oregon";  
  case PA = "Pennsylvania";  
  case RI = "Rhode Island";  
  case SC = "South Carolina";  
  case SD = "South Dakota";
  case TN = "Tennessee";  
  case TX = "Texas";  
  case UT = "Utah";  
  case VT = "Vermont";  
  case VA = "Virginia";  
  case WA = "Washington";  
  case WV = "West Virginia";  
  case WI = "Wisconsin";  
  case WY = "Wyoming";

  public function firstLevelDivision(): FirstLevelDivisions
  {
    return match($this) {
      States::CT, States::ME, States::MA, States::NH, States::RI, States::VT => FirstLevelDivisions::NEW_ENGLAND,
      States::NJ, States::NY, States::PA => FirstLevelDivisions::MIDDLE_ATLANTIC,
      States::IL, States::IN, States::MI, States::OH, States::WI => FirstLevelDivisions::EAST_NORTH_CENTRAL,
      States::IA, States::KS, States::MN, States::MO, States::NE, States::ND, States::SD => FirstLevelDivisions::WEST_NORTH_CENTRAL,
      States::DE, States::FL, States::GA, States::MD, States::NC, States::SC, States::VA, States::DC, States::WV => FirstLevelDivisions::SOUTH_ATLANTIC,
      States::AL, States::KY, States::MS, States::TN => FirstLevelDivisions::EAST_SOUTH_CENTRAL,
      States::AR, States::LA, States::OK, States::TX => FirstLevelDivisions::WEST_SOUTH_CENTRAL,
      States::AZ, States::CO, States::ID, States::MT, States::NV, States::NM, States::UT, States::WY => FirstLevelDivisions::MOUNTAIN,
      States::AK, States::CA, States::HI, States::OR, States::WA => FirstLevelDivisions::PACIFIC
    };
  }
}