<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController
{
    public function render()
    {
        include __DIR__ . '/../Views/pages/contact.php';
    }

    private function sendContactEmail(string $fromEmail, string $fromName, string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'maximilien.lhote@gmail.com';
            $mail->Password = 'vfau elsc tshx rwed'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('maximilien.lhote@gmail.com', 'Animaux Fascinants');
            $mail->addAddress('maximilien.lhote@gmail.com');
            $mail->addReplyTo($fromEmail, $fromName);

            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mail error (contact email): ' . $mail->ErrorInfo);
            return false;
        }
    }

    private function sendAutoReplyEmail(string $toEmail, string $toName): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'maximilien.lhote@gmail.com';
            $mail->Password = 'vfau elsc tshx rwed'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('maximilien.lhote@gmail.com', 'Animaux Fascinants');
            $mail->addAddress($toEmail, $toName);

            $mail->Subject = "Merci de nous avoir contactés";
            $mail->Body = "Bonjour $toName,\n\nMerci de nous avoir contactés. Nous avons bien reçu votre message et nous vous répondrons dans les plus brefs délais.\n\nCordialement,\nL'équipe Animaux Fascinants";

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mail error (auto reply): ' . $mail->ErrorInfo);
            return false;
        }
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

        $subject = "Nouveau message de contact de $prenom $nom";
        $body = "Nom: $nom\nPrénom: $prenom\nEmail: $mail\n\nMessage:\n$message";

        $success = $this->sendContactEmail($mail, "$prenom $nom", $subject, $body);

        if ($success) {
            $this->sendAutoReplyEmail($mail, "$prenom $nom");
        }

        if ($success) {
            header("Location: /contact?success=1");
            exit();
        } else {
            header("Location: /contact?success=0");
            exit();
        }
    }
}
