<?php
class Categorie {

    private $_id;
    private $_intitule;
    private $_description;
    private $_user;

    public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees)
	{
		foreach($donnees as $key => $value) {

			$method = 'set'.ucfirst($key);

			if(method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}

    public function getId(){
        return $this->_id;
    }

    public function getIntitule(){
        return $this->_intitule;
    }

    public function getDescription(){
        return $this->_description;
    }

    public function getUser(){
        return $this->_user;
    }

    // Setters

	public function setId($id){
		$id = (int) $id;
		if($id > 0)
		{
			$this->_id = $id;
		}	
	}

    public function setIntitule($intitule){
		if(is_string($intitule))
		{
			$this->_intitule = $intitule;
		}	
	}

    public function setDescription($description){
		if(is_string($description))
		{
			$this->_description = $description;
		}	
	}

    public function setUser(User $user){
        $this->_user = $user;
    }

}
?>