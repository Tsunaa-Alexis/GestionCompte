<?php
class UserManager{
	
	private $_db;

	public function __construct($db)
	{
		$this->setDB($db);
	}

	// ajouter un user
	public function add(User $user)
	{
        
		$q = $this->_db->prepare('INSERT INTO users(nom,prenom,type,mail,mdp,numTel) VALUES(:nom, :prenom, :type, :mail, :mdp, :numTel)');
		$q->bindValue(':nom', $user->getNom());
		$q->bindValue(':prenom', $user->getPrenom());
		$q->bindValue(':type', $user->getType());
		$q->bindValue(':mail', $user->getMail());
		$q->bindValue(':mdp', $user->getMdp());
		$q->bindValue(':numTel', $user->getNumTel());

		$q->execute();

		$user->hydrate([
			'id' => $this->_db->lastInsertId(),
        ]);

	}

	// récupérer les informations en fonction de l'email
	public function getUser($sonMail)
	{
		$q= $this->_db->query('SELECT  nom, prenom, mail, mdp, type, numTel, id FROM users WHERE mail = "'. $sonMail .'"');
		$userInfo = $q->fetch(PDO::FETCH_ASSOC);

		if($userInfo){
			return new User($userInfo);
		}	

		return $userInfo;

	}

	// récupérer les informations d'un utilisateurs à partir de sont id
	public function getUserbyid($id)
	{
		$q= $this->_db->query('SELECT  nom, prenom, mail, mdp, type, numTel, id FROM users WHERE id = "'. $id .'"');
		$userInfo = $q->fetch(PDO::FETCH_ASSOC);

		if ($userInfo){
			return new User($userInfo);
		}	

		return $userInfo;

	}

	// modifier les information d'un user
	public function edit(User $user)
	{
		$q = $this->_db->prepare("UPDATE users SET nom = :nom, prenom = :prenom, mail = :mail, numTel = :numTel WHERE id = :id");


		$q->bindValue(':nom', $user->getNom());
		$q->bindValue(':prenom', $user->getPrenom());
		$q->bindValue(':mail', $user->getMail());
		$q->bindValue(':numTel', $user->getNumTel());
		$q->bindValue(':id', $user->getId());

		$q->execute();
	}

	// compter le nombre d'utilisateurs
	public function count()
	{
		return $this->_db->query("SELECT COUNT(*) FROM users")->fetchColumn();
	}

	// vérifier qu'un email est déjà utilisé
	public function mailExists($mailUser){

		$q = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE mail = :mail');
		$q->execute([':mail'=> $mailUser]);
		return (bool) $q->fetchColumn();

	}

	// initialisation de la db
	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

}
?>