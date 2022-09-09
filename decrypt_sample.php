<?php

require_once 't_encrypt.php';

// please change this password with your own password
// and make sure it is not too short, and please keep it secret
// AND PLEASE MAKE SURE THIS PASSWORD IS THE SAME WITH THE PASSWORD IN 
// encrypt_sample.php
$masterpassword = "beautiful_system";

// decrypt sample
echo t_encrypt::setPassword($masterpassword)

        // you can put encrypted string here
        // ->encrypted_string("encrypted_string_here")
        // ->encrypted_string("M7J1nJ3i3o2pP5rBvvDVBtTTi4kqPbpmrpmNUWf5FtVi1gLULg8y4jqCvmniabpnmR1izphuXCEo/fgUtIgMmKZ9+O0aW6ev8Jff9SOwGkA=")

        // or you can put encrypted file here
        ->encrypted_string(__DIR__ . "/example/encrypted_image.txt")
        // ->encrypted_string(__DIR__ . "/example/encrypted_pdf.txt")
        // ->encrypted_string(__DIR__ . "/example/encrypted_string.txt")

        // and you can print as string  (PHP echo, image stream or pdf stream)
        // ->print();

        // or you can return the string (PHP Return)
        ->show();

        // or you can save as file
        // ->saveAsFile(__DIR__ . "/example/decrypted_image.jpg");
        // ->saveAsFile(__DIR__ . "/example/decrypted_text.txt");
        // ->saveAsFile(__DIR__ . "/example/decrypted_docs.pdf");