<?php

class ContactController
{
    public function render()
    {
        include __DIR__ . '/../Views/pages/contact.php';
    }

    public function contact()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header('Location: /contact');
            exit();
        }

        $nom = htmlspecialchars($_POST['nom'] ?? '');
        $prenom = htmlspecialchars($_POST['prenom'] ?? '');
        $mail = filter_var($_POST['mail'] ?? '', FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars($_POST['message'] ?? '');

        if (empty($nom) || empty($prenom) || empty($mail) || empty($message)) {
            header("Location: /contact?success=0");
            exit();
        }

        $to = "adresse@tonsite.com"; 
        $subject = "Nouveau message de contact de $prenom $nom";
        $body = "Nom: $nom\nPrénom: $prenom\nEmail: $mail\n\nMessage:\n$message";
        $headers = "From: $mail\r\nReply-To: $mail\r\nX-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $body, $headers)) {
            header("Location: /contact?success=1");
            exit();
        } else {
            header("Location: /contact?success=0");
            exit();
        }
    }
}
?>
