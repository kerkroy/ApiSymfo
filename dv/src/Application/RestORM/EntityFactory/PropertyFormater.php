<?php

namespace Application\RestORM\EntityFactory;

use DateTime;

trait PropertyFormater
{

    /**
     * @param array $message
     * @param $entity
     * @return array
     */
    private function formatArgs(array $message, $entity, $entityName): array
    {
        array_filter($message, function($k) use ($entity) {
            return property_exists($entity, $k);
        }, ARRAY_FILTER_USE_KEY);

        foreach( $message as $argument => $value){
            if(isset($this->repositories[$entityName]['mapping'][$argument])){
                switch ( $this->repositories[$entityName]['mapping'][$argument]['type'] ){
                    case "text":
                    case "string":
                        $value = (string) $value;
                        if($this->repositories[$entityName]['mapping'][$argument]['length'] >= strlen($value)){
                            $message[$argument] = $value;
                        }
                        break;
                    case "date":
                    case "datetime":
                        if($this->validateDate($value)){
                            $message[$argument] = $this->validateDate($value);
                        }
                        break;
                    case "boolean":
                        $message[$argument] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                        break;
                    case "integer":
                        $value = (int)filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                        if($this->repositories[$entityName]['mapping'][$argument]['length'] >= floor(abs($value) / 2)){
                            $message[$argument] = $value;
                        }
                        $message[$argument] = $value;
                        break;
                    case "decimal":
                    case "float":
                        $message[$argument] = (double)filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                        break;
                    default:
                        $message[$argument] = $value;
                        break;
                }
            } else {
                unset($message[$argument]);
            }
        }

        return $message;
    }

    /**
     * @param $date
     * @return bool
     */
    function validateDate($date): bool
    {
        if(DateTime::createFromFormat('Y-m-d H:i:s', $date)){
            $format = 'Y-m-d H:i:s';
            $d = DateTime::createFromFormat($format, $date);
        } elseif (DateTime::createFromFormat('Y-m-d', $date)){
            $format = 'Y-m-d';
            $d = DateTime::createFromFormat($format, $date);
        } else {
            $d = false;
            $format = "";
        }
        return $d && $d->format($format) == $date;
    }

}