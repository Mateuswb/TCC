<?php
    require_once dirname(__DIR__) . '/email/PHPMailer.php';
    require_once dirname(__DIR__) .'/email/Exception.php';
    require_once dirname(__DIR__) . '/email/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Email {
        
        public function enviarEmail($emailPaciente, $nomePaciente, $tituloEmail, $mensagem){
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'clinicamedhub2025@gmail.com';
            $mail->Password = 'euae xkol nfza cvfa';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom('clinicamedhub2025@gmail.com', 'Clínica MedHub');
            $mail->addAddress($emailPaciente, $nomePaciente);

            $mail->isHTML(true);
            $mail->Subject = $tituloEmail;
            $mail->Body    = $mensagem;

            $mail->send();
        }
    }

?>