<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $services = isset($_POST["services"]) ? $_POST["services"] : [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Compile the list of services
    $services_list = implode(", ", $services);

    // Prepare the email content
    $to = "stalind3@gmail.com";  // Replace with your email address
    $subject = "New Work Request from $name";
    $message = "
    <html>
    <head>
        <title>New Work Request</title>
    </head>
    <body>
        <p>You have received a new work request.</p>
        <table>
            <tr>
                <th>Name</th>
                <td>$name</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>$email</td>
            </tr>
            <tr>
                <th>Services</th>
                <td>$services_list</td>
            </tr>
        </table>
    </body>
    </html>
    ";

    // To send HTML mail, the Content-type header must be set
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Additional headers
    $headers .= "From: <$email>" . "\r\n";

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you, $name. Your request has been sent.";
    } else {
        echo "There was an error sending your request. Please try again later.";
    }
} else {
    echo "Invalid request method.";
}
?>
