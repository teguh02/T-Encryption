<?php

require_once 't_encrypt.php';

// please change this password with your own password
// and make sure it is not too short, and please keep it secret
$masterpassword = "beautiful_system";

// encrypt sample
return t_encrypt::setPassword($masterpassword)

        // You can set input as string
        // ->input('mendoan')

        // or you can set input as POST file
        // ->input($_FILES['file'])

        // or you can set input as file path
        // ->input("/Users/mymac/Downloads/DSC_0301a.jpeg")
        ->input("/Users/mymac/Downloads/Resume_Teguh Rijanandi.docx.pdf")

        // and you can print as string  (PHP echo)
        // ->print();

        // or you can return the string (PHP Return)
        // ->show();

        // or you can save as file
        ->saveAsFile(__DIR__ . "/example/encrypted_pdf.txt");
        // ->saveAsFile(__DIR__ . "/example/encrypted_image.txt");
        // ->saveAsFile(__DIR__ . "/example/encrypted_string.txt");
        