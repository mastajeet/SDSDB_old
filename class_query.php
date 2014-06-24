<?PHP
class req extends sqlclass
{
	var $champ = NULL;
	var $value = NULL;
	var $table = NULL;
	var $where = 1;
	var $order = NULL;
	var $action = NULL;
	var $req = NULL;
	
	function setchamp($String)
	{
		return $this->champ = $String;
	}
	
	function setvalue($String)
	{
		return $this->value = $String;
	}
	
	function setaction($String)
	{
		return $this->action = $String;
	}
	
	function setorder($String)
	{
		return $this->order = $String;
	}
	
	function setwhere($String)
	{
		return $this->where = $String;
	}
	
	function settable($String)
	{
		if($this->order==NULL)
		{
		$this->order = "ID".ucfirst($String)." ASC";
		}
		return $this->table = $String;
	}
	
	function buildquery()
	{
		SWITCH ($this->action)
		{
			case 'SELECT':
			{
			if($this->champ <> NULL OR $this->table <> NULL)
				{
				$this->req = "SELECT ".$this->champ." FROM ".$this->table." WHERE ".$this->where." ORDER BY ".$this->order;
				}
			return $this->req;
			BREAK;
			}
			
			case 'INSERT':
			{
			if($this->champ <> NULL AND $this->table <> NULL AND $this->value)
				{
				$this->req = "INSERT INTO `".$this->table."`(".$this->champ.") VALUES(".$this->value.")";
				}
			return $this->req;
			BREAK;
			}
		}
	}
	
	function execute()
	{
		if($this->req==NULL)
		{
			$this->buildquery();
		}
	
		SWITCH ($this->action)
		{
			case 'SELECT':
			{
				$this->select($this->req);
				break;
			}
			
			case 'INSERT':
			{
				$this->insert($this->req);
				break;
			}
		}
	}
	
###########################################
# Function:    FormToDB
# Parameters:  sql: String
# Return Type: boolean
# Description: Transforme les donnée d'un form vers une requete
# By Jean-Thomas Baillargeon
###########################################
	function formtodb($array,$Action,$Table)
	{
		$FormName = $array['postname'];
		$NameLenght = strlen($FormName);
		$champ2 = "";
		$values2 = "";
		foreach($array as $champ => $values)
		{
			if(strpos($champ, $FormName)===0)
			{
				$champ2 .= ", "."`".addslashes(substr($champ,$NameLenght))."`";
				$values2 .= ", "."'".addslashes($values)."'";
			}
		}
		$champ2 = substr($champ2, 2);
		$values2 = substr($values2, 2);
		$this->setaction($Action);
		$this->setchamp($champ2);
		$this->settable($Table);
		$this->setvalue($values2);
		$this->execute();
	}	
	
}