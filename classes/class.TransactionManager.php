<?php
class TransactionManager{
	
	private $_db;

	public function __construct($db)
	{
		$this->setDB($db);
	}
		
	/**
	 * getAllTransactionsFromUser
	 *
	 * @param  mixed $idUser
	 * @param  mixed $type
	 * @param  mixed $debut
	 * @param  mixed $limite
	 * @param  mixed $order
	 * @return void
	 */
	public function getAllTransactionsFromUser($idUser, $type = "", $debut = '', $limite = '', $order = ''){

        if(empty($idUser)){ return false; }
        $allTransactions= array();
		$allTransactions['result'] = array();
        $allTransactions['numRows'] = 0;

		$categorieManager = new CategorieManager($this->_db);
		$userManager = new UserManager($this->_db);

		$limit = "";
        if($debut !== '' && $limite !== ''){
            $limit = " LIMIT ".$debut.",".$limite;
        }

		$where = "";
		if($type !== ''){
			$where = " AND type = '".$type."' ";
		}

		$q = $this->_db->prepare("SELECT 
			t.* 
		FROM transactions AS t
		LEFT JOIN categories AS c ON c.id = t.idCategorie
		WHERE t.idUser = '".$idUser."' 
		".$where.$order.$limit);
		$q->execute();

		$transactions = $q->fetchAll(PDO::FETCH_ASSOC);

		$rows = "SELECT count(*) FROM transactions WHERE idUser = '".$idUser."' AND type = '".$type."'"; 
        $q = $this->_db->prepare($rows); 
        $q->execute(); 
        $allTransactions['numRows'] = $q->fetchColumn();

        foreach($transactions as $transaction){

			$transaction['categorie'] = $categorieManager->getCategorie($transaction['idCategorie']);
			$transaction['user'] = $userManager->getUserbyid($transaction['idUser']);

            $allTransactions['result'][] = new Transaction($transaction);

        }

		return $allTransactions;

	}
	
	/**
	 * getTransaction
	 *
	 * @param  mixed $idTransaction
	 * @return void
	 */
	public function getTransaction($idTransaction){

        if(empty($idTransaction)){ return false; }

        $categorieManager = new CategorieManager($this->_db);
		$userManager = new UserManager($this->_db);

        $q = $this->_db->prepare("SELECT * FROM transactions WHERE id = '".$idTransaction."'");
		$q->execute();

		$transaction = $q->fetch(PDO::FETCH_ASSOC);

        if($transaction){

			$transaction['categorie'] = $categorieManager->getCategorie($transaction['idCategorie']);
			$transaction['user'] = $userManager->getUserbyid($transaction['idUser']);

            return new Transaction($transaction);

		}	

		return $transaction;

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

	public function editTransaction(Transaction $transaction){

		$q = $this->_db->prepare("UPDATE transactions SET prix = :prix, idCategorie = :idCategorie, commentaire = :commentaire, dateAjout = :dateAjout WHERE id = :id");


		$q->bindValue(':prix', $transaction->getPrix());
		$q->bindValue(':idCategorie', $transaction->getCategorie()->getId());
		$q->bindValue(':commentaire', $transaction->getCommentaire());
		$q->bindValue(':id', $transaction->getId());
		$q->bindValue(':dateAjout', $transaction->getDateAjout());

		$q->execute();

	}

	public function recupDatasJsonForChartsDepensesRevenus($idUser, $dateDebut = "", $dateFin = ""){

		if(empty($idUser)){ return false; }

        $allTransactions= array();

		$categorieManager = new CategorieManager($this->_db);
		$userManager = new UserManager($this->_db);

		$where = "";
		if($dateDebut !== ''){ $where = " AND dateAjout >= '".$dateDebut."' "; }
		if($dateFin !== ''){ $where = " AND dateAjout <= '".$dateFin."' "; }

		$q = $this->_db->prepare("SELECT 
			t.* 
		FROM transactions AS t
		LEFT JOIN categories AS c ON c.id = t.idCategorie
		WHERE t.idUser = '".$idUser."' 
		".$where);
		$q->execute();

		$transactions = $q->fetchAll(PDO::FETCH_ASSOC);

        foreach($transactions as $transaction){

			if(!isset($allTransactions[date('d/m/Y', $transaction['dateAjout'])])){ 
				$allTransactions[date('d/m/Y', $transaction['dateAjout'])] = array();
				$allTransactions[date('d/m/Y', $transaction['dateAjout'])]['revenus'] = array();
				$allTransactions[date('d/m/Y', $transaction['dateAjout'])]['depenses'] = array();
			}
			if($transaction['type'] == 1){ 
				$allTransactions[date('d/m/Y', $transaction['dateAjout'])]['depenses'][] = ['categorie' => $categorieManager->getCategorie($transaction['idCategorie'])->getIntitule(), 'prix' => $transaction['prix']]; 
			}
			if($transaction['type'] == 2){ 
				$allTransactions[date('d/m/Y', $transaction['dateAjout'])]['revenus'][] = ['categorie' => $categorieManager->getCategorie($transaction['idCategorie'])->getIntitule(), 'prix' => $transaction['prix']]; 
			}

        }

		return $allTransactions;
	}

	// initialisation de la db
	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

}
?>