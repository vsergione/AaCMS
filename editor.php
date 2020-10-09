<?php
$users = array('admin' => '123456');
$realm = 'Edit mode. User required';

$editorTxt = '<!--quickcms:start-->
<style>
    .switch-field {
        display: flex;
        margin-bottom: 36px;
        overflow: hidden;
    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked + label {
        background-color: #a5dc86;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }
    /* This is just for CodePen. */


    /*.form {*/
    /*    max-width: 600px;*/
    /*    font-family: "Lucida Grande", Tahoma, Verdana, sans-serif;*/
    /*    font-weight: normal;*/
    /*    line-height: 1.625;*/
    /*    margin: 8px auto;*/
    /*    padding: 16px;*/
    /*}*/




    #editor{
        display: inline-block;
        background: white;
        box-shadow: #1b1e21 2px 2px 4px;
        position: fixed;
        top: 10px;
        left: 10px;
        padding: 5px;
        cursor: move;
    }
    #editor button{
        display: block;
        width: 100%;
    }
    #editor fieldset{
        padding: 5px;
        margin-bottom:5px;
    }
    .hovering{
        border: dashed 3px;
    }
    body.editmode .hovering{
        border-color:  yellow;
        cursor: text;
    }
    body.removemode .hovering{
        border: dashed red 1px;
        cursor: not-allowed;
    }

    body.duplicatemode  .hovering{
        border: dashed blue 1px;
        cursor: copy;
    }
    body.movemode  .hovering{
        border: dashed pink 1px;
    }
</style>
<div id="editor" style="visibility: hidden">
    <div class="title">QuickCMS</div>
    <form onsubmit="return false;" class="form">
        <fieldset class="editbuttons">
            <div class=" switch-field">
                <input type="radio" name="mode" value="edit" id="editMode" onclick="setMode(this.value)">
                <label for="editMode">Edit</label>
                <input type="radio" name="mode" value="remove" id="removeMode" onclick="setMode(this.value)">
                <label for="removeMode">Delete</label>
                <input type="radio" name="mode" value="move" id="moveMode" onclick="setMode(this.value)">
                <label for="moveMode">Move</label>
                <input type="radio" name="mode" value="duplicate" id="duplicate" onclick=\'setMode(this.value)\'>
                <label for="duplicate">Clone</label>
                <input type="radio" name="mode" value="" id="noMode" onclick="setMode(this.value)" checked>
                <label for="noMode">Cancel</label>
            </div>
        </fieldset>

        <fieldset class="filebuttons">
            <button onclick="saveFile()">Save</button>
            <button onclick="saveFileAs()">Save as</button>
            <button onclick="removeFile()">Delete</button>
            <button onclick="location.reload()">Reload</button>
            <button onclick="location.href=queryParas.file">Original</button>
        </fieldset>
        <fieldset class="filebuttons">
            <button onclick="location.href=queryParas.file">Logout</button>
        </fieldset>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        editBar();
    }) ;
    let modes = [\'edit\',\'remove\',\'duplicate\',\'move\'];
    let activeMode = null;
    let body = "body";
    let editorLbl = "editor";
    let activeElEvent=null;

    function resetmodes() {
        modes.forEach(function (item) {
            $(body).removeClass(item+"mode");
        })
    }

    function editBar() {
        $("#editor").css({
            top:localStorage.getItem("quickcmsTop")?localStorage.getItem("quickcmsTop"):10,
            left:localStorage.getItem("quickcmsLeft")?localStorage.getItem("quickcmsLeft"):10,
            visibility: "visible"
        })
            .draggable({
            stop: function (ev,ui) {
                localStorage.setItem("quickcmsTop",ui.position.top);
                localStorage.setItem("quickcmsLeft",ui.position.left);
            }
        });
        $("*").on("mouseover",function (e) {
            e.originalEvent.stopPropagation();
            removeHovering();
            if($(e.currentTarget).attr("id")===editorLbl || $(e.currentTarget).parents("#"+editorLbl).length>0
                || e.currentTarget.tagName==="BODY" || e.currentTarget.tagName==="HTML") {
                // console.log("toolbar");
                return;
            }
            // console.log(e);

            addHovering($(e.currentTarget));
        });
    }

    function removeHovering()
    {
        $(".hovering").filter("[contenteditable]").attr("contenteditable",null);
        $(".hovering").removeClass("hovering");
    }

    function addHovering($el) {
        if(activeMode===null)
            return;
        $el.addClass("hovering");
        if(activeMode==="edit" && ["FORM","FIELDSET","IMG","UL","OL","DL"].indexOf($el.prop("tagName"))!==-1) {
            $el.removeClass("hovering");
            return;
        }

        let clone = $el.clone(true);
        $el.off("click").on("click",function (e) {
            e.originalEvent.stopPropagation();

            switch (activeMode) {
                case "edit":
                    $el.attr("contenteditable",true);
                    break;
                case "remove":
                    $el.remove();
                    break;
                case "duplicate":
                    console.log("clone",$el)
                    clone.insertBefore($el);
                    break;
                case "move":
                    $("body").find("*").sortable({
                        connectWith: "*"
                    });
                    break;
            }

        });
    }

    function setMode(mode) {
        resetmodes();
        activeMode = null;
        if(modes.indexOf(mode)===-1)
            return;
        activeMode = mode;

        $(body).addClass(mode+"mode");
    }

    let queryParas = (function () {
        let tmp = location.toString().split("?");
        if (tmp.length < 2)
            return;
        tmp = tmp[1].split("&");
        let paras = {};
        tmp.forEach(function (item) {
            let t = item.indexOf("=");
            if (t === -1)
                paras[item] = null;
            else
                paras[item.substr(0,t)] = item.substr(t+1);
        });

        return paras;
    })();




    function saveFile() {
        saveFileAs(queryParas.file)
    }

    function saveFileAs() {
        let fname = prompt("New file name");
        if(fname===null)
            return;
        let html = document.documentElement.outerHTML;
        let start = html.indexOf("<\!--quickcms:start-->");
        let stop = html.indexOf("<\!--quickcms:stop-->");
        html = html.substr(0,start)+html.substr(stop+20);

        $.ajax({
            url:"editor.php?file="+fname,
            method: "put",
            data: html
        }).done(function (data,xhr) {
            if(data!==queryParas.file) {
                alert("File succesfully saved as "+data+". You will now be redirected to the new location");
                location.href = "editor.php?file=" + data + "&edit=" + queryParas.edit;
            }
        }).fail(function (xhr) {
            console.log(xhr);
        });
    }

    function removeFile() {
        if(!confirm(\'Are you sure you want to remove this file?\'))
            return;
        $.ajax({
            url:"editor.php?file="+fname,
            method: "delete",
            data: html
        }).done(function (data,xhr) {
            console.log(data,xhr);
        }).fail(function (xhr) {
            console.log(xhr);
        });
    }

</script>
<!--quickcms:stop-->';
if(!isset($_GET["file"]) || empty($_GET["file"])) {
    http_response_code(400);
    die("Invalid request: filename missing");
}




if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
        '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
    die(sprintf('<html><head><title></title></head><body><script>window.location="%s"</script></body></html>',$_GET["file"]));
}


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
        $postdata = file_get_contents("php://input");
        if (is_file($_GET["file"])) {
            file_put_contents($_GET["file"], $postdata);
            echo $_GET["file"];
            break;
        }
        $dir = dirname($_GET["file"]);
        if(!is_dir($dir))
            mkdir($dir)."\n";
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
