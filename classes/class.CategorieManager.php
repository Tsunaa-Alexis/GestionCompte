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
    public function getAllCategoriesFromUser($idUser, $debut = '', $limite = '', $order = ''){

        if(empty($idUser)){ return false; }
        $userManager = new UserManager($this->_db);
        $allCat = array();
        $allCat['result'] = array();
        $allCat['numRows'] = 0;

        $limit = "";
        if($debut !== '' && $limite !== ''){
            $limit = " LIMIT ".$debut.",".$limite;
        }

		$q = $this->_db->prepare("SELECT * FROM categories WHERE idUser = '".$idUser."' ".$order.$limit);
        $q->execute();
		$cat = $q->fetchAll(PDO::FETCH_ASSOC);

        $rows = "SELECT count(*) FROM categories WHERE idUser = '".$idUser."'"; 
        $q = $this->_db->prepare($rows); 
        $q->execute(); 
        $allCat['numRows'] = $q->fetchColumn();

        foreach($cat as $categorie){
            $categorie['user'] = $userManager->getUserbyid($categorie['idUser']);
            $allCat['result'][] = new Categorie($categorie);
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

        $q = $this->_db->prepare("SELECT * FROM categories WHERE id = '".$idCategorie."'");
        $q->execute();

		$categorie = $q->fetch(PDO::FETCH_ASSOC);

        if($categorie){
            $categorie['user'] = $userManager->getUserbyid($categorie['idUser']);
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
    public function removeCategorie($idCategorie, $idUser){
        //réattribué à toutes les transactions une nouvelle catégorie
        if(empty($idCategorie)){ return false; }
        $transactionManager = new TransactionManager($this->_db);

        $q = $this->_db->prepare('DELETE FROM categories WHERE id = :idCategorie AND idUser = :idUser');
        $q->bindValue(':idCategorie', $idCategorie);
        $q->bindValue(':idUser', $idUser);

        $retour = $q->execute();

        if($retour === true){
            $retour = $transactionManager->updateAllTransactionWithidCategorie($idCategorie);
        }

        return $retour;

    }

    public function editCategorie(Categorie $categorie){

		$q = $this->_db->prepare("UPDATE categories SET intitule = :intitule, description = :description WHERE id = :id");


		$q->bindValue(':intitule', $categorie->getIntitule());
		$q->bindValue(':description', $categorie->getDescription());
		$q->bindValue(':id', $categorie->getId());

		$q->execute();

	}

}
?>