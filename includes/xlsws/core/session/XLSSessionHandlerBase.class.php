<?php

    abstract class XLSSessionHandlerBase extends QBaseClass {
        // Garbage collection variables
        public static $CollectionDefaultProbability = 1;
        public static $CollectionDefaultDivisor = 100;
        public static $CollectionDefaultLifetime = 1440;
        public static $CollectionOverridePhp = true;

        // Event handlers array
        protected static $Events = array();
        protected $uxtLifetime;

        public static function RegisterEvent($strEventName, $mixEvent) {
          self::$Events[$strEventName][] = $mixEvent;
        }

        public static function TriggerEvent($strEventName, $arrParameters) {
            foreach (self::$Events[$strEventName] as $mixEvent)
                if (is_callable($mixEvent))
                    call_user_func($mixEvent, $arrParameters);
        }

        // Return a string to use as the session name
        public static function GetSessionName() {
            return 'XLSWS_' . substr(md5(__INCLUDES), 0, 7);
        }

        // Return the maximum time a session may exist, in seconds
        public static function GetSessionLifetime() {
            $intLifetime = ini_get('session.gc_maxlifetime');

            if (self::$CollectionOverridePhp || $intLifetime == 0)
                $intLifetime = self::$CollectionDefaultLifetime;

            return $intLifetime;
        }

        public static function GetGarbageCollection() {
            $intProbability = ini_get('session.gc_probability');
            $intDivisor = ini_get('session.gc_divisor');

            if (self::$CollectionOverridePhp || $intProbability == 0) {
                $intProbability = self::$CollectionDefaultProbability;
                $intDivisor = self::$CollectionDefaultDivisor;
            }

            if (!(rand(0, $intDivisor) < $intProbability)) return false;
            return true;
        }

        public function __construct() {
            // Ensure that session gets saved prior to PHP closing. 
            register_shutdown_function('session_write_close');
        }

    }
