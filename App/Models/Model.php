<?php
namespace App\Models;

use App\Db\Db;
use PDO;
use PDOStatement;

class Model extends Db
{
    protected $table; // Nom de la table

    private $db; // Instance de la connexion à la base de données

    /**
     * Sélection de tous les enregistrements d'une table
     * @return array Tableau des enregistrements trouvés
     */
    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    /**
     * Sélection de plusieurs enregistrements suivant un tableau de critères
     * @param array $criteres Tableau de critères
     * @return array Tableau des enregistrements trouvés
     */
    public function findBy(array $criteres)
    {
        $champs = [];
        $valeurs = [];

        foreach ($criteres as $champ => $valeur) {
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        $liste_champs = implode(' AND ', $champs);

        return $this->requete("SELECT * FROM {$this->table} WHERE $liste_champs", $valeurs)->fetchAll();
    }

    /**
     * Sélection d'un enregistrement suivant son id
     * @param int $id Id de l'enregistrement
     * @return array Tableau contenant l'enregistrement trouvé
     */
    public function find(int $id)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE id = ?", [$id])->fetch();
    }

    /**
     * Insertion d'un enregistrement suivant un tableau de données
     * @param array $data Tableau de données à insérer
     * @return bool Succès ou échec de l'insertion
     */
    public function insert(array $data)
    {
        $champs = [];
        $inter = [];
        $valeurs = [];

        foreach ($data as $champ => $valeur) {
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);

        return $this->requete("INSERT INTO {$this->table} ({$liste_champs}) VALUES ({$liste_inter})", $valeurs);
    }

    /**
     * Mise à jour d'un enregistrement suivant son id et un tableau de données
     * @param int $id Id de l'enregistrement à mettre à jour
     * @param array $data Tableau de données à mettre à jour
     * @return bool Succès ou échec de la mise à jour
     */
    public function update(int $id, array $data)
    {
        $champs = [];
        $valeurs = [$id];

        foreach ($data as $champ => $valeur) {
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }

        $liste_champs = implode(', ', $champs);

        return $this->requete("UPDATE {$this->table} SET {$liste_champs} WHERE id = ?", $valeurs);
    }

    /**
     * Suppression d'un enregistrement suivant son id
     * @param int $id Id de l'enregistrement à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public function delete(int $id)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    /**
     * Méthode pour exécuter les requêtes SQL
     * @param string $sql Requête SQL à exécuter
     * @param array $attributs Attributs à ajouter à la requête
     * @return PDOStatement|false Résultat de la requête ou false en cas d'échec
     */
    public function requete(string $sql, array $attributs = [])
    {
        $this->db = Db::getInstance();

        if (!empty($attributs)) {
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            return $this->db->query($sql);
        }
    }

    /**
     * Méthode pour hydrater un objet avec des données
     * @param array $donnees Tableau de données à utiliser pour l'hydratation
     * @return $this Objet hydraté
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($this, $methode)) {
                $this->$methode($valeur);
            }
        }
        return $this;
    }
}


?>
