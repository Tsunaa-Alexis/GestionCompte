<?php
class CategorieManager{
	
	private $_db;

	public function __construct($db)
	{
		$this->setDB($db);
	}

	// initialisation de la db
	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
    
    /**
     * getAllCategories
     *
     * @return void
     */
    public function getAllCategoriesFromUser($idUser){

        if(empty($idUser)){ return false; }
        $userManager = new UserManager($this->_db);
        $allCat = array();

		$q= $this->_db->query("SELECT * FROM categories WHERE idUser = '".$idUser."'");

		$cat = $q->fetchAll(PDO::FETCH_ASSOC);

        foreach($cat as $categorie){
            $categorie['user'] = $userManager->getUserbyid($categorie['idUser']);
            $allCat[] = new Categorie($categorie);
        }

		return $allCat;

	}
    
    /**
     * getCategorie
     *
     * @param  mixed $idCategorie
     * @return void
     */
    public function getCategorie($idCategorie){

        if(empty($idCategorie)){ return false; }

        $userManager = new UserManager($this->_db);

        $q = $this->_db->query("SELECT * FROM categories WHERE id = '".$idCategorie."'");

		$categorie = $q->fetch(PDO::FETCH_ASSOC);

        $categorie['user'] = $userManager->getUserbyid($categorie['idUser']);


        if($categorie){
			return new Categorie($categorie);
		}	

		return $categorie;

    }
        
    /**
     * addCategorie
     *
     * @param  mixed $categorie
     * @return void
     */
    public function addCategorie(Categorie $categorie){
        
		$q = $this->_db->prepare('INSERT INTO categories(intitule, description, idUser) VALUES(:intitule, :description, :idUser)');
		$q->bindValue(':intitule', $categorie->getIntitule());
		$q->bindValue(':description', $categorie->getDescription());
		$q->bindValue(':idUser', $categorie->getUser()->getId());

		$retour = $q->execute();

		$categorie->hydrate([
			'id' => $this->_db->lastInsertId(),
        ]);

        return $retour;

	}
    
    /**
     * removeCategorie
     *
     * @param  mixed $idCategorie
     * @return void
     */
    public function removeCategorie($idCategorie){
        
        if(empty($idCategorie)){ return false; }

        $q = $this->_db->prepare('DELETE FROM categories WHERE id = :idCategorie');
        $q->bindValue(':idCategorie', $idCategorie);

        $retour = $q->execute();

        return $retour;

    }

}
?>