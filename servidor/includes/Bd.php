<?php

class Bd {
	
	private static $conn = NULL;
	
	/**
	 * el ultimo sql generado
	 * @var string
	 */
	public static $sql = NULL;
	
	private static $lastPdoStatementExecuted = null;
	
	private static $connParams = [];
	
	private static function init($conn_params = []){
		static::$connParams = $conn_params = 
			array_merge([
                "dbname"   => Util::config("bd"), 
			    "username" => Util::config("bd_usuario"), 
			    "passwd"   => Util::config("bd_clave")], 
                $conn_params);

		if(self::$conn == NULL){
			 self::$conn = new PDO(
			   "mysql:host=localhost;dbname=".$conn_params["dbname"], 
			   $conn_params["username"], 
			   $conn_params["passwd"]
			   ,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
			 );
			 self::$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
	}
	
	public static function execute($prepared_sql, $values = []){
	    self::init();
	    static::$sql = $prepared_sql;
		static::$lastPdoStatementExecuted = $pdoStatement = self::$conn->prepare($prepared_sql);
		$pdoStatement->execute($values);
		return $pdoStatement;
	}
	
	public static function q($sql){
		self::init();
		return self::$conn->query($sql);
	}
	
	public static function select($table, $cols, $filter = NULL){
	    self::init();
	
	    $real_values = [];
	
	    if(is_array($cols))
	        $cols = implode(", ", $cols);
	
	    $sql = "SELECT {$cols} FROM {$table}";
	
	    if($filter !== NULL){
	        	
	        $fields_count = count($filter);
	
	        $sql .= " WHERE ";
	        	
	        $filter_count = count($filter);
	        $i = 0;
	        foreach($filter as $col => $value){
	            if(is_array($value)){
	                $value_count = count($value);
	                $sql .= $col . " IN (";
	                	
	                for($j = 0; $j < $value_count; $j++){
	                    $sql .= "?" . ($j+1 < $value_count ? ", " : NULL);
	                    $real_values[] = $value[$j];
	                }
	                $sql .= ") ";
	            }else{
	                $sql .= $col . " = ? ";
	                $real_values[] = $value;
	            }
	
	            $sql .= ($i + 1 < $filter_count ? " AND " : NULL);
	            $i++;
	        }
	    }
	
	    return static::execute($sql, $real_values);
	}

    /**
     * @param string $table : el
     * @param array $fields : nombre de las columnas
     * @param array $values : puede ser vector para una sola insercion o array multidimensional para varias filas
     *  el numero de values debe ser igual a $fields
     * @return multitype:string multitype:NULL
     */
    public static function insert($table, $fields, $values){
        self::init();

        !is_array(array_values($values)[0]) ? $values = [$values] : NULL;

        $sql = "INSERT INTO ".$table." (".(implode(", ", $fields)).") VALUES ";
        $values_count = count($values);
        $values_final = [];

        $i = 0;
        foreach($values as $values_row){
            $j = 0;
            $sql .= "(:".implode("{$i}, :", $fields)."{$i})".($i+1 < $values_count ? ", " : NULL);
            foreach($values_row as $value){
                $values_final[$fields[$j].$i] = $value;
                $j++;
            }
            $i++;
        }


        return static::execute($sql, $values_final);
    }

    /**
     * @param $table el nombre de la tabla a actualizar
     * @param $fields arreglo asociativo [columna => valor, ... ] a modificar
     * @param $condition arreglo asociativo para filtro
     * @return mixed
     */
    public static function update($table, $fields, $condition){
        self::init();

        $sql = "UPDATE {$table} SET ";
        $fields_final = [];
        $fields_count = count($fields);
        $i = 0;
        foreach($fields as $field_name => $value){
            $sql .= $field_name." = :{$field_name} " . ($i+1 < $fields_count ? ", " : "" );
            $fields_final[":".$field_name] = $value;
            $i++;
        }
        $sql .= " WHERE ";
        $i = 0;
        $condition_count = count($condition);
        foreach($condition as $field => $value){
            $sql .= $field . " = :c" . $field . ($i+1 < $condition_count ? " AND " : "");
            $fields_final[":c".$field] = $value;
            $i++;
        }

        return static::execute($sql, $fields_final);
    }
	
	public static function selectAll($table, $filter = NULL){
	    return self::select($table, "*", $filter);
	}
	
}

?>