<?php

/*
 * SULATA FRAMEWORK
 * This file contains the default functions of Sulata Framework
 * For framework version, please refer to the config.php file.
 */


/* check referrer */
if (!function_exists('suCheckRef')) {

    function suCheckRef() {
        if (!stristr($_SERVER['HTTP_REFERER'], BASE_URL)) {
            suExit(INVALID_ACCESS);
        }
    }

}
/* fuction to stop openening page outside frame */
if (!function_exists('suFrameBuster')) {

    function suFrameBuster($url = ACCESS_DENIED_URL) {
        suPrintJs("
            if (parent.frames.length 
<1) { 
                parent.window.location.href = '$url';
            }
        ");
    }

}
/* Function to get url segment */
if (!function_exists('suSegment')) {

    function suSegment($segment) {
        $path = $_SERVER['PATH_INFO'];
        if (!strstr($path, '/')) {
            $path = $_SERVER['ORIG_PATH_INFO'];
        }
        $path = explode('/', $path);
        return $path[$segment];
    }

}
/* Check if this is a mobile device */
if (!function_exists('suIsMobile')) {

// Create the function, so you can use it
    function suIsMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up \.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

}
/* Build Iframe */

if (!function_exists('suIframe')) {

    function suIframe($debug = DEBUG, $name = 'remote') {
        if ($debug == TRUE) {
            $display = 'block';
        } else {
            $display = 'none';
        }

        echo "
<div style='clear:both'></div>
<div style='height:35px;line-height:35px;font-family:Arial;color:#000;background-color:#FFCD9B;display:{$display};'>&nbsp;This is debug window. Set define('DEBUG', FALSE) in config.php file to hide it.</div>
<iframe frameborder='0' name='{$name}' id='{$name}' width='100%' height='300' style='display:{$display};border:1px solid #FFCD9B;'/>
Sorry, your browser does not support frames.
</iframe>
";
    }

}
/* Resize image */
if (!function_exists('suResize')) {

    function suResize($forcedwidth, $forcedheight, $sourcefile, $destfile, $canvasfolder = ADMIN_UPLOAD_PATH) {
        set_time_limit(0);

        //Check required if file has been uploaded

        $fw = $forcedwidth;
        $fh = $forcedheight;
        //Get image size
        @$is = getimagesize($sourcefile);
        //Get image extension
        $extension = $is["mime"];
        if (($extension != "image/jpeg") && ($extension != "image/png") && ($extension != "image/gif")) {
            $msg = "Source file must be an image in JPG, PNG or GIF.";
            return $msg;
            exit;
        }
        //If width is wild card
        if ($fw == "*") {
            $w_ratio = $is[0] / $is[1];
            $fw = $is[1] * $w_ratio;
        }
        //If height is wild card
        if ($fh == "*") {
            $h_ratio = $is[1] / $is[0];
            $fh = $is[1] / $h_ratio;
        }

        if ($is[0] >= $is[1]) {
            $orientation = 0;
        } else {
            $orientation = 1;
        }
        if ($is[0] > $fw || $is[1] > $fh) {
            if (( $is[0] - $fw ) >= ( $is[1] - $fh )) {
                $iw = $fw;
                $ih = ( $fw / $is[0] ) * $is[1];
            } else {
                $ih = $fh;
                $iw = ( $ih / $is[1] ) * $is[0];
            }
            $t = 1;
        } else {
            $iw = $is[0];
            $ih = $is[1];
            $t = 2;
        }
        if ($t == 1) {
            if ($extension == "image/png") {
                $img_src = imagecreatefrompng($sourcefile);
            } elseif ($extension == "image/jpeg") {
                $img_src = imagecreatefromjpeg($sourcefile);
            } elseif ($extension == "image/gif") {
                $img_src = imagecreatefromgif($sourcefile);
            }

            //Create white canvas
//            $canvas_img = imagecreate($forcedwidth, $forcedheight);
//            $background = imagecolorallocate($canvas_img, 255, 255, 255);
//            @unlink($canvasfolder . '/canvas.png');
//            imagepng($canvas_img, $canvasfolder . '/canvas.png');


            $img_dst = imagecreatetruecolor($iw, $ih);
            //Delete any exiting image
            @unlink($destfile);
            if ($extension == "image/png" or $extension == "image/gif") {
                //Preserve tranparency
                imagecolortransparent($img_dst, imagecolorallocatealpha($img_dst, 0, 0, 0, 127));
                imagealphablending($img_dst, false);
                imagesavealpha($img_dst, true);
            }

            //Create new image
            imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $iw, $ih, $is[0], $is[1]);

            if ($extension == "image/png") {
                if (!imagepng($img_dst, $destfile, 9)) {
                    exit();
                }
            } elseif ($extension == "image/jpeg") {
                if (!imagejpeg($img_dst, $destfile, 90)) {
                    exit();
                }
            } elseif ($extension == "image/gif") {
                if (!imagegif($img_dst, $destfile, 90)) {
                    exit();
                }
            }
        } else if ($t == 2) {
            copy($sourcefile, $destfile);
        }
    }

}

/* Exit with message */
if (!function_exists('suExit')) {

    function suExit($str) {

        $str = "
<div style='color:#0000FF;font-family:Tahoma,Verdana,Arial;font-size:13px;'>{$str}</div>
";
        exit($str);
    }

}
/* Strip */
if (!function_exists('suStrip')) {

    function suStrip($str) {
        $str = trim(addslashes($str));
        return $str;
    }

}
/* Unstrip */
if (!function_exists('suUnstrip')) {

    function suUnstrip($str) {
        $str = htmlspecialchars(stripslashes($str));
        if (LOCAL == TRUE) {
            $str = str_replace(WEB_URL, LOCAL_URL, $str);
        } else {
            $str = str_replace(LOCAL_URL, WEB_URL, $str);
        }
        return $str;
    }

}
/* Print JS */
if (!function_exists('suPrintJS')) {

    function suPrintJS($str) {

        echo "
<script type=\"text/javascript\">
		{$str}
		</script>
";
    }

}


/* Create a tag */
if (!function_exists('suInput')) {

    //Tag name, $attributes array,$data html, $has ending tag
    function suInput($tag, $attributes, $data = '', $has_ending = FALSE) {
        global $uniqueArray;
        if (is_array($attributes)) {
            $atts = '';
            foreach ($attributes as $key => $val) {

                if ($key != '') {

                    if (strtolower($key) == 'name') {
                        $fieldName = $val;
                    }
                    if ($has_ending == FALSE) {

                        if (strtolower($key) == 'maxlength') {
                            if (in_array($fieldName, $uniqueArray)) {
                                $val = $val - UID_LENGTH;
                            }
                            $atts .= ' ' . $key . '="' . $val . '"';
                        } else {
                            $atts .= ' ' . $key . '="' . $val . '"';
                        }
                    } else {
                        if ($key != 'type') {
                            if (strtolower($key) == 'maxlength') {
                                if (in_array($key, $uniqueArray)) {
                                    $val = $val - UID_LENGTH;
                                }
                                $atts .= ' ' . $key . '="' . $val . '"';
                            } else {
                                $atts .= ' ' . $key . '="' . $val . '"';
                            }
                        }
                    }
                }
            }
            $attributes = $atts;
        }

        if ($has_ending == TRUE) {
            $tag = "<{$tag}" . $attributes . ">" . $data . "</{$tag}>";
        } else {
            $tag = "<{$tag}" . $attributes . "/>";
        }
        return $tag;
    }

}
/* searchable dropdown */
if (!function_exists('suSearchableDropdown')) {

    function suSearchableDropdown($name, $sql, $selectedVal, $js) {

        if ($js == '') {
            $js = ' class="chosen-select form-control" ';
        } else {
            $js = $js;
        }
        $searchableDD = '';
        $opt = "<option value=\"^\">Select..</option>\n";
        $selected = '';
        $result = suQuery($sql);
        foreach ($result['result'] as $row) {
            if (suUnstrip($row['f1']) == $selectedVal) {
                $selected = " selected=\"selected\"";
            } else {
                $selected = "";
            }
            $opt.= "<option " . $selected . " value=\"" . suUnstrip($row['f1']) . "\">" . suUnstrip($row['f2']) . "</option>";
        }
        $searchableDD = '<select name="' . $name . '" id="' . $name . '" ' . $js . '>' . "\n" . $opt . '</select>' . "\n";

        return $searchableDD;
    }

}
/* form dropdown */
if (!function_exists('suDropdown')) {

    function suDropdown($name = '', $options = array(), $selected = array(), $extra = '') {
        if (!is_array($selected)) {
            $selected = array($selected);
        }

        // If no selected state was submitted we will attempt to set it automatically
        if (count($selected) === 0) {
            // If the form name appears in the $_POST array we have a winner!
            if (isset($_POST[$name])) {
                $selected = array($_POST[$name]);
            }
        }

        if ($extra != '')
            $extra = ' ' . $extra;

        $multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

        $form = '
<select id="' . $name . '" name="' . $name . '"' . $extra . $multiple . ">
\n";

        foreach ($options as $key => $val) {
            $key = (string) $key;

            if (is_array($val) && !empty($val)) {
                $form .= '
<optgroup label="' . $key . '">
' . "\n";
                foreach ($val as $optgroup_key => $optgroup_val) {
                    $sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';
                    $form .= '<option value="' . $optgroup_key . '"' . $sel . '>' . (string) $optgroup_val . "</option>\n";
                }

                $form .= '
</optgroup>
' . "\n";
            } else {
                $sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

                $form .= '
<option value="' . $key . '"' . $sel . '>
' . (string) $val . "
</option>
\n";
            }
        }

        $form .= '
</select>
';

        return $form;
    }

}
/* Print Array */
if (!function_exists('print_array')) {

    //Tag name, html, $attributes,$has ending tag
    function print_array($array) {
        echo '
<pre>';
        print_r($array);
        echo '</pre>
';
    }

}
/* Make dropdown array from db */
if (!function_exists('suFillDropdown')) {

    function suFillDropdown($sql) {
        $suFillDropdown = array('^' => 'Select..');
        $result = suQuery($sql);
        foreach ($result['result'] as $row) {
            $suFillDropdown[suUnstrip($row['f1'])] = suUnstrip($row['f2']);
        }
        return $suFillDropdown;
    }

}
/* Convert date format for database */
if (!function_exists('suDate2Db')) {

    //mm-dd-yyyy or dd-mm-yyyy
    function suDate2Db($date, $sep = '-') {
        if ($date != '') {
            $nDate = explode($sep, $date);
            if (DATE_FORMAT == 'mm-dd-yy') {
                $nDate = $nDate['2'] . '-' . $nDate['0'] . '-' . $nDate['1'];
            } else {
                $nDate = $nDate['2'] . '-' . $nDate['1'] . '-' . $nDate['0'];
            }
            return $nDate;
        } else {
            return $date = '';
        }
    }

}
/* Convert date format from database */
if (!function_exists('suDateFromDb')) {

    //mm-dd-yyyy or dd-mm-yyyy
    function suDateFromDb($date, $sep = '-') {
        if (($date == '') || ($date == '0000-00-00')) {
            return $date = '';
        } else {

            $nDate = explode($sep, $date);
            if (DATE_FORMAT == 'mm-dd-yy') {
                $nDate = $nDate['1'] . '-' . $nDate['2'] . '-' . $nDate['0'];
            } else {
                $nDate = $nDate['2'] . '-' . $nDate['1'] . '-' . $nDate['0'];
            }
            return $nDate;
        }
    }

}
/* Check admin login */
if (!function_exists('checkLogin')) {

//Check if logged in
    function checkLogin() {
        if ($_SESSION[SESSION_PREFIX . 'user__ID'] == '') {
            $url = ADMIN_URL . 'login' . PHP_EXTENSION . '/';
            suPrintJs("parent.window.location.href='{$url}';");
            exit();
        }
        //Check if user is active
        if ($_SESSION[SESSION_PREFIX . 'user__Status'] != 'Active') {
            $msg = urlencode(INACTIVE_MESSAGE);
            $url = ADMIN_URL . 'message' . PHP_EXTENSION . '/?msg=' . $msg;
            suPrintJs("parent.window.location.href='{$url}';");
            exit();
        }
        //Check if user logged in from another location
        //get multi_login settings
        $sql = "SELECT setting__Value FROM sulata_settings WHERE setting__Key='multi_login' AND setting__dbState='Live'";
        $result = suQuery($sql);
        $row = $result['result'][0];
        $multi_login = $row['setting__Value'];

        if ($multi_login == '0') {
            //Get user IP

            $sql = "SELECT user__IP FROM sulata_users WHERE user__dbState='Live' AND user__ID='" . $_SESSION[SESSION_PREFIX . 'user__ID'] . "'";
            $result = suQuery($sql);
            $user__IP = $result['result'][0]['user__IP'];
            if ($_SESSION[SESSION_PREFIX . 'user__IP'] != $user__IP) {
                $msg = urlencode(MULTIPLE_LOGIN_ERROR_MESSAGE);
                $url = ADMIN_URL . 'message' . PHP_EXTENSION . '/?msg=' . $msg;
                //Unset login sessions
                $_SESSION[SESSION_PREFIX . 'user__ID'] = '';
                $_SESSION[SESSION_PREFIX . 'user__Name'] = '';
                $_SESSION[SESSION_PREFIX . 'user__Email'] = '';
                $_SESSION[SESSION_PREFIX . 'user__Picture'] = '';
                $_SESSION[SESSION_PREFIX . 'user__Status'] = '';
                $_SESSION[SESSION_PREFIX . 'user__Theme'] = '';
                $_SESSION[SESSION_PREFIX . 'user__IP'] = '';
                session_unset();
                suPrintJs("parent.window.location.href='{$url}';");
                exit();
            }
        }
    }

}
/* Slugify file name */
if (!function_exists('suSlugify')) {

    //File name and uniqid
    function suSlugify($string, $uid) {
        $suFileName = '';
        $string = explode('.', $string);
        $ext = '.' . end($string);
        for ($i = 0; $i <= sizeof($string) - 2; $i++) {
            $suFileName .= $string[$i];
        }
        $suFileName = preg_replace('/[^A-Za-z0-9-]+/', '-', $suFileName);
        $suFileName = $suFileName . '-' . $uid . $ext;

        return $suFileName;
    }

}
/* Make file Name */
if (!function_exists('suSlugifyName')) {

    //File name and uniqid
    function suSlugifyName($suFileName) {
        $suFileName = preg_replace('/[^A-Za-z0-9-]+/', '-', $suFileName);
        return strtolower($suFileName);
    }

}

/* Get file extension */
if (!function_exists('suGetExtension')) {

    function suGetExtension($name) {
        return end(explode(".", strtolower($name)));
    }

}
/* print $vError validation errors */
if (!function_exists('suValdationErrors')) {

    function suValdationErrors($vError) {
        for ($i = 0; $i <= sizeof($vError) - 1; $i++) {
            $li.= '
<li>' . $vError[$i] . '</li>
';
        }

        echo "
<div id='error-area'>
  <ul>
    " . $li . "
  </ul>
</div>
";

        if (sizeof($vError) > 0) {
            suPrintJs('
            parent.suToggleButton(0);
            parent.$("#message-area").hide();
            parent.$("#error-area").show();
            parent.$("#error-area").html(document.getElementById(\'error-area\').innerHTML);
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
        ');
            exit();
        }
    }

}
/* validate a form in one go  */
if (!function_exists('suValidateForm')) {

    //$dbsArray=dbstructure array of the table like $dbs_sulata_employees
    function suProcessForm($dbsArray, $validateAsArray = '') {
        if ($validateAsArray == '') {
            $validateAsArray = $dbsArray;
        }
        foreach ($_POST as $key => $value) {
            if ($dbsArray[$key . '_req'] == '*') {
                if ($validateAsArray[$key . '_validateas'] == 'string') {
                    isString($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'required') {
                    isRequired($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'textarea') {
                    isRequired($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'email') {
                    isEmail($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'int') {
                    isInt($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'float') {
                    isFloat($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'double') {
                    isDouble($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'url') {
                    isURL($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'ip') {
                    isIP($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'cc') {
                    isCC($_POST[$key], $dbsArray[$key . '_title']);
                }

                if ($validateAsArray[$key . '_validateas'] == 'date') {
                    isDate($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'enum') {
                    isEnum($_POST[$key], $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'password') {
                    isRequired($_POST[$key], $dbsArray[$key . '_title']);
                    isRequired($_POST[$key . '2'], 'Confirm ' . $dbsArray[$key . '_title']);
                    isPassword($key, $dbsArray[$key . '_title']);
                }
            } else {

                if (($_POST[$key] != '') && ($_POST[$key] != '^')) {

                    if ($validateAsArray[$key . '_validateas'] == 'string') {
                        isString($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'required') {
                        isRequired($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'textarea') {
                        isRequired($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'email') {
                        isEmail($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'int') {
                        isInt($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'float') {
                        isFloat($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'double') {
                        isDouble($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'url') {
                        isURL($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'ip') {
                        isIP($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'cc') {
                        isCC($_POST[$key], $dbsArray[$key . '_title']);
                    }

                    if ($validateAsArray[$key . '_validateas'] == 'date') {
                        isDate($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'enum') {
                        isEnum($_POST[$key], $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'password') {
                        isRequired($_POST[$key], $dbsArray[$key . '_title']);
                        isRequired($_POST[$key . '2'], 'Confirm ' . $dbsArray[$key . '_title']);
                        isPassword($key, $dbsArray[$key . '_title']);
                    }
                }
            }
        }
        foreach ($_FILES as $key => $value) {
            if ($dbsArray[$key . '_req'] == '*') {

                if ($validateAsArray[$key . '_validateas'] == 'image') {
                    isImage($key, $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'file') {
                    isFile($key, $dbsArray[$key . '_title']);
                }
                if ($validateAsArray[$key . '_validateas'] == 'attachment') {
                    isAttachment($key, $dbsArray[$key . '_title']);
                }
            } else {

                if ($_FILES[$key]['name'] != '') {
                    if ($validateAsArray[$key . '_validateas'] == 'image') {
                        isImage($key, $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'file') {
                        isFile($key, $dbsArray[$key . '_title']);
                    }
                    if ($validateAsArray[$key . '_validateas'] == 'attachment') {
                        isAttachment($key, $dbsArray[$key . '_title']);
                    }
                }
            }
        }
    }

}
/* Make CKEditor out of textarea */
if (!function_exists('suCKEditor')) {

    //File name and uniqid
    function suCKEditor($editorId) {
        suPrintJS("
 CKEDITOR.replace( '" . $editorId . "' , {
                                        toolbar: [
                                            { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                                            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Scayt' ] },
                                            { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                                            { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
                                            { name: 'tools', items: [ 'Maximize' ] },
                                            { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
                                            { name: 'others', items: [ '-' ] },
                                            '/',
                                            [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
                                            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
                                            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
                                            { name: 'styles', items: [ 'Styles', 'Format' ] },
                                            { name: 'about', items: [ 'About' ] }
                                        ]
                                    });
");
        echo "<div>&nbsp;</div>";
    }

}
/* Crypt */
if (!function_exists('suCrypt')) {

    function suCrypt($str) {
        return base64_encode(base64_encode($str));
    }

}
/* Decrypt */
if (!function_exists('suDecrypt')) {

    function suDecrypt($str) {
        return base64_decode(base64_decode($str));
    }

}
/* Redirect */
if (!function_exists('suRedirect')) {

    function suRedirect($url) {
        suPrintJs("parent.window.location.href='{$url}';");
        exit;
    }

}
/* Insert item and get insertid */
if (!function_exists('suDoInsert')) {

//sql,name of the unique field in table
    function suDoInsert($insertSql, $selectSql, $uniqueField) {
        $result = suQuery($insertSql, FALSE);
        $insertId = suInsertId();
        if ($result['errno'] > 0) {
            if ($result['errno'] == 1062) {
                $sql2 = $selectSql;
                $result2 = suQuery($sql2, 'insert');
                $row2 = $result2['result'][0];
                $insertId = $row2[$uniqueField];
            } else {
                suPrintJs("alert('" . MYSQL_ERROR . "')");
                exit();
            }
        }
        return $insertId;
    }

}
/* Bar Chart */
if (!function_exists('suBarChart')) {

    function suBarChart($percentValue, $text, $fillColor = '#DD3399', $width = '80%', $anchor = '', $title = 'Drill down') {
        if ($anchor != '') {
            $cursor = 'cursor:pointer';
            $onclick = "onclick=\"location.href='{$anchor}'\"";
            $title = "title='{$title}'";
        } else {
            $cursor = '';
            $onclick = '';
        }
        echo"
        <div>&nbsp;</div>    
        <div><small>{$text}</small></div>
        <div $title $onclick style='width:{$width};height:20px;line-height:20px;border:1px solid #CCC;;background-color:#EEE;'>
            <div style='width:{$percentValue};height:20px;line-height:20px;background-color:{$fillColor};{$cursor}'>
            </div>
        </div>
        ";
    }

}
/* Mail */
if (!function_exists('suMail')) {

    function suMail($to, $subject, $message, $fromName, $fromEmail, $html = FALSE, $attachment = FALSE) {
        if ($html == FALSE) {
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= "Content-Type:text/plain;charset=utf-8\r\n";
            $headers .= "From: $fromName <$fromEmail>" . "\r\n";
            mail($to, $subject, $message, $headers);
        } else {
            $mail = new PHPMailer(); // defaults to using php "mail()"
            $body = $message;
            $body = eregi_replace("[\]", '', $body);
            $mail->AddReplyTo($fromEmail, $fromName);
            $mail->SetFrom($fromEmail, $fromName);
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($to, $to);
            $mail->Subject = $subject;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
            $mail->MsgHTML($body);
            if ($attachment == TRUE) {
                $mail->AddAttachment($attachment);      // attachment
            }
            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                //echo "Message sent!";
            }
        }
    }

}
/* Download as CSV */
if (!function_exists('suSqlToCSV')) {

    //$headerArray=array('Col 1','Col 2','Col 3');
    function suSqlToCSV($sql, $headerArray, $outputFileName) {
        $sql = explode(',', $sql);
        $size = sizeof($sql);
        for ($i = 1; $i <= sizeof($sql) - 1; $i++) {
            $csvSql.=$sql[$i] . ',';
        }
        $sql = "SELECT " . substr($csvSql, 0, -1);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $outputFileName);
        $output = fopen('php://output', 'w');
        fputcsv($output, $headerArray);
        $result = suQuery($sql);
        foreach ($result['result'] as $row) {
            fputcsv($output, $row);
        }
    }

}
/* Download as PDF */
if (!function_exists('suSqlToPDF')) {

    //$headerArray=array('Col 1','Col 2','Col 3');
    function suSqlToPDF($sql, $headerArray, $fieldsArray, $outputFileName) {
        global $getSettings;
        $cols = sizeof($headerArray);
        $cols = (95 / $cols);
        $cols = round($cols);
        $title = str_replace('.pdf', '', $outputFileName);
        $title = str_replace('-', ' ', $title);
        $title = strtoupper($title);
        $html = "
      <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
      #TH#
      #TD#
      </table>
      ";
        //--headers
        $th = "";
        $td = "";
        $sr = 0;

        $sql = explode(',', $sql);
        $size = sizeof($sql);

        for ($i = 1; $i <= sizeof($sql) - 1; $i++) {
            $j = $i - 1;
            $th .="<td style=\"background-color:#000;color:#fff;text-align:left;width:{$cols}%\">" . $headerArray[$j] . "</td>";
            $pdfSql.=$sql[$i] . ',';
        }
        $th = "<tr><td style=\"background-color:#000;color:#fff;text-align:left;width:5%;padding:5px;\">Sr.</td>" . $th . "</tr>\n";

        $sql = "SELECT " . substr($pdfSql, 0, -1);

        $result = suQuery($sql);
        foreach ($result['result'] as $row) {
            $sr = $sr + 1;
            $td .= "<tr><td style=\"text-align:left;padding:5px;border-bottom:1px solid #333;\">" . $sr . ". </td>";
            for ($i = 0; $i <= sizeof($fieldsArray) - 1; $i++) {
                //If date, then print date
                if (strstr($fieldsArray[$i], 'Date')) {
                    $row[$fieldsArray[$i]] = date('F d, Y', $row[$fieldsArray[$i]]->sec);
                }
                $td .="<td style=\"text-align:left;padding:5px;border-bottom:1px solid #333;\">" . suUnstrip($row[$fieldsArray[$i]]) . "</td>";
            }
            $td = $td . "</tr>\n";
        }


        $html = str_replace("#TH#", $th, $html);
        $html = str_replace("#TD#", $td, $html);

        // Include the main TCPDF library (search for installation path).
        require_once('../sulata/tcpdf/tcpdf.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($getSettings['site_name']);
        $pdf->SetTitle($title);
        $pdf->SetSubject('');
        $pdf->SetKeywords('');

        // set default header data
        $pdf->SetHeaderData('', '', $title, $getSettings['site_name'], array(0, 0, 0), array(0, 0, 0));
        $pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 11, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled' => false, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));


        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($outputFileName, 'D');
        //============================================================+
        // END OF FILE
        //====================
    }

}
/* Substr */
if (!function_exists('suSubstr')) {

    function suSubstr($string, $length = 30) {
        if (strlen($string) > $length) {
            $string = substr($string, 0, $length) . '..';
            return $string;
        } else {
            return $string;
        }
    }

}

/* make upload path */
if (!function_exists('suMakeUploadPath')) {

    function suMakeUploadPath($basePath) {
        $d = date('d');
        $m = date('m');
        $y = date('Y');
        if (!file_exists($basePath . $y)) {
            mkdir($basePath . $y);
        }
        if (!file_exists($basePath . $y . '/' . $m)) {
            mkdir($basePath . $y . '/' . $m);
        }
        if (!file_exists($basePath . $y . '/' . $m . '/' . $d)) {
            mkdir($basePath . $y . '/' . $m . '/' . $d);
        }
        return $uploadPath = $y . '/' . $m . '/' . $d . '/';
    }

}

//Generate password
if (!function_exists('suGeneratePassword')) {

    function suGeneratePassword() {
        $colors = array('white', 'yellow', 'pink', 'red', 'orange', 'blue', 'green', 'purple', 'brown', 'black');
        $rand = rand(0, sizeof($colors) - 1);
        $rand = $colors[$rand];
        $time = time();
        $time = substr($time, -4);
        $password = $rand . $time;
        return $password;
    }

}
//Upload multiple files
if (!function_exists('suUploadMultiple')) {

    function suUploadMultiple($fileArray) {

        if (!defined('ALLOWED_ATTACHMENTS_MESSAGE')) {
            define('ALLOWED_ATTACHMENTS_MESSAGE', "The following files were not uploaded due to unallowed file formats.\\n\\n %s \\nOnly %s formats are allowed.\\n");
        }
        global $getSettings;
        $error = '';
        $data = array();
        $response = array();
        $allowed_attachment_formats = $getSettings['allowed_attachment_formats'];
        $allowed_attachment_formats2 = explode(',', $allowed_attachment_formats);
        $uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        for ($i = 0; $i <= count($_FILES[$fileArray]['name']); $i++) {
            if (isset($_FILES[$fileArray]['name'][$i]) && ($_FILES[$fileArray]['name'][$i] != '')) {
                $fileName = $_FILES[$fileArray]['name'][$i];
                $src = $_FILES[$fileArray]['tmp_name'][$i];
                if (isset($fileName) && ($fileName != '')) {
                    if (in_array(suGetExtension($fileName), $allowed_attachment_formats2)) {
                        $uid = uniqid();
                        $slugifiedName = suSlugify($fileName, $uid);
                        copy($src, ADMIN_UPLOAD_PATH . $uploadPath . $slugifiedName);
                        $uploadPath . $slugifiedName;
                        array_push($data, $uploadPath . $slugifiedName);
                    } else {
                        $error.="* " . $fileName . "\\n";
                    }
                }
            }
        }
        if ($error != '') {
            $msg = sprintf(ALLOWED_ATTACHMENTS_MESSAGE, $error, $allowed_attachment_formats);
            suPrintJs("alert('" . $msg . "');");
            $error = 'Yes';
        } else {
            $error = 'No';
        }
        $response = array('error' => $error, 'data' => $data);
        return $response;
    }

}

//FTP transfer
if (!function_exists('suFtpDownload')) {

    function suFtpDownload($hostName, $loginId, $password, $sourceFile, $destinationFile, $debug = FALSE) {

        //Set time limit to zero
        set_time_limit(0);

        // set up basic connection
        $conn_id = ftp_connect($hostName);


        // login with username and password
        $login_result = ftp_login($conn_id, $loginId, $password);

        if ($debug == TRUE) {
            // get contents of the current directory
            $contents = ftp_nlist($conn_id, ".");

            // output $contents
            echo "<pre>";
            print_r($contents);
            echo "</pre>";
        }



        // try to download $sourceFile and save to $destinationFile
        if (ftp_get($conn_id, $destinationFile, $sourceFile, FTP_BINARY)) {
            return TRUE;
        } else {
            return FALSE;
        }


// close the connection
        ftp_close($conn_id);
    }

}

if (!function_exists('suFtpUpload')) {

    function suFtpUpload($hostName, $loginId, $password, $sourceFile, $destinationFile, $debug = FALSE) {
        $ftp_server = $hostName;
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $loginId, $password);
        if ($debug == TRUE) {
            // get contents of the current directory
            $contents = ftp_nlist($ftp_conn, ".");

            // output $contents
            echo "<pre>";
            print_r($contents);
            echo "</pre>";
        }
        $file = $sourceFile;

// upload file
        if (ftp_put($ftp_conn, $destinationFile, $file, FTP_BINARY)) {
            return TRUE;
        } else {
            return FALSE;
        }

// close connection
        ftp_close($ftp_conn);
    }

}