<?php
$users = ['demo' => '123456'];
$realm = 'Edit mode. User required';

ob_start();
?>
    <!--aacmsTlbx:start-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/regular.min.css"
          integrity="sha512-rVrbAp27ffQyFnzJ/aC5fZv9JgvL6cdB4zsL5HmM+DhJdzThc/F//62SJF+CaGiOZTP35e1p8JGcc+zRRVuhRw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"
          integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />

    <style>


        #editor{
            display: inline-block;
            background: white;
            box-shadow: #1b1e21 2px 2px 4px;
            position: fixed;
            top: 10px;
            left: 10px;
            padding: 2px;
            /*cursor: move;*/
        }
        #editor button{
            /*display: block;*/
            /*width: 100%;*/
            padding: 2px;
            font-size: 0.9em;
            border: solid silver 1px;

        }
        .hovering{
            border: aqua dashed 3px;
        }

        #editor{
            color: black;
            z-index: 1000;
        }


        .tabs{
            border-bottom: solid silver 1px;
        }
        .tabs, .tabs li{
            margin: 0;
            padding: 0;
            list-style: none;
            cursor: default;
        }

        .tabs li {
            display: inline;
            border: solid silver 1px;
            padding: 2px 5px 2px 5px;
            border-radius: 3px 3px 0px 0px;
        }
        .tabs li.active{
            border-bottom-color: white;
        }
        .tab-content{
            border: solid silver;
            border-width: 0 1px 1px 1px;
            padding: 5px;
        }
        .title{
            background: silver;
            margin-bottom: 5px;
            font-weight: bold;
            padding-left: 5px;
            color: black;
        }
        .status{
            background: #eee;
            border-width: 1px;
            border-style: solid;
            border-color: #222 #ddd #ddd #222;
            padding: 2px;
            margin-top: 5px;
            font-size: 12px;
        }
        .selected{
            box-shadow: 0 0 0 9999px rgba(0, 0, 255, 0.2);
            z-index: 900;
            position: relative;
        }
        #editor button.nodisplay, .tabs .nodisplay{
            display: none;
        }


    </style>

    <div id="editor" style="visibility: hidden">
        <div class="title">Toolbox</div>
        <div class="body">
            <ul class="tabs">
                <li data-target=".fileMenu" class="active context" >File</li>
                <li data-target=".navMenu" class="context">Traverse</li>
                <li data-target=".editMenu" class="context">Edit</li>
                <li data-target=".textMenu" class="context">Text</li>
                <li data-target=".imageMenu" class="context">Image</li>
                <li data-target=".linkMenu" class="context">Link</li>
                <li data-target=".imgLinkMenu" class="context">Img Lnk</li>
            </ul>
            <div class="tab-content fileMenu">
                <button data-role="save">Save</button>
                <button data-role="saveas">Save as</button>
                <button data-role="delete" disabled>Delete</button>
                <button data-role="reload">Reload</button>
                <button data-role="original">Original</button>
            </div>
            <div class="tab-content navMenu">
                <button data-role="parent">Parent</button>
                <button data-role="prev">Previous</button>
                <button data-role="next">Next</button>
                <button data-role="down">Dive</button>
            </div>
            <div class="tab-content imageMenu">
                <form>
                    <table>
                        <tr><td>URL</td><td><input type="text" name="url"> </td></tr>
                        <tr><td>Title</td><td><input type="text" name="title"> </td></tr>
                        <tr><td>Width</td><td><input type="text" name="width"> </td></tr>
                        <tr><td>Height</td><td><input type="text" name="height"> </td></tr>
                    </table>
                </form>
            </div>
            <div class="tab-content linkMenu">
                <form>
                    <table>
                        <tr><td>Label</td><td><input type="text" name="label"> </td></tr>
                        <tr><td>URL</td><td><input type="text" name="href"> </td></tr>
                        <tr><td>Title</td><td><input type="text" name="title"> </td></tr>
                        <tr><td>Target</td><td><input type="text" name="target"> </td></tr>
                    </table>
                </form>
            </div>
            <div class="tab-content editMenu">
                <button data-role="copy">Copy</button>
                <button data-role="cut">Cut</button>
                <button data-role="remove">Delete</button>
                <button data-role="before" disabled>Insert before</button>
                <button data-role="after" disabled>Insert after</button>
            </div>
            <div class="tab-content textMenu">
                <button data-role="bold"><strong>B</strong></button>
                <button data-role="italic"><i>I</i></button>
                <button data-role="underline"><u>U</u></button>
                <button data-role="strike"><strike>S</strike></button>
                <button data-role="fontplus">F+</button>
                <button data-role="fontminus">F-</button>
            </div>
            <button class="context" style="margin-top: 10px; background: greenyellow" data-role="finish">Finish edit</button>
        </div>
        <div class="status"><a href="https://softaccel.net/aacms">AaCMS</a> by Softaccel.net</div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script>
        (function (editorSel) {
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

            function tabs(sel) {
                let $menu = $(sel);
                let active = null;

                $menu.children("li").each(function (){
                    if($(this).on("click",function () {activate(this);}).hasClass("active"))
                        active = this;
                });

                function reset()
                {
                    $menu.children("li").each( function(){
                        $($(this).removeClass("active").data("target")).css("display","none");
                    });
                }

                function activate(el) {
                    reset();
                    $($(el).addClass("active").data("target")).css("display","block")
                }

                activate(active);

            }

            $(document).ready(function () {
                toolBox(editorSel);
                tabs(".tabs");
                $(".tabs [data-target='.fileMenu']").removeClass("nodisplay");


            });

            let activeMode = null;
            let editorLbl = "editor";
            let activeElement = null;
            let clipBoard = null;


            function toolBox() {
                $(editorSel).find("[data-role]").each(function () {
                    let $el = $(this);
                    switch ($el.data("role")) {
                        case "save":
                            $el.on("click",saveFile);
                            break;
                        case "saveas":
                            $el.on("click",()=>saveFileAs());
                            break;
                        case "delete":
                            // $el.on("click",dete);
                            break;
                        case "reload":
                            $el.on("click",function (){location.reload()});
                            break;
                        case "original":
                            $el.on("click",function(){location = queryParas.file});
                            break;
                        case "logout":
                            $el.on("click",function(){
                                $.get({
                                    type: "GET",
                                    url: location.pathname,
                                    async: false,
                                    username: "fake",
                                    password: "123456",
                                    headers: { "Authorization": "Basic xxx" }
                                })
                                    .done(function(){
                                        // If we don't get an error, we actually got an error as we expect an 401!
                                    })
                                    .fail(function(){
                                        // We expect to get an 401 Unauthorized error! In this case we are successfully
                                        // logged out and we redirect the user.
                                        window.location = queryParas.file;
                                    });

                                return false;
                            });
                            break;

                        case "parent":
                            $el.on("click",function(){
                                console.log("parent",activeElement.parent());
                                if(activeElement.parent().prop("tagName")==="BODY")
                                    return;
                                setActive(activeElement.parent());
                            });
                            break;
                        case "prev":

                            $el.on("click",function(){
                                console.log("prev",activeElement.prev());
                                if(activeElement.prev().length)
                                    setActive(activeElement.prev());
                            });

                            break;
                        case "next":
                            $el.on("click",function(){
                                console.log("next",activeElement.next());
                                if(activeElement.next().length)
                                    setActive(activeElement.next());
                            });
                            break;
                        case "down":
                            $el.on("click",function(){
                                console.log("down",activeElement.children());
                                if(activeElement.children().length)
                                    setActive(activeElement.children()[0]);
                            });
                            break;
                        case "copy":
                            $el.on("click",function(){
                                console.log($(editorSel + " [data-role=before]"));
                                clipBoard = activeElement.clone(true).removeClass("selected");
                                $(editorSel + " [data-role=after]").attr("disabled",null);
                                $(editorSel + " [data-role=before]").attr("disabled",null);
                            });
                            break;
                        case "cut":
                            $el.on("click",function(){
                                clipBoard = activeElement.remove().removeClass("selected");
                                $(editorSel + " [data-role=after]").attr("disabled",null);
                                $(editorSel + " [data-role=before]").attr("disabled",null);
                                setInactive();
                            });
                            break;
                        case "before":
                            $el.on("click",function(){
                                clipBoard.insertBefore(activeElement);
                                $(editorSel + " [data-role=after]").attr("disabled",true);
                                $(editorSel + " [data-role=before]").attr("disabled",true);
                            });
                            break;
                        case "remove":
                            $el.on("click",function(){
                                activeElement.remove();
                                setInactive();
                            });
                            break;
                        case "after":
                            $el.on("click",function(){
                                clipBoard.insertAfter(activeElement);
                                $(editorSel + " [data-role=after]").attr("disabled",true);
                                $(editorSel + " [data-role=before]").attr("disabled",true);
                            });
                            break;
                        case "finish":
                            $el.on("click",function(){
                                console.log("finish",activeElement);
                                if(!activeElement)
                                    return;
                                setInactive();
                            });
                            break;
                        case "bold":
                            $el.on("click",function(){
                                document.execCommand('bold',false,null);
                            });
                            break;
                        case "bold":
                            $el.on("click",function(){
                                document.execCommand('bold',false,null);
                            });
                            break;
                        case "italic":
                            $el.on("click",function(){
                                document.execCommand('italic',false,null);
                            });
                            break;
                        case "underline":
                            $el.on("click",function(){
                                document.execCommand('underline',false,null);
                            });
                            break;
                        case "strike":
                            $el.on("click",function(){
                                document.execCommand('strikeThrough',false,null);
                            });
                            break;
                        case "fontplus":
                            $el.on("click",function(){
                                document.execCommand('increaseFontSize',false,null);
                            });
                            break;
                        case "fontminus":
                            $el.on("click",function(){
                                document.execCommand('decreaseFontSize',false,null);
                            });
                            break;
                    }
                });


                hideTabs();

                $(editorSel)
                    .draggable({
                        handle: ".title",
                        stop: function (ev,ui) {
                            localStorage.setItem("aacmsTlbxTop",ui.position.top);
                            localStorage.setItem("aacmsTlbxLeft",ui.position.left);
                        }
                    })
                    .css({
                        top:localStorage.getItem("aacmsTlbxTop")?localStorage.getItem("aacmsTlbxTop"):100,
                        left:localStorage.getItem("aacmsTlbxLeft")?localStorage.getItem("aacmsTlbxLeft"):100,
                        visibility: "visible"
                    });

                $("*").on("mouseover",function (e) {
                    e.originalEvent.stopPropagation();
                    removeHovering();

                    if(activeElement!==null)
                        return ;
                    if( $(e.currentTarget)[0]===$(editorSel)[0])
                        return ;
                    if($(e.currentTarget).parents("#"+$(editorSel).attr("id")).length>0)
                        return ;
                    if(["BODY","HTML"].indexOf(e.currentTarget.tagName)!==-1)
                        return;

                    addHovering($(e.currentTarget));
                });
            }
            function hideTabs() {
                $(editorSel).find(".context").addClass("nodisplay");
            }

            function removeHovering() {
                $(".hovering").filter("[contenteditable]").attr("contenteditable",null);
                $(".hovering").removeClass("hovering");
            }

            let onSetInactive = new Function();


            function setInactive() {
                onSetInactive();
                $(editorSel+" .context").addClass("nodisplay");
                $(".tabs [data-target='.fileMenu']").removeClass("nodisplay").click();
                $(activeElement).removeClass("selected");
                activeElement = null;
            }


            function  setActive(el) {
                let frm;
                activeElement = $(el);
                $(".selected").removeClass("selected");
                activeElement.addClass("selected");
                console.log("set active",activeElement);
                hideTabs();
                $(editorSel+" [data-target='.editMenu']").removeClass("nodisplay");
                $(editorSel +" [data-target='.navMenu']").removeClass("nodisplay");
                $(editorSel+" [data-target='.navMenu']").click();
                $(editorSel+" [data-role='finish']").removeClass("nodisplay");
                switch(activeElement.prop("tagName").toLowerCase()) {
                    case "img":
                        $(editorSel+" [data-target='.imageMenu']").removeClass("nodisplay").click();
                        frm = $(editorSel +" .imageMenu").find("form")[0];
                        frm.url.value = activeElement.attr("src");
                        frm.title.value = activeElement.attr("title")?activeElement.attr("title"):"";
                        frm.width.value = activeElement.attr("width")?activeElement.attr("width"):"";
                        frm.height.value = activeElement.attr("height")?activeElement.attr("height"):"";
                        onSetInactive = function () {
                            if(frm.url.value)
                                activeElement.attr("src",frm.url.value);
                            activeElement.attr("title",frm.title.value?frm.title.value:null);
                            activeElement.attr("width",frm.width.value?frm.width.value:null);
                            activeElement.attr("height",frm.height.value?frm.height.value:null);

                            onSetInactive = new Function();
                        };
                        break;
                    case "a":
                        $(editorSel+" [data-target='.linkMenu']").removeClass("nodisplay").click();
                        frm = $(editorSel +" .linkMenu").find("form")[0];
                        frm.label.value = activeElement.html();
                        frm.href.value = activeElement.attr("href");
                        frm.title.value = activeElement.attr("title")?activeElement.attr("title"):"";
                        frm.target.value = activeElement.attr("target")?activeElement.attr("target"):"";

                        onSetInactive = function () {
                            if(frm.href.value)
                                activeElement.attr("href",frm.href.value);
                            if(frm.label.value)
                                activeElement.html(frm.label.value);

                            activeElement.attr("title",frm.title.value?frm.title.value:null);
                            activeElement.attr("target",frm.target.value?frm.target.value:null);

                            onSetInactive = new Function();
                        };
                        break;
                    case "table":
                        break;
                    case "form":
                        break;
                    case "fieldset":
                        break;
                    case "input":
                        break;
                    case "button":
                        break;
                    default:
                        $(editorSel+" [data-target='.textMenu']").removeClass("nodisplay").click();
                        activeElement.attr("contentEditable",true);
                        onSetInactive = function () {
                            activeElement.attr("contentEditable",false);
                            onSetInactive = new Function();
                        }
                }
            }

            function addHovering($el) {
                $el.off("click");

                if(activeElement!==null)
                    return;

                // console.log("hover",$el);
                // if(["FORM","FIELDSET","IMG","UL","OL","DL"].indexOf($el.prop("tagName"))!==-1) {
                //     $el.removeClass("hovering");
                //     console.log("hover");
                //     return;
                // }
                //
                $el.addClass("hovering");
                $el.on("click",function (e) {
                    e.originalEvent.stopPropagation();
                    e.stopPropagation();
                    setActive($el);
                    return false;
                });
            }


            function saveFile() {
                saveFileAs(queryParas.file,true);
            }

            function saveSwap() {
                saveFileAs("."+queryParas.file+".swap",()=>console.log("swap file saved"));
            }

            function saveFileAs(fname,overwrite,handleOk) {
                if(fname===undefined) {
                    // fname = prompt('New file name');
                    let $form = $("<form>").append("<label>File name</label>").append("<input name='fname' type=text style='width: 100%'>");
                    $form.dialog({
                        title: "Save as",
                        buttons:{
                            OK: function () {
                                if($form[0].fname.value) {
                                    saveFileAs($form[0].fname.value);

                                }
                                $(this).dialog("close").remove();

                            },
                            Cancel: function () {
                                $(this).dialog("close").remove();
                            }
                        }
                    });
                    return;
                }


                if(fname===null)
                    return;

                overwrite = overwrite?"confirm":"";

                let html = document.documentElement.outerHTML;
                let start = html.indexOf("<\!--aacmsTlbx:start-->");
                let stop = html.indexOf("<\!--aacmsTlbx:stop-->");
                html = html.substr(0,start)+html.substr(stop+21);

                $.ajax({
                    url:location.pathname+"?file="+fname+"&"+ overwrite,
                    method: "put",
                    data: html
                }).done(function (data,xhr) {
                    if(handleOk) return handleOk(data);
                    if(data!==queryParas.file) {
                        // alert();

                        $("<div>")
                            .attr("title","Confirm")
                            .html("File succesfully saved as "+data+".<br>Do you want to edit the new file?")
                            .dialog({
                                modal: true,
                                buttons: {
                                    No: function() {
                                        $(this ).dialog( "close" ).remove();
                                    },
                                    Yes: function() {
                                        location.href = location.pathname+"?file=" + data;
                                    }
                                }
                            });
                    }
                }).fail(function (xhr) {
                    console.log(xhr);
                    switch(xhr.status) {
                        case 409:
                            $("<div title='Confirm overwrite'>File "+fname+" already exists. Do you want to overwrite it?</div>")
                                .dialog({
                                    modal: true,
                                    buttons: {
                                        No: function() {
                                            $( this ).dialog( "close" ).remove();
                                        },
                                        Yes: function() {
                                            $( this ).dialog( "close" ).remove();
                                            saveFileAs(fname,true);
                                        }
                                    }
                                });
                            break;
                        case 406:
                            $("<div title='Error'>"+fname+" already exists and is a directory. You are not allowed to use its name.</div>")
                                .dialog({modal:true,close:function () {$(this).remove();}});
                            break;
                        case 503:
                            $("<div title='Error'>"+fname+" is not writable. Please update settings on server.</div>")
                                .dialog({modal:true,close:function () {$(this).remove();}});
                    }
                });


            }

            function removeFile() {
                if(!confirm('Are you sure you want to remove this file?'))
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

        })("#editor");


    </script>

    <!--aacmsTlbx:stop-->
<?php
$editorTxt = ob_get_contents();
ob_end_clean();
//$editorTxt = file_get_contents("editor.html");


if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
        '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
    die(sprintf('<html><head><title></title></head><body><script>window.location="%s"</script></body></html>',$_GET["file"]));
}

if (isset($_GET["logout"])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
        '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
    die(sprintf('<html><head><title></title></head><body><script>window.location="%s"</script></body></html>',$_GET["file"]?$_GET["file"]:"/"));
}

if(!isset($_GET["file"]) || empty($_GET["file"])) {
    http_response_code(400);
    die("Invalid request: filename missing");
}
//print_r($_SERVER['PHP_AUTH_DIGEST']);

// analyze the PHP_AUTH_DIGEST variable
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']])) {#
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
        '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
    die('Wrong Credentials!');
}


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
