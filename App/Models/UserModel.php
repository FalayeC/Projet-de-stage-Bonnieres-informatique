<?php

namespace App\Models;

use PDO;
use App\Db\Db;

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    // Méthodes existantes pour la gestion des utilisateurs
    public function findAll()
    {
        $stmt = $this->db->query("SELECT u.id_user, r.role_name, c.civility_name, u.user_name, u.user_surname 
                                  FROM bi_users u 
                                  JOIN bi_roles r ON u.id_role = r.id_role 
                                  JOIN bi_civility c ON u.id_civility = c.id_civility");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT u.id_user, u.user_name, u.user_surname, u.user_email, u.id_civility, u.id_role, r.role_name, c.civility_name 
                                    FROM bi_users u 
                                    JOIN bi_roles r ON u.id_role = r.id_role 
                                    JOIN bi_civility c ON u.id_civility = c.id_civility 
                                    WHERE u.id_user = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO bi_users (user_name, user_surname, user_email, user_password, id_civility, id_role) 
                                    VALUES (:user_name, :user_surname, :user_email, :user_password, :id_civility, :id_role)");
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $query = "UPDATE bi_users SET user_name = :user_name, user_surname = :user_surname, user_email = :user_email, id_civility = :id_civility, id_role = :id_role";
        if (isset($data['user_password'])) {
            $query .= ", user_password = :user_password";
        }
        $query .= " WHERE id_user = :id";

        $stmt = $this->db->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM bi_users WHERE id_user = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getCivility()
    {
        $stmt = $this->db->query("SELECT id_civility, civility_name FROM bi_civility");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoles()
    {
        $stmt = $this->db->query("SELECT id_role, role_name FROM bi_roles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nouvelles méthodes pour les horaires et les images d'accueil
    public function findAllHoraires()
    {
        $stmt = $this->db->query("SELECT * FROM bi_horaire");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findHoraire($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bi_horaire WHERE id_horaire = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateHoraireDescription($id, $description)
    {
        $stmt = $this->db->prepare("UPDATE bi_horaire SET horaire_description = :description WHERE id_horaire = :id");
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function findAllAccueilImages()
    {
        $stmt = $this->db->query("SELECT * FROM bi_accueil");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAccueilImage($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bi_accueil WHERE id_accueil = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateAccueilImage($id, $imageName)
    {
        $stmt = $this->db->prepare("UPDATE bi_accueil SET accueil_image = :image_name WHERE id_accueil = :id");
        $stmt->bindParam(':image_name', $imageName);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Nouvelles méthodes pour les modèles d'iPhone, de Samsung et de HP
    public function findAllIPhoneModels()
    {
        $stmt = $this->db->query("SELECT * FROM bi_iphone");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateIPhone($id, $modele, $prix)
    {
        $stmt = $this->db->prepare("UPDATE bi_iphone SET iphone_modele = ?, iphone_prix = ? WHERE id_iphone = ?");
        return $stmt->execute([$modele, $prix, $id]);
    }

    public function findAllSamsungModels()
    {
        $stmt = $this->db->query("SELECT * FROM bi_samsung");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateSamsung($id, $modele, $prix)
    {
        $stmt = $this->db->prepare("UPDATE bi_samsung SET samsung_modele = ?, samsung_prix = ? WHERE id_samsung = ?");
        return $stmt->execute([$modele, $prix, $id]);
    }

    public function findAllHPModels()
    {
        $stmt = $this->db->query("SELECT * FROM bi_hp");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateHP($id, $modele, $prix)
    {
        $stmt = $this->db->prepare("UPDATE bi_hp SET hp_modele = ?, hp_prix = ? WHERE id_hp = ?");
        return $stmt->execute([$modele, $prix, $id]);
    }

    public function findIPhoneById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bi_iphone WHERE id_iphone = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findSamsungById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bi_samsung WHERE id_samsung = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findHPById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bi_hp WHERE id_hp = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
?>
