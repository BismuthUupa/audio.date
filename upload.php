<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>audio.date</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div style="width:100%; height:200px; display: block;"></div>
        
        <div class="uploadfield">
        <?php
            $valid_formats = array("webm");
            $max_file_size = 1024*8000; 
            $path = "to_review/"; 
            $count = 0;

            if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
                    // Loop $_FILES to execute all files
                    foreach ($_FILES['webbum']['name'] as $f => $name) {     
                        if ($_FILES['webbum']['error'][$f] == 4) {
                            continue; 
                        }	       
                        if ($_FILES['webbum']['error'][$f] == 0) {	           
                            if ($_FILES['webbum']['size'][$f] > $max_file_size) {
                                $message[] = $name." is over 8MB c'mon what the fuck";
                                continue; 
                            }
                                    elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                                            $message[] = $name." is not a webbum you troglodyte";
                                            continue; // Skip invalid file formats
                                    }
                            else{ // No error found! Move uploaded files 
                                        if (move_uploaded_file($_FILES["webbum"]["tmp_name"][$f], $path . $name)) {
                                $count++;
                            } // Number of successfully uploaded file
                            }
                        }
                    if(!empty($message)){    
                        var_dump($message);
                        }
                    }
                    
                    echo $count." webbums successfully uploaded. I will check them, correct the file syntax for you and they should be available!";
                    mail("uupa@animu.date", $count." neue Uploads", "check sie fagget");
            }
        ?>
        
        <form id="webbumupload" method="POST" enctype="multipart/form-data">
            <h3>Max Uploads: <b>20</b>; Max Filesize: <b>5 MB</b></h3>    
        Now gimme your webbums: <input type="file" id="webbum" name="webbum[]" multiple><br/>

        <div id="selectedWebbum"></div>

        <input type="submit">
	</form>

	<script>
	var selDiv = "";
		
	document.addEventListener("DOMContentLoaded", init, false);
	
	function init() {
		document.querySelector('#webbum').addEventListener('change', handleFileSelect, false);
		selDiv = document.querySelector("#selectedWebbum");
	}
		
	function handleFileSelect(e) {
		console.dir(e);
		
		if(!e.target.files) return;
		
		selDiv.innerHTML = "";
		
		var webbum = e.target.files;
		for(var i=0; i<webbum.length; i++) {
			var f = webbum[i];
			
			selDiv.innerHTML += f.name + "<br/>";

		}
		
	}
	</script>
        </div>
        
        <div class="pureasuandastand">
            <h1>Pureasu Andastand <br>(read this or uploads won't work)</h1>
            <div class="guide">
                This Website parses Webms in a folder using weapon-grade Autism (Regular Expressions) and - just like you and me - they are very frail.<br>
                Since I want to provide episode number and timestamp, webms straight from the chonz won't cut it - please get mpv or whatever and actually make your own Webms from torrented chinese cartoons.<br><br>
                <b>PROTIP: If you know what you're doing, you can also rename your Webms to adhere to this Format:</b><br><br>
                Legend:<br>
                <span class="green">Green: Anything goes here</span><br>
                <span class="violet">Violet: Specific Structure like 2 digits or the timestamp</span><br>
                <span class="red">Red: Shit the Regex looks out for</span><br>
            <div class="code">
                                
                <span class="red">[</span>
                <span class="green">Subgroup</span>
                <span class="red">]</span>
                <span class="green"> Anime Title </span>
                <span class="violet">- 06</span>
                <span class="green"> (Channel Info, Format, Audio, Codec...)</span>
                <span class="red">-[</span>
                <span class="violet">06_23.633</span>
                <span class="red">-</span>
                <span class="violet">06_25.802</span>
                <span class="red">]-audio.webm</span>
                
            </div>
            And yes, this is the name output I use and you'll do it to since I am fucking lazy.
            <a href="filenames_example.gif"><img src="filenames_example.gif" height="100px"></a>
            <h3>But how? (also a guide on snatching webms INSIDE mpv)</h3>
            This will describe my webm setup for everyone who has absolutely no clue what they're doing. Everyone else should maybe just fit their filename output to the example above.
            <ol>
                <li>Download mpv from <a href="https://mpv.io/installation/">here.</a> On my Debian machine it also just werks if you apt-get install mpv.</li>
                <li>If you are lazy, you can just download <a href="mpv.7z">my config files</a> and put them to the appropriate places. <br>That's C:\Users\[YourNameHere]\AppData\Roaming\mpv on Botnet, and any Linux user should be used to google "mpv config".<br><br>
                    That 7z-File (I really hope you don't use WinRAR, otherwise <a href="https://www.google.de/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwjUydrNoK3ZAhUL1oMKHQVLCvIQFggpMAA&url=http%3A%2F%2Fwww.7-zip.org%2Fdownload.html&usg=AOvVaw093b_2uxEUUZwqIe_APr6Y">thank me later</a>) also contains some .lua scripts I like a lot.</li><br>
                <li>So you don't trust my 7z, that's totally fine since the controls are fit to my computer. Read on. For the others the guide is over.</li><br>
                <li>You'll want to grab <a href="https://github.com/ElegantMonkey/mpv-webm">WebM-Maker by ElegantMonkey</a> and put that into your mpv conf folder under "/scripts/"</li>
                <li>Change the output-directory (Line 12) to your liking, I put "~/webm" which puts it into my User-folder even on Botnet 10.</li>
                <li><h2>The output Format String (Line 21) should be %F-[%s-%e]%M</h2></li>
                <li>Now all you have to do to record WebM WHILE watching animu is press SHIFT+W, define Start and End with "1" and "2", crop with c and mouse-input, and then encode. You can always enhance your results by putting in some time and reading up on it!</li>
                <li>The "-audio" appended to the filename will disappear when you mute the video, which will make WebM-Maker encode the WebM without sound, for all your shitposting needs.</li>    
            </ol>
            Now wasn't that fun and easy?<br>
            <img src="http://animu.date/sicp/[Tsundere]%20Renkin%20San-Kyuu%20Magical%20Pokaan%20-%2012%20[DVDRip%20h264%20768x576%20FLAC][B6355B0D]%20-%2000_01_49.817n.jpg">
            </div>
            
        </div>
    </body>
</html>
