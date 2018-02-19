<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>audio.date</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div style="position: fixed; right: 0; bottom:0; background-color: rgba(230, 230, 230, 70%); padding: 5px; max-width: 100px; z-index: 100;">TODO:<br> - Make Design not shit</div>
        <?php
        
        $episode_names = [];
        $timestamp = [];
        $series_names = [];
        
        function list_series($file_array, &$episode_names, &$timestamp, &$series_names) {
            foreach ($file_array as $key => $file) {
                
                $pattern = "/(?:audio\/\[.+?\] )(.+? -? ?\d{2})(?:.+)/i";
                $replacement ="$1";
                $title_ep = preg_replace($pattern, $replacement, $file);
                $episode_names[$key] = $title_ep;
                
                $pattern2 = "/(?:.+?-\[)(.+?)-(.+?)(?:\]-audio.mp3)/i";
                $replacement2 ="$1-$2";                
                $timestamp[$title_ep.$key] = str_replace("-"," - ", str_replace("_", ":", preg_replace($pattern2, $replacement2, $file)));

                }        
        }
        
        function generate_series_index(&$episode_names, &$timestamp, &$series_names) {
             foreach ($episode_names as $key => $title) {
                $pattern = "/(.*?)(?: - \d{2}\d?)/i";
                $replacement = "$1";
                $series_names[$key] = preg_replace($pattern, $replacement, $title);
                
            }
            
            $frequency = array_count_values($series_names);
            $series_names = array_unique($series_names);
            asort($series_names);
            
            echo "<div class='series_filter'> <h4 style='color:#f2f2f2; margin-left:10px; margin-top:0px; margin-bottom:0px;'>Filter by Series:</h4> <a href='index.php'><div class='series_filter_button' style='background-color:#832B00'><b>Back to all Series</b></div>"
            . "<a href='index.php?audio=upload'><div class='series_filter_button' style='background-color:#832B00'><b>Upload</b></div></a>";
            
            foreach ($series_names as $series_names) {
                echo "<a href='index.php?audio=".$series_names."'><div class='series_filter_button'>".$series_names." (".$frequency[$series_names].")</div></a>";
            }
            
            echo "</div>";
        }
            
        function display_audioboxes($file_array, &$episode_names, &$timestamp, &$series_names) {
            foreach ($file_array as $key => $file) {        
                echo "<div class='container'><div class='videobox'><video id='video".$episode_names[$key]."' muted>
<source src='webm/".substr($file,6,-4).".webm' type='video/webm'></source></video></div><div class='audiobox'><h3>".$episode_names[$key]."<br>".$timestamp[$episode_names[$key].$key]."</h3><br><audio class='audio' controls><source src='".$file."' type='audio/mp3'>Your browser does not support the audio tag.</div>"
                        . "<a class='download_button_mp3' href='".$file."'><img src='mp3.png'></a>"
                        . "<a class='download_button_ogg' href='audio/".substr($file,6,-4).".ogg'><img src='ogg.png'></a>"
                        . "<a class='download_button_webm' href='webm/".substr($file,6,-4).".webm'><img src='webm.png'></a> </div>";
            }
                
        }
        
        
            $all_files = glob("audio/*.mp3");
            list_series($all_files, $episode_names, $timestamp, $series_names);
            generate_series_index($episode_names, $timestamp, $series_names);
            
            if(empty($_GET['audio'])) {            
                display_audioboxes($all_files, $episode_names, $timestamp, $series_names);
            }
            elseif($_GET['audio'] === "upload") {
                include 'upload.php';
                
            }
            
            else {
                $needle = $_GET['audio'];
                $series_files = array_filter($all_files, function($var) use ($needle) {return preg_match("/".$needle."/i", $var);});
                display_audioboxes($series_files, $episode_names, $timestamp, $series_names);    
               
            }        
        
        
        ?>
    </body>
</html>
