<?php

class database_prepared
{
    public $host = '';
    public $user = '';
    public $password = '';
    public $db_name = '';
    private $link;
    private $result;
    private $message = '';

    function __construct()
    {
        $databaseUser = getenv('CLEARDBUSER');

        if (!empty($databaseUser)) {
            $this->host = getenv('CLEARDBHOST');
            $this->user = getenv('CLEARDBUSER');
            $this->password = getenv('CLEARDBPASSWORD');
            $this->db_name = getenv('CLEARDBNAME');
        }
        else if (file_exists('../config/settings.local.php')) {
            $settings = include "../config/settings.local.php";
            $connection_vars = $settings["mysql"]["default"];
            $this->host = $connection_vars["host"];
            $this->user = $connection_vars["user"];
            $this->password = $connection_vars["password"];
            $this->db_name = $connection_vars["db_name"];
        }


    }

    private function Open()
    {
        $this->link = mysqli_connect($this->host, $this->user, $this->password);
        mysqli_select_db($this->link, $this->db_name);

    }

    public function getMessage()
    {
        return $this->message;
    }

    function close($resultDB = "")
    {
        $this->result = $resultDB;

        if ($resultDB)
            mysqli_free_result($this->result);

        mysqli_close($this->link);
    }

    function closeResult($resultDB)
    {
        $this->result = $resultDB;

        mysqli_free_result($this->result);
    }

    function closeLink()
    {
        mysqli_close($this->link);
    }

    function __toString()
    {
        return "Host: " . $this->host . "<br />User: " . $this->user . "<br />Password: " . $this->password . "<br />DbName: " . $this->db_name;
    }

    public function getInsertID()
    {
        return mysql_insert_id($this->link);
    }


    function refValues($arr)
    {
        //Reference is required for PHP 5.3+
        if (strnatcmp(phpversion(), '5.3') >= 0) {
            $refs = array();
            foreach ($arr as $key => $value)
                $refs[$key] = & $arr[$key];
            return $refs;
        }
        return $arr;
    }

    /**
     * Escape harmful characters which might affect a query.
     *
     * @param string $str The string to escape.
     * @return string The escaped string.
     */
    public function escape($str)
    {
        return $this->_mysqli->real_escape_string($str);
    }

    /**
     * This method is needed for prepared statements. They require
     * the data type of the field to be bound with "i" s", etc.
     * This function takes the input, determines what type it is,
     * and then updates the param_type.
     *
     * @param mixed $item Input to determine the type.
     * @return string The joined parameter types.
     */
    private function _determineType($item)
    {
        switch (gettype($item)) {
            case 'NULL':
            case 'string':
                return 's';
                break;

            case 'integer':
                return 'i';
                break;

            case 'blob':
                return 'b';
                break;

            case 'double':
                return 'd';
                break;
        }
    }


    /**
     * Method attempts to prepare the SQL query
     * and throws an error if there was a problem.
     */
    protected function _prepareQuery()
    {
        if (!$stmt = $this->_mysqli->prepare($this->_query)) {
            trigger_error("Problem preparing query ($this->_query) " . $this->_mysqli->error, E_USER_ERROR);
        }
        return $stmt;
    }

    public function __destruct()
    {
        //$this->_mysqli->close();
    }


    // HOVED-GET-FUNKSJON
    function get($table, $getFieldsArray, $queryEnd = "", $inputArray = "", $mode = 0, $close = 0, $cache = 1)
    {
        $this->Open();
        if (!$this->link) {
            $this->message = 'Ingen forbindelse til databasen. Pr�v igjen senere.';
            return false;
        } else {
            $inputArray = getInputArrayType($inputArray);
            $retArray = array();
            // BYGGER QUERYET (ENTEN MED ALLE FELTENE SOM S�KES ETTER ELLER EN COUNT AV ANTALL TREFF)
            $query = "SELECT " . ($cache == 1 ? " SQL_CACHE " : " SQL_NO_CACHE ");
            $i = 0;
            foreach ($getFieldsArray as $entry) {
                $query .= ($i > 0 ? ", " : " ");
                if (is_array($entry)) {
                    $query .= $entry[0] . " as " . $entry[1];
                    $getFieldsArray[$i] = $entry[1];
                } else {
                    $query .= ($mode != 1 ? $entry : "count(" . $entry . ") as " . $entry . " ");
                }
                $i++;
            }

            $fieldNamesArray = $getFieldsArray;
            $query .= " FROM " . $table . " ";
            if ($queryEnd != "") {
                $query .= $queryEnd;
            }
            // HVIS IKKE MODUS 1, LEGGES SORTERING OG LIMIT TIL QUERY
            $i = 1;
            // PREPARERER QUERY FOR KJ�RING
            if ($stmt = mysqli_prepare($this->link, $query)) {
                /*     OPPRETTER ET ARRAY, BINDROW, MED ARGUMENTENE TIL BIND PARAM (1. ER STATEMENT, 2. ER STRINGEN
                MED TYPENE OG RESTEN ER ALLE VARIABLENE TIL QUERYET) OG RESULTBINDROW HVOR STATEMENTEN BINDES*/
                $bindRow[0] = $resultBindRow[0] = $stmt;
                $bindRow[1] = "";
                if ($inputArray != "" && count($inputArray) > 0 && is_array($inputArray)) {
                    foreach ($inputArray as $entry) {
                        $bindRow[1] .= $entry[1];
                        $bindRow[] = & $entry[0];
                    }
                }
                //echo $query;
                // LEGGER TIL RESULTATENE SOM SKAL HENTES I RESULTBINDROW
                for ($i = 0; $i < count($getFieldsArray); $i++) {
                    $resultBindRow[] = & $getFieldsArray[$i];
                }

                $params = array(); // Create the empty 0 index
                $i = 1;
                foreach ($getFieldsArray as $prop => $val) {
                    @$params[0] .= $this->_determineType($val);
                    array_push($params, $val);
                    //array_push($params, $bindParams[$prop]);
                }
                /*
                foreach($getFieldsArray as &$v)
                    $arg[] = &$v;
                $return = call_user_func_array(array($stmt, 'bind_param'), $arg);
                */
                /*
                print_r($params);print("<hr>");
                print_r($resultBindRow);print("<hr>");
                */
                //call_user_func_array(array($stmt, "bind_param"),$this->refValues($params));

                // BINDER PARAMETERE
                call_user_func_array("mysqli_stmt_bind_param", $this->refValues($bindRow));

                // KJ�RE QUERYET
                mysqli_stmt_execute($stmt);

                // BUFRER RESULTATET FOR � KUNNE TELLE TREFF
                mysqli_stmt_store_result($stmt);

                // BINDE RESULTAT-VARIABLENE
                call_user_func_array("mysqli_stmt_bind_result", $resultBindRow);

                // HENTE UT RESULTATENE
                $j = 0;
                #print_r($stmt);
                while (mysqli_stmt_fetch($stmt)) {
                    // HVIS MAN KUN KJ�RER EN OPPTELLING, RETURNERES TALLET.
                    if ($mode == 1) {
                        if ($close) {
                            $this->close();
                            //    $this->close($this->link);
                        }
                        return $getFieldsArray[0];
                    }


                    // OPPRETTER ET MIDLERTIDIG ARRAY HVOR ALLE TREFFENE LEGGES
                    $tmpArray = array();
                    foreach ($getFieldsArray as $k => $v) {
                        $tmpArray[$fieldNamesArray[$k]] = $v;
                    }
                    if ($mode == 2) {
                        if ($close) {
                            $this->close();
                        }
                        return $tmpArray;
                    }


                    // LEGGER TREFFENE TIL I RETUR-ARRAYET
                    array_push($retArray, $tmpArray);
                }

            } else {
                echo "Query feilet:<br>
                !Connection: \"$TypeOfConnection\"<br>";
                echo mysqli_error($this->link) . "<br>Query:<br>";
                echo $query . "<br>";
            }
            //$this->close();
            return $retArray;
        }
    }

    // HOVED-INSERT-FUNKSJON
    function insert($query, $inputArray, $id = "", $close = 0)
    {
        $this->Open();
        if (!$this->link) {
            $this->message = 'Ingen forbindelse til databasen. Pr�v igjen senere.';
            return false;
        } else {
            $inputArray = getInputArrayType($inputArray);
            // GJ�RE KLAR FOR INSERT
            if ($stmt = mysqli_prepare($this->link, $query)) {

                /*     OPPRETTER ET ARRAY, BINDROW, MED ARGUMENTENE TIL BIND PARAM (1. ER STATEMENT, 2. ER STRINGEN
                    MED TYPENE OG RESTEN ER ALLE VARIABLENE TIL QUERYET)*/
                $bindRow[0] = $stmt;
                $bindRow[1] = "";
                foreach ($inputArray as $entry) {
                    $bindRow[] = & $entry[0];
                    $bindRow[1] .= $entry[1];
                }

                // BINDE PARAMTERNE
                call_user_func_array("mysqli_stmt_bind_param", $this->refValues($bindRow));
                $res = mysqli_stmt_execute($stmt);
                if ($close)
                    $this->close();
                // KJ�RE QUERYET
                if (!$res) {
                    return false;
                }

                if ($id > 0)
                    return $id;
                else {
                    if ($id == -1)
                        return $res;
                    else
                        return mysqli_stmt_insert_id($stmt);
                }
            } else {
                echo "Query feilet: <br>Connection:<br>";
                echo mysqli_error($this->link) . "<br>Query:<br>";
                echo $query . "<br>";
            }

            if ($close)
                echo mysqli_error($this->link);
            return false;
        }
    }
}

## TMP. DENNE SKAL LEGGES OVER TIL SYSTEM-MAPPE N�R DENNE LAGES ##
function getInputArrayType($arr)
{
    if (is_array($arr)) {
        foreach ($arr as $entry) {
            if (!is_array($entry)) {
                $type = "s";
                if (is_numeric($entry)) {
                    if (strstr($entry, ".") > 0)
                        $type = "d";
                    elseif (strlen($entry) < 10)
                        $type = "i";
                }
                $retArray[] = array($entry, $type);
            } else
                $retArray[] = $entry;
        }
    }
    return $retArray;
}
