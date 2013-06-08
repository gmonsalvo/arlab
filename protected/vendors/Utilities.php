<?php

class Utilities 
{
	public static function MoneyFormat($value,$decimals=2)
	{
		$value='$ '.number_format($value, $decimals,",",".");
		return $value;
	}
	
	public static function Unformat($value)
	{
		if ( strstr( $value, '$ ' ) ) $value = str_replace( '$ ', '', $value );
		if ( strstr( $value, '.' ) ) $value = str_replace( '.', '', $value );
		if ( strstr( $value, ',' ) ) $value = str_replace( ',', '.', $value );
		return $value;
	}
        
        public static function MysqlDateFormat($date)
        {
                $dia=substr($date,0,2);
                $mes=substr($date,3,2);
                $anio=substr($date,6,4);
               return $anio.'/'.$mes.'/'.$dia;
        }
        
        public static function ViewDateFormat($date)
        {
               $dia=substr($date,8,2);
               $mes=substr($date,5,2);
               $anio=substr($date,0,4);
               return $dia.'/'.$mes.'/'.$anio;
        }
        
        public static function RestarFechas($fechaInicio, $fechaFin)
        {
            $fechaInicio = str_replace("-", "", $fechaInicio);
            $fechaInicio = str_replace("/", "", $fechaInicio);
            $fechaFin = str_replace("-", "", $fechaFin);
            $fechaFin = str_replace("/", "", $fechaFin);

            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $fechaInicio, $arrayFechaInicio);
            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $fechaFin, $arrayFechaFin);

            $date1 = mktime(0, 0, 0, $arrayFechaInicio[2], $arrayFechaInicio[1], $arrayFechaInicio[3]);
            $date2 = mktime(0, 0, 0, $arrayFechaFin[2], $arrayFechaFin[1], $arrayFechaFin[3]);

            $dias = round(($date2 - $date1) / (60 * 60 * 24));
            return $dias;
        }

        
        
    public static function truncateFloat($number, $digitos) {
        $raiz = 10;
        $multiplicador = pow($raiz, $digitos);
        $resultado = ((int) ($number * $multiplicador)) / $multiplicador;
        return $resultado;
        //return number_format($resultado, $digitos);
    }

}