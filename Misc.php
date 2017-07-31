<?php
    include 'Dropbox.php';
    class Misc {
        private $token;
        
        // *   *  *****   ****   ****
        // ** **    *    *      *
        // * * *    *     ***   *
        // *   *    *        *  *      
        // *   *  *****  ****    ****  *
        
        public function __construct($accesstoken) {
            $this->token = $accesstoken;
        }
        
        public function isValidPath($path) {
            $endpoint = "https://api.dropboxapi.com/2/files/get_metadata";
            $headers = array(
                "Content-Type: application/json"
            );
            $postdata = json_encode(array( "path" => $path, "include_media_info" => FALSE, "include_deleted" => FALSE, "include_has_explicit_shared_members" => false));
            $returnData = Dropbox::postRequest($endpoint, $headers, $postdata);
            if (isset($returnData["error"])) {
                return FALSE;
            }
            else {
                return TRUE;
            }
        }
    }

    class Entry {
        public $cursor;
        public $commit;
        
        public function __construct($session_id, $offset, $path, $mode = 'add', $autorename = false, $mute = false) {
            $cursor = array(
                "sesson_id" => $session_id,
                "offset" => $offset
            );
            $commit = array({
                "path" => $path,
                "mode" => $mode,
                "autorename" => $autorename,
                "mute" => $mute
            });
        }
        
        public function toJson() {
            return json_encode(array(
                "cursor" => $cursor,
                "commit" => $commit
            ))
        }
    }

?>