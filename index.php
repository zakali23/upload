
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
  <?php
  if(isset($_POST['envoyer'])) {
    $dossier = 'img/';
    $fichier = $_FILES['upload']['name'];
    $taille_maxi = 1000000;
    $fichier_temp = $_FILES['upload']['tmp_name'];
    $taille = $_FILES['upload']['size'];
    $extensions = array('.jpg', '.jpeg', '.png','.gif');


    // on compte le nombre de fichier envoyés
    $nbfichiersEnvoyes = count($fichier_temp);

    for($i=0; $i<$nbfichiersEnvoyes; $i++) {

      //Début des vérifications de sécurité...
      if(!in_array(strrchr($fichier[$i], '.'), $extensions)) //Si l'extension n'est pas dans le tableau

      {
        $error = '<span>Vous devez uploader un fichier de type JPEG ou JPG, PNG, GIF</span></br>';
      }
      if($taille[$i]>$taille_maxi)
      {
        $error = 'Le fichier est trop gros...';
      }
      if(!isset($error)) //S'il n'y a pas d'error, on upload
      {
        $ext = uniqid().strrchr($fichier[$i], '.');
        $pathImg = 'img/image'.$ext;


        if(move_uploaded_file($fichier_temp[$i],$pathImg )) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
        {
          echo "<div class=\"alert alert-success\" role=\"alert\">Upload effectué avec succès !</div></br>";

        }
        else //Sinon (la fonction renvoie FALSE).
        {
          echo '<span class="non">Echec de l\'upload !</span>';

        }
      }
      else
      {
        echo "<div class=\"alert alert-danger\" role=\"alert\">".$error." </div>";
      }
    }
  }

  ?>
  <div class="col-lg-12">
    <div class="form-group">
      <form method="POST" action="index.php" enctype="multipart/form-data">
        <label for="exampleInputFile">Ajouter des photos</label>
        <input type="file" name="upload[]"id="exampleInputFile" multiple = "multiple" />
        <p class="help-block"></p>
        <input type="submit" name="envoyer" value="Envoyer">
      </form>
    </div>
  </div>
  <div class="row">
<?php
$images = 'img/';
$files = scandir($images);

for ($i=2; $i < count($files) ; $i++) {

  if (isset ($_POST[$i])) {
    $path = "img/".$files[$i];
    unlink($path);
  }
  else{
echo "
  <div class=\"col-xs-6 col-md-3\">
      <img src=\"img/".$files[$i]."\"width=\"auto\" height=\"190\" >
      <p>".$files[$i]."</p>
      <form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\">
      <button type=\"submit\" name=\"".$i."\" class=\"btn btn-warning\">Supprimer</button>
      </form>
  </div>";
}

}
 ?>
</div>



</body>
</html>
