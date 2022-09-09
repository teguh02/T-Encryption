<?php
/**
 * T-Encryption is a single file simple encryption class for PHP
 * If you use this encryption class, you can encrypt such as
 * - String
 * - File (Image, PDF)
 * 
 * I coded this encryption classes because so many a news about
 * Indonesian government's data are stolen by hackers and leak to
 * the internet. 
 * 
 * I hope you enjoy this class. coded with love by 
 * Teguh Rijanandi for everyone
 * 
 * Note :
 * WE NEVER STORE ANY DATA / FILE FROM YOU
 * 
 * @author Teguh Rijanandi <teguh@rijanandi.com>
 * @copyright 2022 Teguh Rijanandi
 */

// First we must define whats kind of chiper algorithm we need use
// For this example, we use AES-256-CBC
define('CIPHER_ALGORITHM', 'AES-256-CBC');

// Second section we must define whats kind of diggest algorithm we need use
// For this example, we use SHA256
define('DIGGEST_ALGORITHM', 'SHA256');

// define temp folder to store a uploaded file
define('TEMP_FOLDER', __DIR__ . '/temp');

// define string separator for encrypted string
define('STRING_SEPARATOR', '|~|');


// define all of image mime type
function image_type()
{
    return [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/bmp',
        'image/tiff',
        'image/webp',
        'image/vnd.microsoft.icon',
        'image/svg+xml',
        'image/avif',
        'image/heif',
        'image/heic',
    ];
}

// define all of pdf mime type
function pdf_type()
{
    return [
        'application/pdf',
    ];
}

// For check is input image or not
function is_image($file)
{
    if (is_array($file)) {
        $image = mime_content_type($file['tmp_name']);
    } else {
        $image = mime_content_type($file);
    }

    if ($image and in_array($image, image_type())) {
        return true;
    }
    return false;
}

function is_image_from_upload_file($file)
{
    if (is_array($file) and
        isset($file['tmp_name']) and
        isset($file['type']) and
        isset($file['size']) and
        in_array($file['type'], image_type())) {
        return true;
    }
    return false;
}

function is_pdf_from_upload_file($file)
{
    if (is_array($file) and
        isset($file['tmp_name']) and
        isset($file['type']) and
        isset($file['size']) and
        in_array($file['type'], pdf_type())) {
        return true;
    }
    return false;
}

// for check is input pdf or not
function is_pdf($file)
{
    if (is_array($file)) {
        $pdf = mime_content_type($file['tmp_name']);
    } else {
        $pdf = mime_content_type($file);
    }

    if ($pdf and in_array($pdf, pdf_type())) {
        return true;
    }
    return false;
}

function is_string_and_not_file_path($input)
{
    if (is_string($input) and !is_file($input) and !is_dir($input)) {
        return true;
    }
    return false;
}

function is_valid_path($string)
{
    if (is_string($string) and (is_file($string) or is_dir($string))) {
        return true;
    }
    return false;
}

function split_encrypted_string($string)
{
    return explode(STRING_SEPARATOR, $string);
}

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    return $output_file; 
}

function base64_to_pdf($base64_string, $output_file)
{
    //Write data back to pdf file
    $pdf = fopen ($output_file,'w');
    fwrite ($pdf,base64_decode($base64_string));
    //close output file
    fclose ($pdf);
    return $output_file;
}

function write_to_txt_file($base64_string, $output_file)
{
    $file = fopen($output_file, 'w');
    fwrite($file, $base64_string);
    fclose($file);
    return $output_file;
}

function d($data){
    if(is_null($data)){
        $str = "<i>NULL</i>";
    }elseif($data == ""){
        $str = "<i>Empty</i>";
    }elseif(is_array($data)){
        if(count($data) == 0){
            $str = "<i>Empty array.</i>";
        }else{
            $str = "<table style=\"border-bottom:0px solid #000;\" cellpadding=\"0\" cellspacing=\"0\">";
            foreach ($data as $key => $value) {
                $str .= "<tr><td style=\"background-color:#008B8B; color:#FFF;border:1px solid #000;\">" . $key . "</td><td style=\"border:1px solid #000;\">" . d($value) . "</td></tr>";
            }
            $str .= "</table>";
        }
    }elseif(is_resource($data)){
        while($arr = mysql_fetch_array($data)){
            $data_array[] = $arr;
        }
        $str = d($data_array);
    }elseif(is_object($data)){
        $str = d(get_object_vars($data));
    }elseif(is_bool($data)){
        $str = "<i>" . ($data ? "True" : "False") . "</i>";
    }else{
        $str = $data;
        $str = preg_replace("/\n/", "<br>\n", $str);
    }
    return $str;
}

function dnl($data){
    echo d($data) . "<br>\n";
}

function dd($data){
    echo dnl($data);
    exit;
}

function ddt($message = ""){
    echo "[" . date("Y/m/d H:i:s") . "]" . $message . "<br>\n";
}

class t_encrypt {

    protected static $self;
    protected static $input;
    protected static $password;
    protected static $encrypted_text;
    protected static $output_type;

    /**
     * Set master password for your encryption
     *
     * @param string $password
     * @return void
     */
    public static function setPassword(string $password)
    {
        self::$self = new self;
        self::$password = $password;
        return self::$self;
    }

    /**
     * Set input for your encryption
     *
     * @param [type] $input
     * @return void
     */
    public function input($input)
    {
        self::$input = $input;
        return self::$self;
    }

    /**
     * Show the results use php echo
     *
     * @return void
     */
    public function print()
    {
        if (!empty(self::$input)) {
            echo $this->_get_results();
        }

        if (!empty(self::$encrypted_text)) {
            $decrypted_res = $this->_get_decrypted_results();
            switch (self::$output_type) {
                case 'string':
                    echo $decrypted_res;
                    break;

                case 'image':
                    echo '<img src="' . $decrypted_res . '" alt="image">';
                    break;

                case 'pdf':
                    $data = base64_decode($decrypted_res);
                    header('Content-Type: application/pdf');
                    echo $data;
                    break;
                
                default:
                    throw new Exception("Invalid output type!");
                    break;
            }
        }
    }

    /**
     * Show the results use php return
     *
     * @return void
     */
    public function show()
    {
        if (!empty(self::$input)) {
            return $this->_get_results();
        }

        if (!empty(self::$encrypted_text)) {
            return $this->_get_decrypted_results();
        }
    }

    /**
     * Save the results to file
     *
     * @param [type] $path
     * @return void
     */
    public function saveAsFile($path)
    {
        // set filename
        if (!empty(self::$input)) {
            $decrypted = $this->_get_results();
            return write_to_txt_file($decrypted, $path);
        }

        if (!empty(self::$encrypted_text)) {
            $decrypted = $this->_get_decrypted_results();

            switch (self::$output_type) {
                case 'string':
                    return write_to_txt_file($decrypted, $path);
                    break;
                case 'pdf':
                    return base64_to_pdf($decrypted, $path);
                    break;
                case 'image':
                    return base64_to_jpeg($decrypted, $path);
                    break;
                
                default:
                    throw new Exception("Invalid output type!");
                    break;
            }
        }
    }

    /**
     * Set encrypted text for decryption
     *
     * @param [type] $input
     * @return void
     */
    public function encrypted_string($input)
    {
        self::$encrypted_text = $input;
        return self::$self;
    }

    private function _get_results()
    {
        if (is_string_and_not_file_path(self::$input)) {
            self::$output_type = 'string';
            $string = "text/plain" . STRING_SEPARATOR . self::$input;

            // if input is string we can encrypt it
            return $this->encrypt($string);

        } else if(is_image(self::$input)) {
            
            if (is_image_from_upload_file(self::$input)) {
                
                if(!is_dir(TEMP_FOLDER)) {
                    mkdir(TEMP_FOLDER, 0777, true);
                }

                // move uploaded file to temp folder
                $temp_file = TEMP_FOLDER . '/' . self::$input['name'];
                move_uploaded_file(self::$input['tmp_name'], $temp_file);
                $data = file_get_contents($temp_file);
                $base64_string = self::$input['type'] . STRING_SEPARATOR . base64_encode($data);

                $encrypted = $this->encrypt($base64_string);
                unlink($temp_file);

                self::$output_type = 'image';
                return $encrypted;
            } else {
                $data = file_get_contents(self::$input);
                $base64_string = mime_content_type(self::$input) . STRING_SEPARATOR . base64_encode($data);
                self::$output_type = 'image';
                return $this->encrypt($base64_string);
            }

        } else if(is_pdf(self::$input)) {
            
            if (is_pdf_from_upload_file(self::$input)) {
                if(!is_dir(TEMP_FOLDER)) {
                    mkdir(TEMP_FOLDER, 0777, true);
                }

                // move uploaded file to temp folder
                $temp_file = TEMP_FOLDER . '/' . self::$input['name'];
                move_uploaded_file(self::$input['tmp_name'], $temp_file);
                $data = file_get_contents($temp_file);
                $base64_string = self::$input['type'] . STRING_SEPARATOR . base64_encode($data);
                $encrypted = $this->encrypt($base64_string);
                unlink($temp_file);
                self::$output_type = 'pdf';
                return $encrypted;
            } else {
                $data = file_get_contents(self::$input);
                $base64_string = mime_content_type(self::$input) . STRING_SEPARATOR . base64_encode($data);
                self::$output_type = 'pdf';
                return $this->encrypt($base64_string);
            }
        }
    }

    private function _get_decrypted_results()
    {
        $string = "";

        if (is_valid_path(self::$encrypted_text)) {
            $string = file_get_contents(self::$encrypted_text);
        } else {
            $string = self::$encrypted_text;
        }

        $string = $this->decrypt($string);
        $split = split_encrypted_string($string);
        $file_type = $split[0];
        $base64_string = $split[1];

        if (in_array($file_type, image_type())) {
            $base64 = 'data:' . $file_type . ';base64,' . $base64_string;
            self::$output_type = 'image';
            return $base64;
        }else if (in_array($file_type, pdf_type())) {
            // $base64 = 'data:' . $file_type . ';base64,' . $base64_string;
            $base64 = $base64_string;
            self::$output_type = 'pdf';
            return $base64;
        } else {
            self::$output_type = 'string';
            return $base64_string;
        }
    }

    private static function encrypt($plaintext)
    {
        $secret_key = self::$password;
        $cipher = CIPHER_ALGORITHM;

        $key = openssl_digest($secret_key, 'SHA256', TRUE);

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        // binary cipher
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        // or replace OPENSSL_RAW_DATA & $iv with 0 & bin2hex($iv) for hex cipher (eg. for transmission over internet)

        // or increase security with hashed cipher; (hex or base64 printable eg. for transmission over internet)
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        return base64_encode($iv . $hmac . $ciphertext_raw);
    }

    private static function decrypt($ciphertext)
    {
        $secret_key = self::$password;
        $cipher = CIPHER_ALGORITHM;

        $c = base64_decode($ciphertext);

        $key = openssl_digest($secret_key, 'SHA256', TRUE);

        $ivlen = openssl_cipher_iv_length($cipher);

        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        if (hash_equals($hmac, $calcmac))
            return $original_plaintext . "\n";
    }

}