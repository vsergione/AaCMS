<?php
$users = array('admin' => 'parola123');
$realm = 'Edit mode. User required';

ob_start();
?>
    <!--aacmsTlbx:start-->
    <!--aacmsTlbx:stop-->
<?php
$editorTxt = ob_get_contents();
ob_end_clean();




if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
        '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
    die(sprintf('<html><head><title></title></head><body><script>window.location="%s"</script></body></html>',$_GET["file"]));
}
elseif (isset($_GET["logout"])) {
    header('HTTP/1.1 401 Unauthorized');
    unset($_SERVER["PHP_AUTH_DIGEST"]);
    die(sprintf('<html><head><title></title></head><body><script>window.location="%s"</script></body></html>',$_GET["file"]?$_GET["file"]:"/"));
}

if(!isset($_GET["file"]) || empty($_GET["file"])) {
    http_response_code(400);
    die("Invalid request: filename missing");
}
//print_r($_SERVER['PHP_AUTH_DIGEST']);

// analyze the PHP_AUTH_DIGEST variable
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']]))
    die('Wrong Credentials!');


// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response)
    die('Wrong Credentials!');


function http_digest_parse($txt)
{
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}


switch($_SERVER["REQUEST_METHOD"]) {
    case "PUT":
        if (is_dir($_GET["file"])) {
            http_response_code("406");
            die($_GET["file"]." is a directory");
        }
        $exists = file_exists($_GET["file"]);

        if(!isset($_GET["confirm"]) && $exists) {
            http_response_code("409");
            die("File already exists");
        }



        $dir = dirname($_GET["file"]);
        if(!is_dir($dir))
            mkdir($dir)."\n";

        $postdata = file_get_contents("php://input");
        if(($exists && !is_writable($_GET["file"])) || !is_writable($dir)) {
            http_response_code(503);
        }

        file_put_contents($_GET["file"], $postdata);
        echo $_GET["file"];
        break;
    case "DELETE":
        if (is_file($_GET["file"])) {
            unlink($_GET["file"]);
        }
        break;
    case "GET":
        if (!$_GET["file"] || !is_file($_GET["file"]))
            http_response_code(404);

        $res = file_get_contents($_GET["file"]);

        $editor = $editorTxt;
        $res = preg_replace("/\<\/body\>/i",
            "$editor</body>", $res);

        echo $res;
}
