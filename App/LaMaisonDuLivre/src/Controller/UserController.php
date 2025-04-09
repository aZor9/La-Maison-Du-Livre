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
        $dsn = 'mysql:host=localhost;dbname=bdd_bliblio;charset=utf8';
        $username = 'root';
        $password = 'password';

        try {
            $pdo = new \PDO($dsn, $username, $password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);

            // Récupérer toutes les tables
            $tablesStmt = $pdo->query("SHOW TABLES");
            $tables = $tablesStmt->fetchAll(\PDO::FETCH_COLUMN);

            $databaseContent = [];

            foreach ($tables as $table) {
                $dataStmt = $pdo->query("SELECT * FROM `$table`");
                $rows = $dataStmt->fetchAll();

                $databaseContent[$table] = $rows;
            }

        } catch (\PDOException $e) {
            return new Response('Erreur de connexion à la base de données : ' . $e->getMessage());
        }

        return $this->render('user.html.twig', [
            'databaseContent' => $databaseContent
        ]);
    }
}
