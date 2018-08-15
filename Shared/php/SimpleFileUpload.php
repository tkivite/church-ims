<?php

/**
 * ------------------------------------------------------------------------------
 * Class:       SimpleFileUpload
 * Description:    (very) Simple PHP File Upload Processing Class:
 * Version:        1.0
 * Updated:     21-Jul-2014
 * Author:        David Henia
 * Company:        Tangazoletu Ltd
 *------------------------------------------------------------------------------
 *------------------------------------------------------------------------------
 *    Functions you will use
 *        SimpleFileUpload->UploadFile()
 *            -> will upload the files and fetch the data (returns excel data as array)
 *
 *    EXAMPLE USE
 *        $SimpleFileUpload = new SimpleFileUpload('files', 'uploads/');
 *        $accepted_file_mimes = array(); #you may want to define $accepted_file_mimes, or leave it blank to accept all files
 *        $SimpleFileUpload->UploadFile($accepted_file_mimes);
 *
 *        if(!isset($SimpleFileUpload->ERROR) || $SimpleFileUpload->ERROR == '')
 *        $uploadedFileLocation = $SimpleFileUpload->FILE;
 *------------------------------------------------------------------------------ */
class SimpleFileUpload
{
    public $ERROR;
    public $FILE;

    /**
     * @name __construct ( )
     * @param $this ->input_file_name = $_FILES[input_file_name]
     * @param $upload_directory = "uploads/"
     *
     */
    public function __construct($input_file_name = 'files', $upload_directory = 'uploads/')
    {
        ini_set("memory_limit", "300M"); #allow massive uploads
        set_time_limit(0); #due to processing huge data, don't let PHP timeout..

        $this->input_file_name = $input_file_name;
        $this->upload_directory = $upload_directory;
        $this->ERROR = '';
    }

    public function __destruct()
    {
    }

    /**
     * @name UploadFile ()
     *      Uploads the files
     *          - generates a new name for them - incase a similar file exists
     *          - changes file permission to 0777 (because of possible linux server permission special issues)
     * @param (array)  $accepted_file_mimes  (e.g) = array(
     *                                          'application/vnd.ms-excel',
     *                                          'application/ms-excel',
     *                                          'application/octet-stream',);
     * @return (boolean) uploaded status
     */
    public function UploadFile($accepted_file_mimes = array())
    {
        /**
         *  First: Upload the File
         */

        $target = $this->upload_directory;
        $ext = $this->findexts($_FILES[$this->input_file_name]['name']);
        $_file_name = $_FILES[$this->input_file_name]["name"];

        $original_file_name = $_FILES[$this->input_file_name]['name'];
        $extension = pathinfo($original_file_name, PATHINFO_EXTENSION);
        $continue = true;

        if (isset($_FILES[$this->input_file_name]['error'])
            && $_FILES[$this->input_file_name]['error'] > 0 #0 == no errors...
        ) {
            $this->ERROR = $this->codeToMessage($_FILES[$this->input_file_name]['error']);
            $continue = false;
            return false;
        }

        #empty $accepted_file_mimes means we allow all files...
        if (!empty($accepted_file_mimes)) {
            if (in_array($_FILES[$this->input_file_name]['type'], $accepted_file_mimes))
                $continue = true;
            else {
                $this->ERROR = 'Uploaded File was not an accepted file format' .
                    $continue = false;
                return false;
            }
        }

        if ($continue) {
            $ext = '.' . $extension;

            #This line assigns a random number to a variable. You could also use a timestamp here if you prefer.
            $random = rand() . uniqid();
            $time = time();

            #This combines the directory, the random file name, and the extension
            # $target = realpath($target);
            $target = $target . $time . '_' . $random . '_.' . pathinfo($original_file_name, PATHINFO_EXTENSION);

            if (move_uploaded_file($_FILES[$this->input_file_name]['tmp_name'], $target)) {
                chmod($target, 0777); # Change file permissions
                $this->FILE = $target;
                return true;
            } else {
                $this->ERROR = 'Could not upload file';
                return false;
            }
        } else {
            $this->ERROR = (isset($this->ERROR) && $this->ERROR <> '') ? $this->ERROR : 'There was a problem uploading file';
            return false;

        }

    }

    /**
     * @name findexts ()
     *      Finds the file extension of a file...
     * @param (string) $filename
     * @return (string) file extension
     */
    private function findexts($filename = '')
    {
        $filename = strtolower($filename);
        $exts = explode("[/\\.]", $filename);
        $n = count($exts) - 1;
        $exts = $exts[$n];
        return $exts;
    }

    /**
     * @name Controller_codeToMessage
     * @param string $code
     *
     * @link http://php.net/manual/en/features.file-upload.errors.php
     * @return string [Meaning of message]
     */
    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload max filesize";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }

}