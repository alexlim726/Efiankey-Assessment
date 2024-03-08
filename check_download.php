<?php
session_start();

if(isset($_GET['memberType'])){
 echo checkDownload($_GET['memberType']); // Change member type as needed
  
}
if(isset($_POST['reset'])){
    session_unset();
    header("Location: Question1.html");
   }

function checkDownload($memberType) {
    $currentTime = time();
    $clockFormat = date('H:i:s', $currentTime);
    if ($memberType == "member"){ 
        /* Member Access */
        if (!isset($_SESSION['memberdownloadcount'])) {
            // Set the last download time if not set
            $_SESSION['memberdownloadcount'] = 1;
        }else{
            $_SESSION['memberdownloadcount'] = $_SESSION['memberdownloadcount']+ 1 ;
            if ($_SESSION['memberdownloadcount'] > 2) {   
                $lastDownloadTime = $_SESSION['last_member_download_time'];
                $timeDifference = $currentTime - $lastDownloadTime;
                if ($timeDifference < 5) {
                    return "Too many downloads\n". $clockFormat;
                }else{
                    $_SESSION['memberdownloadcount'] = 1;
                }
            }else{
               if($_SESSION['memberdownloadcount'] == 2) {
                if(!isset($_SESSION['last_member_download_time'])) {
                    $_SESSION['last_member_download_time'] = $currentTime;
                }else{
                    $_SESSION['last_member_download_time'] = $currentTime;
                }
               }
            }
        }
    }
    else{
        if (!isset($_SESSION['last_download_time'])) {
                // Set the last download time if not set
                $_SESSION['last_download_time'] = time();
            } else {
                // Check if the user is trying to download again within 5 seconds
                
                $lastDownloadTime = $_SESSION['last_download_time'];
                $timeDifference = $currentTime - $lastDownloadTime;
                
                if ($timeDifference < 5) {
                   return "Too many downloads\n". $clockFormat;
                } 
                
                else {
                    // Update the last download time
                    $_SESSION['last_download_time'] = $currentTime;
                }
            }
    }
    
    // Return appropriate response based on member type
    if ($memberType == 'member') {
        
        return "Member, Your download is starting...\n".$clockFormat;
    } else {
       return "Non-member, Your download is starting...\n".$clockFormat;
    }
}

?>
