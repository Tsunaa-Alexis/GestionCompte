<?php
class TransactionManager{
	
	private $_db;

	public function __construct($db)
	{
		$this->setDB($db);
	}
	
	/**
	 * getAllDepensesFromUser
	 *
	 * @param  mixed $idUser
	 * @return void
	 */
	public function getAllDepensesFromUser($idUser){

        if(empty($idUser)){ return false; }
        $allDepenses = array();
		$categorieManager = new CategorieManager($this->_db);
		$userManager = new UserManager($this->_db);

		$q = $this->_db->query("SELECT * FROM transactions WHERE idUser = '".$idUser."' AND type = 1");

		$depenses = $q->fetchAll(PDO::FETCH_ASSOC);

        foreach($depenses as $depense){
			$depense['categorie'] = $categorieManager->getCategorie($depense['idCategorie']);
			$depense['user'] = $userManager->getUserbyid($depense['idUser']);
            $allDepenses[] = new Transaction($depense);
        }

		return $allDepenses;

	}
	
	/**
	 * getAllRevenusFromUser
	 *
	 * @param  mixed $idUser
	 * @return void
	 */
	public function getAllRevenusFromUser($idUser){

        if(empty($idUser)){ return false; }
        $allRevenus= array();
		$categorieManager = new CategorieManager($this->_db);
		$userManager = new UserManager($this->_db);

		$q = $this->_db->query("SELECT * FROM transactions WHERE idUser = '".$idUser."' AND type = 2");

		$arrayRevenus = $q->fetchAll(PDO::FETCH_ASSOC);

        foreach($arrayRevenus as $revenus){
			$revenus['categorie'] = $categorieManager->getCategorie($revenus['idCategorie']);
			$revenus['user'] = $userManager->getUserbyid($revenus['idUser']);
            $allRevenus[] = new Transaction($revenus);
        }

		return $allRevenus;

	}
	
	/**
	 * addTransaction
	 *
	 * @param  mixed $transaction
	 * @return void
	 */
	public function addTransaction(Transaction $transaction){
        
		$q = $this->_db->prepare('INSERT INTO transactions(prix, type, idCategorie, commentaire, dateAjout, idUser) VALUES(:prix, :type, :idCategorie, :commentaire, :dateAjout, :idUser)');
		$q->bindValue(':prix', $transaction->getPrix());
		$q->bindValue(':type', $transaction->getType());
		$q->bindValue(':idCategorie', $transaction->getCategorie()->getId());
		$q->bindValue(':commentaire', $transaction->getCommentaire());
		$q->bindValue(':dateAjout', $transaction->getDateAjout());
		$q->bindValue(':idUser', $transaction->getUser()->getId());

		$retour = $q->execute();

        return $retour;

	}
	
	/**
	 * removeCategorie
	 *
	 * @param  mixed $idCategorie
	 * @return void
	 */
	public function removeTransaction($idTransaction){
        
        if(empty($idTransaction)){ return false; }

        $q = $this->_db->prepare('DELETE FROM transactions WHERE id = :idTransaction');
        $q->bindValue(':idTransaction', $idTransaction);

        $retour = $q->execute();

        return $retour;

    }

	public function updateAllTransactionWithidCategorie($idCategorie){

		if(empty($idCategorie)){ return false; }

        $q = $this->_db->prepare('UPDATE transactions SET idCategorie = 1 WHERE idCategorie = :idCategorie');
        $q->bindValue(':idCategorie', $idCategorie);

        $retour = $q->execute();

        return $retour;

	}

	// initialisation de la db
	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

}
?>