<?php

namespace danolez\lib\Res\Ini;

class Ini
{
  const SESSION_SAVE_PATH = "session.save_path";
  const SESSION_AUTO_START = "session.auto_start";
  const SESSION_USE_STRICT_MODE = "session.use_strict_mode";
  const SESSION_COOKIE_PATH = "session.cookie_path";
  const SESSION_COOKIE_SAME_SITE = "session.cookie_samesite";
  const SESSION_SID_LENGTH = "session.sid_length";
  const SESSION_SID_BITS_PER_CHAR = "session.sid_bits_per_character";
  const SESSION_UPLOAD_PROGRESS = "session.upload_progress.enabled";
  const SESSION_UPLOAD_PROGRESS_CLEAN_UP = "session.upload_progress.cleanup 	";
  const SESSION_UPLOAD_PROGRESS_NAME = "session.upload_progress.name";
  const SESSION_UPLOAD_PROGRESS_FREQUENCY = "session.upload_progress.freq";
  const SESSION_UPLOAD_PROGRESS_MIN_FREQ = "session.upload_progress.min_freq 	";
  const SESSION_LAZY_WRITE = "session.lazy_write";
  const SESSION_NAME = "session.name";
  //makes sure the browser only sends the session cookie in secure HTTPS requests.
  const SESSION_COOKIE_SECURE = "session.cookie_secure";
  //stops JavaScript from accessing the session cookie, preventing common XSS attacks.
  const SESSION_COOKIE_HTTP_ONLY = "session.cookie_httponly";
  //enabling this protects against Session Fixation attacks.
  const SESSION_USE_ONLY_COOOKIE = "session.use_only_cookies";
  //disabling this also helps protect against Session Fixation attacks.
  const SESSION_USE_TRANS_SID = "session.use_trans_sid";
  const SESSION_COOKIE_DOMAIN = "session.cookie_domain";
  const SESSION_USE_COOKIES = "session.use_cookies";
  const PROGRESS = "UPLOAD_PROGRESS";
  const ALLOW_URL_FOPEN  = "allow_url_fopen";
  const SHORT_OPEN_TAG = 'short_open_tag';

  const NAME = "WldVeFpUUTVOelZpTldSaU5HUmxZMkl3TVRGaFpURTRaR0ZtWkRRMFl6TTNOR1l5WWpZd016ZzJOR1EzT0RKbTc0ZWZiZmJkNGUwNDU2NDA2ZDIzMzFlZmJmYmRlZmJmYmQxODJiNDBlZmJmYmRlZmJmYmQ3ZGVmYmZiZDVmMjY3YmVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZGVmYmZiZDE3YzViZjM0NTQyZGVmYmZiZGVmYmZiZDUzZWZiZmJkNDE2ODU0MmQ2ZGVmYmZiZDM5NTFlZmJmYmRlZmJmYmRkMTgyZWZiZmJkZWZiZmJkZWZiZmJkZWZiZmJkMzJlZmJmYmRlZmJmYmQzMmVmYmZiZGVmYmZiZDZlZWZiZmJkMTYyZDM0NWRNR0kyTUdWbU4yTTJaamd5TTJSaE5tSXdOakV5T0RVMllXUmhaV1kwTlRkaU5EWXpOekkyWldOaFpUYzJPR0V4TVRnMU16azVOR05oWmpRMlpUUmhZVFpoT1RCaU16UTNZekF5TVRReU1HVXdZbU0xTlRGak0yTTRabUU1WWpBNA==";


  public static function set($key, $value)
  {
    ini_set($key, $value);
  }
  public static function sessions()
  {
    //ini_set(self::SESSION_NAME, self::NAME);
    //  ini_set(self::SESSION_SAVE_PATH, "/");    
    ini_set(self::SESSION_AUTO_START, "0");
    ini_set(self::SESSION_USE_STRICT_MODE, "1");
    ini_set(self::SESSION_COOKIE_PATH, "/");
    ini_set(self::SESSION_COOKIE_SAME_SITE, "Strict");
    ini_set(self::SESSION_COOKIE_SECURE, "1");
    ini_set(self::SESSION_COOKIE_HTTP_ONLY, "1");
    ini_set(self::SESSION_USE_ONLY_COOOKIE, "1"); //enabled
    ini_set(self::SESSION_USE_TRANS_SID, "0"); //disabled
    ini_set(self::SESSION_USE_COOKIES, "1");
    ini_set(self::SESSION_SID_LENGTH, "64");
    ini_set(self::SESSION_SID_BITS_PER_CHAR, "6");
    //  ini_set(self::SESSION_COOKIE_DOMAIN, "");
    ini_set(self::SESSION_UPLOAD_PROGRESS, "1");
    ini_set(self::SESSION_UPLOAD_PROGRESS_CLEAN_UP, "1");
    ini_set(self::SESSION_UPLOAD_PROGRESS_NAME, self::PROGRESS);
    ini_set(self::SESSION_UPLOAD_PROGRESS_FREQUENCY, "1%");
    ini_set(self::SESSION_UPLOAD_PROGRESS_MIN_FREQ, "1");
    ini_set(self::SESSION_LAZY_WRITE, "1");
  }

  public static function file()
  {
    ini_set(self::ALLOW_URL_FOPEN, "on");
  }
}
