<?php
class Transaction {

    private $_id;
    private $_prix;
    private $_type;
    private $_categorie;
    private $_commentaire;
    private $_dateAjout;
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

    public function getPrix(){
        return $this->_prix;
    }

    public function getType(){
        return $this->_type;
    }

    public function getCategorie(){
        return $this->_categorie;
    }

    public function getCommentaire(){
        return $this->_commentaire;
    }

    public function getDateAjout(){
        return $this->_dateAjout;
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

    public function setPrix($prix){
		$prix = str_replace(',', '.', $prix);
		$prix = (float) $prix;
		if ($prix > 0)
		{
			$this->_prix = round($prix, 2);
		}	
	}

    public function setType($type){
		$type = (int) $type;
		if ($type > 0){ $this->_type = $type; }
	}

    public function setCategorie(Categorie $categorie){
		$this->_categorie = $categorie;
	}

    public function setCommentaire($commentaire){
		if(is_string($commentaire))
		{
			$this->_commentaire = $commentaire;
		}	
	}

    public function setDateAjout($dateAjout){
		$dateAjout = (int) $dateAjout;
		if ($dateAjout > 0)
		{
			$this->_dateAjout = $dateAjout;
		}	
	}

    public function setUser(User $user){
		$this->_user = $user;
	}

}
?>