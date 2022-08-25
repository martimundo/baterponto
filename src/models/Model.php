<?php


class Model
{

    protected static $tableName = "";
    protected static $columns = [];
    protected $values = [];


    function __construct($arr, $sanitize = true)
    {
        $this->laodFromArray($arr, $sanitize);
        

    }

    public function laodFromArray($arr, $sanitize = true)
    {

        if ($arr) {
            foreach ($arr as $key => $value) {
                $cleanValue = $value;
                if($sanitize && isset($cleanValue)){
                    $cleanValue =strip_tags(trim($cleanValue));
                    $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
                }
                $this->$key = $value;
                
            }
        }
    }

    //Metodos mágicos usam o __get ou __set
    public function __get($key)
    {
        return $this->values[$key];
       
    }

    
    public function __set($key, $value){
        
        $this->values[$key] = $value;
    }

    public function getValues(){
        
        return $this->values;
    }
    /**
     * @method PARA RETORNAR APENAS UM REGISTRO DO BANCO DE DADOS
     * @class
     * @result
     * @filters
     * @columns
     */

    public static function getOne($filters = [], $columns = '*')
    {
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $columns);
        return $result ? new $class($result->fetch_assoc()) : null;
    }

    /**
     * 
     * @method get all
     */
    public static function get($filters = [], $columns = '*')
    {
        $objects = [];

        $result = static::getResultSetFromSelect($filters, $columns);

        if ($result) {
            $class = get_called_class();

            while ($row =  $result->fetch_assoc()) {

                array_push($objects, new $class($row));
            }
        }
        return $objects;
    }
    
    /**
     * @method para criar consulta SQL no banco de dados
     * 
     */
    public static function getResultSetFromSelect($filters = [], $columns = '*')
    {
        $sql = "SELECT {$columns} FROM "
            . static::$tableName
            . static::getFilters($filters);
        $result = DataBase::getResultFromQuery($sql);

        if ($result->num_rows === 0) {
            return null;
        } else {
            return $result;
        }
    }

    public function insert()
    {

        $sql = "INSERT INTO " . static::$tableName . "(" . implode(",", static::$columns) . ") VALUES (";
        foreach (static::$columns as $col) {
            $sql .= static::getFormatedValue($this->$col) . ",";
        }
        
        $sql[strlen($sql) - 1] = ')';         
        $id = DataBase::executeSQL($sql);
        var_dump( $this->id = $id);
        $this->id = $id;
    }

    public function update(){

        $sql = "UPDATE " . static::$tableName . " SET ";
        foreach(static::$columns as $col){          
            

            $sql .= "{$col}" . static::getFormatedValue($this->$col) . ", " ;
        }
        
        $sql[strlen($sql) - 1] = ' ';
        $sql .= " WHERE id = {$this->id}"; 
        var_dump($sql);               
        DataBase::executeSQL($sql);
    }

    /**
     * @method for filters query sql
     */
    private static function getFilters($filters)
    {

        $sql = '';

        if (count($filters) > 0) {
            $sql .= " WHERE 1 = 1";
            foreach ($filters as $column => $value) {
                if($column == 'raw'){
                    $sql .=" AND {$value}";
                }
                $sql .= " AND ${column} =" . static::getFormatedValue($value);
            }
        }

        return $sql;
    }

    //Method format valus in string
    private static function getFormatedValue($value) {
        if(is_null($value)) {
           return "null";
        } else if(gettype($value) === 'string') {
           return "'${value}'";
        } else {
           return $value;
        }
     }
}
