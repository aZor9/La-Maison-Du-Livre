<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function index(): Response
    {
        // Connexion à la base de données via PDO
        $dsn = 'mysql:host=localhost;dbname=bdd_bliblio;charset=utf8';
        $username = 'root';  // Remplace par ton utilisateur MySQL
        $password = 'password';  // Remplace par ton mot de passe MySQL
        
        try {
            $pdo = new \PDO($dsn, $username, $password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);

            // Requête SQL pour récupérer les utilisateurs (table "users")
            $stmt = $pdo->query("SELECT * FROM users");
            $users = $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            return new Response('Erreur de connexion à la base de données : ' . $e->getMessage());
        }

        // Retourne un affichage basique avec print_r pour voir les résultats
        return new Response('<pre>' . print_r($users, true) . '</pre>');
    }
}
