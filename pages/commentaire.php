<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

require_once 'classes/Comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    if (!empty($comment)) {
        $commentObj = new Comment();
        $commentObj->addComment($comment, $_SESSION['user_id']);
        header("Location: livre-or.php");
        exit();
    } else {
        $error = "Le commentaire ne peut pas être vide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Commentaire</title>
    <link rel="stylesheet" href="../assets/style/styles.css">
    <link rel="stylesheet" href="../assets/style/commentaire.css">
</head>
<style>
       * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lucida Calligraphy', cursive;
        }

        /* Style du corps de la page */
        body {
            font-family: 'Snell Roundhand', cursive;
            background: url('../assets/photos/photolivret.png') no-repeat center center;
            background-size: cover;
            text-align: center;
            padding-top: 150px;
            color: white;
            min-height: 100vh;
            background-color: #c8d3c7;
        }

        /* Conteneur principal */
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: rgba(151, 67, 18, 0.6);
            border-radius: 10px;
        }

        /* Titre principal */
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(31, 32, 29, 0.7);
        }

        /* Formulaire */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        /* Champ de texte */
        textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #f1dddd;
            width: 80%;
            height: 100px;
            font-size: 1rem;
            resize: none;
        }

        /* Bouton de soumission */
        button {
            background-color: #101005;
            color: rgb(231, 231, 224);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color:rgb(252, 202, 202);
        }

        /* Message d'erreur */
        .error {
            color: #ff4d4d;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            h1 {
                font-size: 2.5rem;
            }

            textarea {
                width: 90%;
                height: 80px;
            }

            button {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 2rem;
            }

            textarea {
                width: 100%;
                height: 60px;
            }

            button {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }
</style>
<body>
    <div class="container">
        <h1>Ajouter un Commentaire</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <textarea name="comment" placeholder="Votre commentaire..." required></textarea>
            <button type="submit">Poster</button>
        </form>
    </div>
</body>
</html>