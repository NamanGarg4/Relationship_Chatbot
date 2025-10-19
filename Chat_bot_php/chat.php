<?php
session_start();
header('Content-Type: application/json');
include 'responses.php';

$userMsg = strtolower(trim($_POST['message']));
$person = $_SESSION['person'];
$mood = $_SESSION['mood'];
$reply = "";

// ----------------------
// Predictive replies using if-else
// ----------------------

if (in_array($userMsg, ["hi","hello","hey"])) {
    if ($mood=="angry") $reply="Oh, so now you greet me?";
    elseif ($mood=="happy") $reply="Heyyy! I missed you!";
    elseif ($mood=="sad") $reply="Hey... I wasn’t expecting you.";
    else $reply="Hello. You seem different today.";

} elseif (strpos($userMsg,"how are you")!==false) {
    if ($mood=="happy") $reply="I’m feeling great, especially now that we’re talking!";
    elseif ($mood=="sad") $reply="Not the best... but I’m glad you checked in.";
    elseif ($mood=="angry") $reply="How do you think I am?!";
    else $reply="I’m okay, just thinking about you.";

} elseif (strpos($userMsg,"love you")!==false) {
    if ($person=="girlfriend"||$person=="wife") $reply="Aww, I love you more! ❤️";
    elseif ($person=="boyfriend"||$person=="husband") $reply="I love you too, always and forever.";
    elseif ($person=="mother") $reply="Aww, I love you too, my dear child.";
    elseif ($person=="father") $reply="Love you too, son/daughter.";
    else $reply="That's so sweet!";

} elseif (strpos($userMsg,"miss you")!==false) {
    if ($person=="girlfriend") $reply="I missed you too! Can’t wait to see you again ❤️";
    elseif ($person=="boyfriend") $reply="I missed you more than words can say.";
    elseif ($person=="mother") $reply="Mommy missed you too!";
    elseif ($person=="father") $reply="I missed you as well. Come visit soon!";
    else $reply="I missed you too!";

} elseif (strpos($userMsg,"sorry")!==false) {
    if ($mood=="angry") $reply="Hmm... I’ll forgive you, but think twice next time.";
    elseif ($mood=="sad") $reply="It’s okay, I know you didn’t mean it.";
    else $reply="No worries!";

} elseif (strpos($userMsg,"bye")!==false || strpos($userMsg,"goodbye")!==false) {
    if ($mood=="happy") $reply="Aww, leaving already? Talk soon!";
    elseif ($mood=="sad") $reply="Bye... take care, okay?";
    else $reply="Bye then, stay safe!";

} elseif (strpos($userMsg,"what are you doing")!==false) {
    $reply="Just chatting with you 😊 What about you?";

} elseif (strpos($userMsg,"where are you")!==false) {
    $reply="I’m right here talking to you!";

} elseif (strpos($userMsg,"name")!==false) {
    $reply="I’m your " . $person . "! Who else would I be? 😄";

} elseif (strpos($userMsg,"do you miss me")!==false) {
    if ($mood=="sad") $reply="Of course... I’ve been missing you all day!";
    else $reply="Yes! Can’t wait to see you again ❤️";

} elseif (strpos($userMsg,"joke")!==false) {
    $reply="Why don’t scientists trust atoms? Because they make up everything 😄";

} elseif (strpos($userMsg,"thank")!==false) {
    $reply="You’re always welcome!";

} else {
    if (isset($responses[$person][$mood])) {
        $options = $responses[$person][$mood];
        $reply = $options[array_rand($options)];
    } else {
        $reply="I’m listening... tell me more.";
    }
}

// Save chat in session
$_SESSION['chat_history'][] = ['user', htmlspecialchars($_POST['message'])];
$_SESSION['chat_history'][] = ['bot', $reply];

echo json_encode(['reply'=>$reply]);
