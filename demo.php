<?php require 'lib/Nijikodo/Parser.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Nijikodo demo page</title>
    <link href="css/default.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .niji_code { width: 650px; }
        h2.samples { margin-top: 50px; }
    </style>
</head>
<body>
<h1>nijikodo</h1>
<p>by <a href="http://www.craigiam.com">craig campbell</a></p>
<p>
    Nijikodo is an object oriented code syntax highlighting library written in PHP.<br />
    Current supported languages include CSS, HTML, JavaScript, and PHP.  The generic regex patterns work for other languages as well.
</p>


<!-- usage instructions - view this part in a browser not as raw source -->
<h2>requirements</h2>
<p>php 5.3</p>

<h2>usage</h2>
<p>to install put the lib directory somewhere in your include path:</p>
<?php Nijikodo\Parser::captureStart(); ?>
{code:php}
require 'lib/Nijikodo/Parser.php';

// you can optionally set a css class prefix (defaults to 'niji_')
Nijikodo\Parser::setCssPrefix('code_');
{code}

<p>to syntax highlight code from a form field:</p>
{code:php}
$text = $_POST['text'];
$text = Nijikodo\Parser::process($text);
{code}

<p>use these special tags in the form field to specify that this block of text is code:</p>
{code:text}
&#123;code:language|height:200&#125;
// this is where the code goes
&#123;code&#125;
{code}

<p>this can also be done directly in a view using output buffering like so:</p>
{code:html}
<!-- begin capturing code -->
&lt;?php Nijikodo\Parser::captureStart(); ?&gt;
{code}
{code:text}
&#123;code:javascript&#125;
// code goes here
&#123;code&#125;
{code}
{code:html}
<!-- output what has been captured -->
&lt;?php echo Nijikodo\Parser::output(); ?&gt;
{code}

<p>additionally if you have a string that you already know is a specific type of code you can do this:</p>
{code:php}
$string = '&lt;p&gt;this is my string&lt;/p&gt;';
$html_string = Nijikodo\Parser::toHtml($string, 'html');
{code}

<p>finally if you would like to run your string through some other functions you can tokenize the code blocks and fill them back in later</p>
{code:php}
$text = $_POST['text'];
$text = Nijikodo\Parser::tokenizeCodeBlocks($text);
$text = nl2br($text);
$text = Nijikodo\Parser::replaceTokens($text);
{code}







<!-- samples -->
<h2 class="samples">samples</h2>


<!-- php code sample -->
<h3>php</h3>
{code:php}
// this is some sample php code
$i = 0;
for ($i = 0; $i < 25; ++$i) {
    echo $i;
}

function customFunction()
{
    return mt_rand(1, 100);
}

$fruits = array('banana', 'strawberry', 'blueberry', 'apple', 'blackberry');

asort($fruits);

foreach ($fruits as $key => $value) {
    echo $value;
}
{code}




<!-- javascript code sample -->
<h2>javascript</h2>
{code:javascript}
// open external links in a new window using jquery
$(document).ready(function() {
    $("a[rel='external']").live("click", function() {
        $(this).attr("target", "_blank");
    });
});
{code}




<!-- html code sample -->
<h2>html</h2>
{code:html}
<!-- html with php inside of it! -->
<ul class="user_list">
    &lt;?php foreach ($this->users as $user): ?&gt;
        <li><a href="&lt;?php echo $user->getUrl(); ?&gt;">&lt;?php echo $user->getName(); ?&gt;</a></li>
    &lt;?php endforeach; ?&gt;
</ul>
{code}




<!-- css code sample (limit to 300 pixel height) -->
<h2>css</h2>
{code:css|height:300}
/* css used for this demo */
.niji_code {
    font-family: 'monaco', courier, monospace;
    font-size: 11.5px;
    overflow: auto;
    margin-top: 10px;
    margin-bottom: 10px;
    padding: 10px;
    background: #03050A;
    color: #fff;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    white-space: pre-wrap;
}

.niji_html {
    color: #7F90AA;
}

.niji_keyword, .niji_define {
    color: #FBDE2D;
}

.niji_int {
    color: #D8FA3C;
}

.niji_comment {
    color: #E40700;
}

.niji_class, .niji_function {
    color: #8DA6CE;
}

.niji_string {
    color: #61CE3C;
}

.niji_default {
    color: #fff;
}

.niji_tag {
    color: #7F90AA;
}

.niji_method {
    color: #FF6400;
}

{code}
<?php echo Nijikodo\Parser::output(); ?>
</body>
</html>