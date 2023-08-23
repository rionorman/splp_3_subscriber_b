<?php

use Carbon\Carbon;

function formatTanggal($tanggal)
{
  if ($tanggal != null && $tanggal != "") {
    return date_format(date_create($tanggal), "d M Y");
  }
}

function selectForm($arrayList, $fieldid, $field, $name, $select, $required = 'Y', $classcustom = '', $customMessage = '')
{
  $dropdown = "<select class=\"form-control " . $classcustom . "\" id=\"" . $name . "\" name=\"" . $name . "\"";
  if ($required == 'Y') {
    if ($customMessage != '') {
      $dropdown .= fieldRequired($customMessage);
    } else {
      $dropdown .= fieldRequired("");
    }
  }
  $dropdown .= ">\n";
  $dropdown .= "<option value=\"\"></option>\n";
  foreach ($arrayList as $row) :
    $selected = "";
    if ($select == $row[$fieldid]) {
      $selected = " selected";
    }
    $dropdown .= "<option value=\"" . $row[$fieldid] . "\"" . $selected . ">" . $row[$field] . "</option>\n";
  endforeach;
  $dropdown .= "</select>\n";
  return $dropdown;
}

function fieldRequired($customMessage)
{
  $required = ' required autofocus oninvalid="this.setCustomValidity(\'' . $customMessage . '\')" oninput="setCustomValidity(\'\')"';
  return $required;
}

function generate_uuid()
{
  return sprintf(
    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0x0fff) | 0x4000,
    mt_rand(0, 0x3fff) | 0x8000,
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff)
  );
}

function generate_uuid_4()
{
  return sprintf(
    '%04x%04x',
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff)
  );
}

function code_id()
{
  return sprintf(
    '%04x-%04x',
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff)
  );
}

function diff_time($updated_at)
{
  $str = "Last updated ";
  $date1 = new DateTime();
  $date2 = new DateTime($updated_at);
  $difference = $date1->diff($date2);
  $diffInSeconds = $difference->s;
  $diffInMinutes = $difference->i;
  $diffInHours   = $difference->h;
  $diffInDays    = $difference->d;
  $diffInMonths  = $difference->m;
  $diffInYears   = $difference->y;

  if ($diffInYears > 0) {
    $str =  $str . " more than 1 year";
  } else if ($diffInMonths > 0) {
    $str =  $str . $diffInMonths . " months ";
  } else if ($diffInDays > 0) {
    $str =  $str . $diffInDays . " days ";
  } else if ($diffInHours > 0) {
    $str =  $str . $diffInHours . " hours ";
  } else if ($diffInMinutes > 0) {
    $str =  $str . $diffInMinutes . " minutes ";
  }

  return $str . " ago";
}

function get_date()
{
  $now = Carbon::now();
  $date = Carbon::parse($now)->toDateString();
  return $date;
}

function get_time()
{
  $now = Carbon::now()->format('H:i');
  $time = Carbon::parse($now)->toTimeString();
  return $time;
}

function format_time($time)
{
  return substr($time, 0, 5);
}

function add_time($start, $duration)
{
  $est = date("H:i", strtotime($start . " + " . $duration . " minutes"));
  return $est;
}

function toCurrency($amount, $currency = '', $fractionDigits = 0)
{
  $format = $currency . number_format($amount, $fractionDigits, ',', '.');
  return $format;
}
