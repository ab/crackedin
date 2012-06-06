<?php
if (count($_POST)) {
  $dumpfile = "linkedin.sha1.txt";

  $hash = $_POST['hash'];
  if (!ctype_alnum($hash)) {
    die('Invalid hash.');
  }
  $hash = strtolower($hash);

  $hash_truncated = '00000' . substr($hash, 5);

  $regex = "^($hash)|($hash_truncated)$";

  $retval = null;
  $output = null;
  exec("grep -E '$regex' '$dumpfile'", $output, $retval);
  if ($retval == 0) {
    $hash_found = true;
  } elseif ($retval == 1) {
    $hash_found = false;
  } else {
    die("ERROR");
  }

  if ($hash_found) {
    die("FOUND: " . $output[0]);
  } else {
    die("NOT found: $hash");
  }
}
?>
<!doctype html>
<html>
  <head>
    <title>CrackedIn -- LinkedIn leaked password checker</title>
    <script src="./sha1.js"></script>
    <script>
      function rehash() {
        password = document.getElementById('password').value;
        hash = CryptoJS.SHA1(password);
        document.getElementById('hash').value = hash;
        document.getElementById('hashlabel').innerHTML = hash;
        document.getElementById('submit').disabled = false;
      }
    </script>
  </head>
  <body>
    <form action="." method="post">
      <input id="password" type="password" name="password" placeholder="LinkedIn password" onchange="rehash()">
      <input id="hash" type="hidden" name="hash">
      <br />
      <p>Hash: <tt id="hashlabel"></tt></p>
      <input id="submit" type="submit" name="submit" value="Submit to Server" disabled=1>
    </form>
  </body>
</html>
<!-- vim: set ts=2 sw=2 : -->
