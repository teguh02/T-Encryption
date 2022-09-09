# PHP T-Encryption  

T-Encryption is a single file simple encryption class for PHP

[![GitHub issues](https://img.shields.io/github/issues/teguh02/T-Encryption)](https://github.com/teguh02/T-Encryption/issues) [![GitHub forks](https://img.shields.io/github/forks/teguh02/T-Encryption)](https://github.com/teguh02/T-Encryption/network) [![GitHub stars](https://img.shields.io/github/stars/teguh02/T-Encryption)](https://github.com/teguh02/T-Encryption/stargazers) [![GitHub license](https://img.shields.io/github/license/teguh02/T-Encryption)](https://github.com/teguh02/T-Encryption) 

If you use this encryption class, you can encrypt such as
1. String
2. File (Image, PDF)
 
I coded this encryption classes because so many a news about Indonesian government's data are stolen by hackers and leak to the internet. I hope you enjoy this class. coded with love by Teguh Rijanandi for everyone and if you see any error or bug you can feel free to open new issue or you can collaborate with me use pull request. Thanks

Note :
- WE NEVER STORE ANY DATA / FILE FROM YOU
- T means is Teguh (from my first letter name)

# Tutorial
Before we start, please keep master password in encrypt and decrypt step are same and if the master password are not same, the decrypt process results is null like this
[![Pdytu2.md.png](https://iili.io/Pdytu2.md.png)](https://freeimage.host/i/Pdytu2)

## Installation
1. Download this repository
2. Copy t_encrypt.php file to what do you want to store, for example your root project folder
3. Import php file use

```php
require_once 't_encrypt.php';
```
4. Please see sample code below

## Encrypt data

### Simple step
```php
<?php

// import class
require_once 't_encrypt.php';

// please change this password with your own password
// and make sure it is not too short, and please keep it secret
$masterpassword = "beautiful_system";

return t_encrypt::setPassword($masterpassword)

        // You can set input as string
        ->input('mendoan')

        // and you can print as string  (PHP echo)
        ->print();

// Results
// zyMXBNOlXqJnJohyfB1/ctdICm9weM4T4Ch3bgf5fnsIeJci4FzFeUtbEa0ZODSL54rhH39QP5Z9uW33NPO3bcVv/XiyjVljxIbp8o3P2UI=
```
### Encrypt uploaded file
Encrypt uploaded file and show the encryted string
```php
<?php
require_once 't_encrypt.php';
$masterpassword = "beautiful_system";
return t_encrypt::setPassword($masterpassword)
        ->input($_FILES['file'])
        ->print();
```
in this section i was upload a file an this the results

[![PdpZLF.md.png](https://iili.io/PdpZLF.md.png)](https://freeimage.host/i/PdpZLF)

### Encrypt a file use path
Encrypt file use a path and show the encryted string
```php
<?php
require_once 't_encrypt.php';
$masterpassword = "beautiful_system";
return t_encrypt::setPassword($masterpassword)
        ->input("/Users/mymac/Downloads/DSC_0301a.jpeg")
        ->print();
```

and when i fetch use postman, you can see the results here
[![PdyGTB.md.png](https://iili.io/PdyGTB.md.png)](https://freeimage.host/i/PdyGTB)

## Decrypt data
### Simple step

```php
<?php
// import the package
require_once 't_encrypt.php';

// please change this password with your own password
// and make sure it is not too short, and please keep it secret
// AND PLEASE MAKE SURE THIS PASSWORD IS THE SAME WITH THE PASSWORD IN 
// encrypt_sample.php
$masterpassword = "beautiful_system";

// decrypt sample
return t_encrypt::setPassword($masterpassword)
                ->encrypted_string("M7J1nJ3i3o2pP5rBvvDVBtTTi4kqPbpmrpmNUWf5FtVi1gLULg8y4jqCvmniabpnmR1izphuXCEo/fgUtIgMmKZ9+O0aW6ev8Jff9SOwGkA=") // mendoan

                // and you can print as string  (PHP echo, image stream or pdf stream)
                ->print();

```
and the results is
[![P29bHv.md.png](https://iili.io/P29bHv.md.png)](https://freeimage.host/i/P29bHv)

### Decrypt from file
In this section we want to try decrypt a hashed text from a txt file

```php
<?php
require_once 't_encrypt.php';
$masterpassword = "beautiful_system";

return t_encrypt::setPassword($masterpassword)
                ->encrypted_string(__DIR__ . "/example/encrypted_string.txt")

                ->print();

// Results :
// mendoan

```

## Function explanation
You can set a master password for encryption and decryption proccess use ::setPassword function like this

```php
$t_encrypt = t_encrypt::setPassword($masterpassword)
```
Note :
You must choose only one encryption and decryption function

### Encryption function

#### Set Input
1. You can set input as string use this function
```php
$t_encrypt = $t_encrypt->input('mendoan')
```

2. You can set input as POST file use
```php
$t_encrypt = $t_encrypt->input($_FILES['file'])
```

3. Or you can set input as file path use
```php
$t_encrypt = $t_encrypt->input("/Users/mymac/Downloads/Resume_Teguh Rijanandi.docx.pdf")
```

#### Display Output 
1. You can print output as string  (PHP echo) use
```php
$t_encrypt = $t_encrypt->print();
```

2. You can return the string (PHP Return) use
```php
$t_encrypt = $t_encrypt->show();
```

3. or you can save as file use
you can type for your files extension here but we prefer to save as txt file
```php
$t_encrypt = $t_encrypt->saveAsFile(__DIR__ . "/example/encrypted_pdf.txt");
```

### Decryption function
#### Set input
1. You can put encrypted string like this
```php
$t_encrypt = $t_encrypt->encrypted_string("M7J1nJ3i3o2pP5rBvvDVBtTTi4kqPbpmrpmNUWf5FtVi1gLULg8y4jqCvmniabpnmR1izphuXCEo/fgUtIgMmKZ9+O0aW6ev8Jff9SOwGkA=") // mendoan
```

2. or you can put encrypted file here
```php
$t_encrypt = $t_encrypt->encrypted_string(__DIR__ . "/example/encrypted_image.txt")
```

#### Display Output
1. You can print as string  (PHP echo, image stream or pdf stream) use
```php
$t_encrypt = $t_encrypt->print();
```

for example i was stream a pdf file in postman
[![P2nJFp.md.png](https://iili.io/P2nJFp.md.png)](https://freeimage.host/i/P2nJFp)

and stream a image file in postman
[![P2nOiv.md.png](https://iili.io/P2nOiv.md.png)](https://freeimage.host/i/P2nOiv)

2. You can return the string (PHP Return) use
```php
$t_encrypt = $t_encrypt->show();
```

for example i will show to you a base64 image code in a postman
[![P2ocmX.md.png](https://iili.io/P2ocmX.md.png)](https://freeimage.host/i/P2ocmX)

3. or you can save as file use
you can type for your files extension here
```php
$t_encrypt = $t_encrypt->saveAsFile(__DIR__ . "/example/decrypted_image.jpg");

// or

$t_encrypt = $t_encrypt->saveAsFile(__DIR__ . "/example/decrypted_text.txt");

```

For other code sample, you can read in encrypt_sample.php and decrypt_sample.php in this repository. And you can see encrypted and decrypted file in example folder. Thanks

# Contact
If you want to collaborate my project or you see a bug or error please contact me via email or my linkedin, so i will fix immediatly

1. teguh@rijanandi.com
2. https://linktr.ee/teguhrijanandi