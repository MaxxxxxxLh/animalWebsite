<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $mail = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    $to = "adresse@tonsite.com"; // TODO: Remplacer par votre adresse email de réception
    $subject = "Nouveau message de contact de $prenom $nom";
    $body = "Nom: $nom\nPrénom: $prenom\nEmail: $mail\n\nMessage:\n$message";
    $headers = "From: $mail" . "\r\n" .
               "Reply-To: $mail" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $body, $headers)) {
        header("Location: /contact.php?success=1");
        exit();
    } else {
        header("Location: /contact.php?success=0");
        exit();
    }
}
?>
