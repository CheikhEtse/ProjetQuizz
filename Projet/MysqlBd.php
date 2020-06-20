<?php
 abstract class MysqlBd{

   //$pdo=null connexion fermée
   //$pdo contient la chaine de connexion
    
   private $pdo=null;
   //Classe d'encapsulation des données rrecupérer lors d'une requete select
   protected $className;

  
    private function getConnexion(){
        try{
            //scenario nominal
            if ($this->pdo==null){
            $this->pdo=new PDO('mysql:host=localhost;dbname=projet_connexion', 'root','');
            //Activer les erreurs

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            //Activer le mode recuperation sous la forme d'un tableau associatif
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            
            }

        }catch(Exception $ex ){
            //scenario Exception
            die("Verifier les Parametres de Connexion".$ex->getMessage());

        }
    
      
       
       

    }

    private function CloseConnexion(){
        if( $this->pdo!=null){
            $this->pdo=null;
        }


    }

    public function ExecuteSelect($sql){
        $this->getConnexion();
        $query=$this->pdo->query($sql);
        $data=[];

        while($row=$query->fetch()){
            $data[]=new $this->className($row);

        }
        $this->CloseConnexion();
        return $data;

    }
 

    public function ExecuteUpdate($sql){
    $this->getConnexion();
    //$nbreLigne représente le nombre de ligne modifié par la requete
    $nbreLigne = $this->pdo->exec($sql);
    $this->CloseConnexion();
    return $nbreLigne;

    }
    public abstract function create($data);
    public abstract function update($data);
    public abstract function delete($id); 
    public abstract function findAll();
    public abstract function findByid($id); 






}


?>