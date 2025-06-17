<?php
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Invalid request.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check honeypot field
    if (!empty($_POST['email'])) {
        $response = ['success' => false, 'message' => 'Spam detected.'];
        echo json_encode($response);
        exit;
    }

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['e-input']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $to = "sales@kilzico.com";
    $emailSubject = "Contact Form Submission: $subject";
    $emailBody = "Name: $name\n";
    $emailBody .= "Email: $email\n";
    $emailBody .= "Subject: $subject\n";
    $emailBody .= "Message:\n$message\n";

    $headers = "From: $email\n";
    $headers .= "Reply-To: $email\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\n";

    if (mail($to, $emailSubject, $emailBody, $headers)) {
        $response = ['success' => true, 'message' => 'Thanks for reaching out! Your message has been successfully sent. We\'ll get back to you shortly.'];
    } else {
        $response = ['success' => false, 'message' => 'There was a problem sending your message. Please try again.'];
    }
}

echo json_encode($response);
?>
