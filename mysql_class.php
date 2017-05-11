<?PHP
//require_once"languages/".$setting['default_language']."/errors.php";
##########################################
#        CETTE CLASSE SQL À ÉTÉ          #
# PROGRAMMÉE PAR L'UNIQUE ET FANTASTIQUE #
#               CGUIMONT                 #
#  UTILISATION PERMISE POUR L'AEACT      #
##########################################
class SqlClass
{
	var $server = "localhost";
	var $database = "cientsqc_site";
	var $username = "cientsqc_jt";
	var $password = "Chille69";
	var $debug = 0;
	var $show_errors = true;
	var $logfile = "./mysql.log";
	var $log = TRUE;
	var $auto_connect = TRUE;
	var $error_message = "";
	var $result;
	var $connection;
	var $builtquery;
	
###########################################
# Function:    SqlClass
# Parameters:  N/A
# Return Type: boolean
# Description: initiates the MySQL Handler
###########################################
	function SqlClass()
	{
		if ($this->auto_connect == True)
		{
			$this->OpenConnection();
		}
	}
###########################################
# Function:    OpenConnection
# Parameters:  N/A
# Return Type: boolean
# Description: Open the Mysql Connection
###########################################
	function OpenConnection()
	{
		Global $sql_error;
		$this->connection = @mysql_connect($this->server,$this->username,$this->password);
		if(!$this->connection || (!mysql_select_db($this->database,$this->connection)))
		{
			$this->Error($sql_error['cantconnect'] ,"");
			return false;
		}
		else
		{
			return true;
		}
	}
###########################################
# Function:    CloseConnection
# Parameters:  N/A
# Return Type: boolean
# Description: Close the Mysql Connection
###########################################
	function CloseConnection()
	{
		Global $sql_error;
		if(!mysql_close($this->connection))
		{
			$this->Error($sql_error['cantclose'], "");
			return false;
		}
		else
		{
			return true;
		}
	}

###########################################
# Function:    Query
# Parameters:  sql : string
# Return Type: boolean
# Description: Execute a any Query
###########################################
	function Query($sql)
	{
		Global $sql_error;
		if($sql == "" or $sql == NULL)
		{
			$this->Error($sql_error['nullquery'] ,$sql);
			return False;
		}
		if($this->debug == true)
		{
			echo $sql."<br>";
		}
		$result = mysql_query($sql,$this->connection);
		if(!$result)
		{
			$this->Error($sql_error['error'], $sql);
			return false;
		}
		else
		{
			$this->result = $result;
			return true;
		}
	}
###########################################
# Function:    Select
# Parameters:  N/A
# Return Type: boolean
# Description: Make a Select Query
###########################################
	function Select($sql)
	{
		return $this->Query($sql);
	}
###########################################
# Function:    FetchArray
# Parameters:  N/A
# Return Type: Array
# Description: Make a Fetch into an Array
###########################################
	function FetchArray()
	{
		return mysql_fetch_array($this->result);
	}
	
###########################################
# Function:    FetchArray
# Parameters:  N/A
# Return Type: Array
# Description: Make a Fetch into an Array
###########################################
	function FetchAssoc()
	{
		return mysql_fetch_assoc($this->result);
	}
###########################################
# Function:    FetchRow
# Parameters:  N/A
# Return Type: Array
# Description: Make a Fetch into an Array
###########################################
	function FetchRow()
	{
		return mysql_fetch_row($this->result);
	}
###########################################
# Function:    NumRow
# Parameters:  N/A
# Return Type: integer
# Description: Return the number of affected rows
###########################################
	function NumRow()
	{
		return mysql_num_rows($this->result);
	}
###########################################
# Function:    Update
# Parameters:  sql : string
# Return Type: boolean
# Description: Make a Update Query
###########################################
	function Update($sql)
	{
		return $this->Query($sql);
	}
###########################################
# Function:    Delete
# Parameters:  sql : string
# Return Type: boolean
# Description: Make a Delete Query
###########################################
	function Delete_data($sql)
	{
		return $this->Query($sql);
	}
###########################################
# Function:    Insert
# Parameters:  sql : string
# Return Type: boolean
# Description: Make a Insert Query
###########################################
	function Insert($sql)
	{
		return $this->Query($sql);
	}
###########################################
# Function:    Insert_id
# Parameters:  N/A
# Return Type: integer
# Description: Tell the inserted id
###########################################
	function Insert_id()
	{
		return mysql_insert_id($this->connection);
	}

###########################################
# Function:    Error
# Parameters:  sql : String
# Return Type: boolean
# Description: Error Message
###########################################
	function Error($error,$sql)
	{
		global $app_errors;
		Global $sql_error;
			if($this->show_errors == true)
			{
				$this->error_message = $sql_error['error']." : ".$sql."\n";
				$this->error_message .= $sql_error['error2']." : ".$error."\n";
				$this->error_message .= $sql_error['sqlerror']." : ".@mysql_error($this->connection)."\n";
				$this->error_message .= $sql_error['time'].":".date('d/m/Y H:i:s')."\n";
				
			}
			if($this->log == True)
			{
				$fd = fopen($this->logfile, "a");
				
				if(!$fd)
				{
					echo $sql_error['logfile'];
					exit;
				}
				
				$string = "[".$sql."][".mysql_error($this->connection)."][".$error."][".date('d/m/Y H:i:s')."]\n";
				if(!fwrite($fd, $string)) 
				{
    				echo($sql_error['logfilewrite']);
					exit;
  				}

			}
		//	$app_errors->add_error($this->error_message);
	}

}

?>