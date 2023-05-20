
  
$url = "https://frase.ai" . $_SERVER["REQUEST_URI"];
// Private web proxy script by Heiswayi Nrird (http://heiswayi.github.io)
// Released under MIT license
// Free Software should work like this: whatever you take for free, you must give back for free.

ob_start("ob_gzhandler");

if (!function_exists("curl_init")) die ("This proxy requires PHP's cURL extension. Please install/enable it on your server and try again.");

//Adapted from http://www.php.net/manual/en/function.getallheaders.php#99814
if (!function_exists("getallheaders")) {
  function getallheaders() {
    $result = array();
    foreach($_SERVER as $key => $value) {
      if (substr($key, 0, 500) == "HTTP_") {
        $key = str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
        $result[$key] = $value;
      } else {
        $result[$key] = $value;
      }
    }
    return $result;
  }
}

//define("PROXY_PREFIX", "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER["SERVER_NAME"] . ($_SERVER["SERVER_PORT"] != 80 ? ":" . $_SERVER["SERVER_PORT"] : "") . $_SERVER["SCRIPT_NAME"] . "/");

//Makes an HTTP request via cURL, using request data that was passed directly to this script.
function makeRequest($url) {

  //Tell cURL to make the request using the brower's user-agent if there is one, or a fallback user-agent otherwise.
 // $user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.119 Safari/537.36";
  
  $ch = curl_init();
//  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

  //Proxy the browser's request headers.
  $browserRequestHeaders = getallheaders();
  //(...but let cURL set some of these headers on its own.)
  //TODO: The unset()s below assume that browsers' request headers
  //will use casing (capitalizations) that appear within them.
  unset($browserRequestHeaders["Host"]);
  unset($browserRequestHeaders["Content-Length"]);
  //Throw away the browser's Accept-Encoding header if any;
  //let cURL make the request using gzip if possible.
  unset($browserRequestHeaders["Accept-Encoding"]);
 // curl_setopt($ch, CURLOPT_ENCODING, "");
  //Transform the associative array from getallheaders() into an
  //indexed array of header strings to be passed to cURL.
  $curlRequestHeaders = array();
  foreach ($browserRequestHeaders as $name => $value) {
    $curlRequestHeaders[] = $name . ": " . $value;
  }
//   curl_setopt($ch, CURLOPT_HTTPHEADER, $curlRequestHeaders);

  //Proxy any received GET/POST/PUT data.
  switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
      $getData = array();
      foreach ($_GET as $key => $value) {
          $getData[] = urlencode($key) . "=" . urlencode($value);
      }
      if (count($getData) > 0) {
        //Remove any GET data from the URL, and re-add what was read.
        //TODO: Is the code in this "GET" case necessary?
        //It reads, strips, then re-adds all GET data; this may be a no-op.
        $url = substr($url, 0, strrpos($url, "?"));
        $url .= "?" . implode("&", $getData);
      }
    break;
    case "POST":
      curl_setopt($ch, CURLOPT_POST, true);
      //For some reason, $HTTP_RAW_POST_DATA isn't working as documented at
      //http://php.net/manual/en/reserved.variables.httprawpostdata.php
      //but the php://input method works. This is likely to be flaky
      //across different server environments.
      //More info here: http://stackoverflow.com/questions/8899239/http-raw-post-data-not-being-populated-after-upgrade-to-php-5-3
      curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents("php://input"));
    break;
    case "PUT":
      curl_setopt($ch, CURLOPT_PUT, true);
      curl_setopt($ch, CURLOPT_INFILE, fopen("php://input"));
    break;
  }
  

    // $cookie = '/home/toolszmc/plustools.net/panel/auth/curl/toolszap.txt';
  
    $agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.119 Safari/537.36";
  //Other cURL options.
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5000000);
    // curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
    // curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    // curl_setopt ($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $curlRequestHeaders);


//  curl_setopt($ch, CURLOPT_COOKIE, "host=plustools.net; km_ni=jadersondapaz1@gmail.com; km_lv=x; km_ai=jadersondapaz1@gmail.com; __utmz=222526621.1621854618.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __adroll_fpc=eb92861e23e1f95b848447831661dde0-1621854619455; __ar_v4=LJZZ2FR4DBF6VBE3Y6JRRQ:20210523:6|XZKOSCTQYNAN7GPG77G4CP:20210523:23|R66JUCUFRZCG5AJHMQEGA4:20210523:23|KADNOU2AURG7HNUPOYHPUW:20210523:17; __utma=222526621.1524567690.1621854618.1621861365.1621867016.3; _ga=GA1.1.1457956668.1624391945; _jsuid=1793719557; remember_user_token=eyJfcmFpbHMiOnsibWVzc2FnZSI6Ilcxc3pNREExTlROZExDSWtNbUVrTVRJa2N6VnBRMVowZWpaTFptbG1NVVpRZWpkdGRYWjJkU0lzSWpFMk1qUTRPRFkyTnpVdU1qY3pORFF4TXlKZCIsImV4cCI6IjIwMjEtMDctMTJUMTM6MjQ6MzUuMjczWiIsInB1ciI6ImNvb2tpZS5yZW1lbWJlcl91c2VyX3Rva2VuIn19--64c68d469a6895eaf4347861b8029bc57c55f335; _wordai_rails_session=TtiLLwb3Kae6JW8bcI0ffQZe91UKaXEppUqyH2BfLHJtwGpOtaShFfAtye72f4OYwMjnmEuUMFPgIRB+kYOm+Vw2PhXTTn4GfBnJ/A1vtwQXj15uLd7s314Wmi44aTw/l16YOPdXllZGxmX0Am0BkxYowjOuimlgqvUodVERiH9gDrJu+S36pNOC6Df+XxQMpmUnZsotu8SBNmiXUWgeMF+LuRtPyXJOrmqlXR3SpZAk4vbfEP++7rYuV5eHJ79IGyPZckfWCL679rmIvDklwEuCegw0lLU3YvaRtM5LTweb3bNmrbg6u5JlaKoIbH4Vycu4mrAkWinufAPKx2ne6ULcslsMB3uMvThwu+y0WYG+dty0RAWA6pWoUDVEyORcJpQvBdEAH7BaC5iLxYyArtyn5LeU--OQZMzRqRy3QEcy5N--Ph6mjd3Xpwet5OsNIVMN2A==; _ga_J6KTZN2VVY=GS1.1.1624950055.13.1.1624950056.0; kvcd=1624950056083; km_vs=1");

  //Set the request URL.
  curl_setopt($ch, CURLOPT_URL, $url);

  //Make the request.
  $response = curl_exec($ch);
  $responseInfo = curl_getinfo($ch);
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  curl_close($ch);

  //Setting CURLOPT_HEADER to true above forces the response headers and body
  //to be output together--separate them.
  $responseHeaders = substr($response, 0, $headerSize);
  $responseBody = substr($response, $headerSize);

  return array("headers" => $responseHeaders, "body" => $responseBody, "responseInfo" => $responseInfo);
}

//Converts relative URLs to absolute ones, given a base URL.
//Modified version of code found at http://nashruddin.com/PHP_Script_for_Converting_Relative_to_Absolute_URL
function rel2abs($rel, $base) {
  if (empty($rel)) $rel = ".";
  if (parse_url($rel, PHP_URL_SCHEME) != "" || strpos($rel, "//") === 0) return $rel; //Return if already an absolute URL
  if ($rel[0] == "#" || $rel[0] == "?") return $base.$rel; //Queries and anchors
  extract(parse_url($base)); //Parse base URL and convert to local variables: $scheme, $host, $path
  $path = isset($path) ? preg_replace('#/[^/]*$#', "", $path) : "/"; //Remove non-directory element from path
  if ($rel[0] == '/') $path = ""; //Destroy path if relative url points to root
  $port = isset($port) && $port != 80 ? ":" . $port : "";
  $auth = "";
  if (isset($user)) {
    $auth = $user;
    if (isset($pass)) {
      $auth .= ":" . $pass;
    }
    $auth .= "@";
  }
  $abs = "$auth$host$path$port/$rel"; //Dirty absolute URL
  for ($n = 1; $n > 0; $abs = preg_replace(array("#(/\.?/)#", "#/(?!\.\.)[^/]+/\.\./#"), "/", $abs, -1, $n)) {} //Replace '//' or '/./' or '/foo/../' with '/'
  return $scheme . "://" . $abs; //Absolute URL is ready.
}

//Proxify contents of url() references in blocks of CSS text.
function proxifyCSS($css, $baseURL) {
  return preg_replace_callback(
    '/url\((.*?)\)/i',
    function($matches) use ($baseURL) {
        $url = $matches[1];
        //Remove any surrounding single or double quotes from the URL so it can be passed to rel2abs - the quotes are optional in CSS
        //Assume that if there is a leading quote then there should be a trailing quote, so just use trim() to remove them
        if (strpos($url, "'") === 0) {
          $url = trim($url, "'");
        }
        if (strpos($url, "\"") === 0) {
          $url = trim($url, "\"");
        }
        if (stripos($url, "data:") === 0) return "url(" . $url . ")"; //The URL isn't an HTTP URL but is actual binary data. Don't proxify it.
        //return "url(" . PROXY_PREFIX . rel2abs($url, $baseURL) . ")";
    },
    $css);
}

// // Create log
// function recordLog($url) {
//   $userip = $_SERVER['REMOTE_ADDR'];
//   $rdate = date("d-m-Y", time());
//   $data = $rdate.','.$userip.','.$url.PHP_EOL;
//   $logfile = 'logs/'.$userip.'_log.txt';
//   $fp = fopen($logfile, 'a');
//   fwrite($fp, $data);
// }

// recordLog($url);
//cURL can make multiple requests internally (while following 302 redirects), and reports
//headers for every request it makes. Only proxy the last set of received response headers,
//corresponding to the final request made by cURL for any given call to makeRequest().


//$proxy_prefix = PROXY_PREFIX;

$htmlcode = <<<ENDHTML
<style>.absolute.bottom-0.left-0.bg-white.w-80 {display: none;} #app > div:nth-child(1) > div:nth-child(1) > div > div:nth-child(3) > div.fixed.top-0.z-40.w-screen.bg-white.lg\:hidden.bottom-16.sm\:w-80.ring-1.ring-gray-100 > div.bg-white { display: none;}.grid.grid-cols-1.gap-4.xl\:grid-cols-3 {display: none;}.text-2xl.font-bold.tracking-tight.text-white {display: none;}button.flex.items-center.px-4.py-2.space-x-2.font-semibold.text-indigo-700.bg-indigo-100.ring-1.ring-indigo-200.selectionRing.rounded-xl {display: none;}button.relative.w-full.p-8.text-center.transition-all.duration-200.bg-blue-400.border-b.border-white.rounded-md.cursor-pointer.selectionRing.hover\:bg-blue-300.border-opacity-10.mb-6 {display: none;}
.flex.min-h-screen.bg-white {
    margin: 0 20%;
}

#app > div:nth-child(1) > div:nth-child(2) > div.fixed.z-30.hidden.xl\:block.bottom-5.right-5 {
    display: none;
}
</style>


<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Button used to open the chat form - fixed at the bottom of the page */
.open-button {
    background-color: rgb(0 81 165);
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    opacity: 0.8;
    font-size: 16px;
    position: fixed;
    bottom: 23px;
    right: 28px;
    width: 200px;
}

/* The popup chat - hidden by default */
.chat-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width textarea */
.form-container textarea {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
  resize: none;
  min-height: 200px;
}

/* When the textarea gets focus, do something */
.form-container textarea:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/send button */
.form-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
    background-color: rgb(47 55 72);
    font-size: 16px;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>
</body>
ENDHTML;

/**/
// $url = "https://tool3.toolszap.com" . $_SERVER["REQUEST_URI"];
/**/

/**/
if (empty($url)){
    /**/
    die($htmlcode);
    /**/
}

/**/
if (strpos($url, "//") === 0){
    /**/
    $url = "http:" . $url; // assume that any supplied URLs starting with // are HTTP URLs.
    /**/
} 

/**/
if (!preg_match("@^.*://@", $url)){
    /**/
    $url = "http://" . $url; // assume that any supplied URLs without a scheme are HTTP URLs.
    /**/
} 

/**/
$response = makeRequest($url);
/**/
$rawResponseHeaders = $response["headers"];
/**/
$responseBody = $response["body"];
$responseInfo = $response["responseInfo"];
/**/
$responseHeaderBlocks = array_filter(explode("\r\n\r\n", $rawResponseHeaders));
/**/
$lastHeaderBlock = end($responseHeaderBlocks);
/**/
$headerLines = explode("\r\n", $lastHeaderBlock);
/**/

/**/
foreach ($headerLines as $header){
    /**/
    if (stripos($header, "Content-Length") === false && stripos($header, "Transfer-Encoding") === false){
        /**/
        header($header);
        /**/
    }
}

/**/
$contentType = $responseInfo["content_type"] ?? "text/html";
/**/

$responseBody = str_replace('app.jarvis.ai', 'jar.toolszm.com', $responseBody);

// $responseBody = str_replace('/css/', 'https://app.jarvis.ai/css/', $responseBody);

$responseBody = str_replace('app.peppertype.ai', 'get.plustools.net', $responseBody);

$responseBody = str_replace('<link href=/js/chunk-vendors.js rel=preload as=script>', '<link href="/js/chunk-vendors.js" rel="preload" as="script"><script src="/js/chunk-run-vendors.js"></script>', $responseBody);

$responseBody = str_replace('</body>', $htmlcode, $responseBody);

/**/
if (stripos($contentType, "application/json") !== false){
    /**/
    $responseBody = str_replace('href="/', 'href="https://ahrefs.com/', $responseBody);
    /**/
    $responseBody = str_replace('src="/', 'src="https://ahrefs.com/', $responseBody);
    /**/
    echo $responseBody;
    /**/
}
else if (stripos($contentType, "application/css") !== false){ 
    /**/
    echo proxifyCSS($responseBody, $url); // this is CSS, so proxify url() references.
    /**/
}
else {
    /**/
    /**/
  

    echo $responseBody;

    /**/
}
