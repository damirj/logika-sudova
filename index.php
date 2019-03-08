<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<?php
include 'functions.php';
?>

<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Logika sudova</title>
  </head>

  <body>
    <div class ="container">
      <button name="top" id="top" onclick="scrollToTop(400)" ><i class="fas fa-arrow-alt-circle-up"></i></button>
      <div class="row">
        <div class="col-12">
          <h1 class ="naslov">Obrada formule logike sudova</h1>
        </div>
      </div>

      <?php
      if (isset($_GET['error'])) {
        $error = $_GET['error'];
      }

      if(isset($error) && is_numeric($error)){
        switch ($error) {
          case '0':
            $error_poruka = "Ispravna formula";
            break;
          case '11':
            $error_poruka = "Napisana je prvo ) pa tek onda (";
            break;
          case '1':
            $error_poruka = "Ima viska '(' zagrada";
            break;
          case '2':
            $error_poruka = "Nedostaje operacija (v,^,<->,->) izmedu dvije varijable ili varijbale i zagrade ili dvije zagrade";
            break;
          case '3':
            $error_poruka = "Postoje nedozvoljeni znakovi u formuli (._?!, mala slova, brojevi itd.)";
            break;
          case '4':
            $error_poruka = "Jedna od operacija (v,^,->,<->) je na nedozvoljenom mjestu (prvo mjesto u formuli)";
            break;
          case '5':
            $error_poruka = "Jedna od operacija (v,^,->,<->) je na nedozvoljenom mjestu (zadnje mjesto u formuli)";
            break;
          case '6':
            $error_poruka = "Jedna od operacija (v,^,->,<->) ispred sebe ima nedozvoljen znak (neku drugu operaciju ili '(' )";
            break;
          case '7':
            $error_poruka = "Jedna od operacija (v,^,->,<->) iza sebe ima nedozvoljen znak (neku drugu operaciju ili ')' )";
            break;
          case '8':
            $error_poruka = "Operacija - (negacija) je na nedozvoljenom mjestu (zadnje mjesto u formuli)";
            break;
          case '9':
            $error_poruka = "Operacija - (negacija) ispred sebe ima nedozvoljen znak (neku drugu operaciju ili varijablu )";
            break;
          case '10':
            $error_poruka = "Operacija - (negacija) iza sebe ima nedozvoljen znak (neku drugu operaciju ili ')' )";
            break;

          default:
            break;
        }

        if ($error > 0 && $error < 12) { ?>
          <div class="row">
            <div class="col-12">
              <form action=<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?> class = "form-group" method="post" id="formula-forma">
                <input class="form-control form-control-lg is-invalid forma" type="text" id="formula" placeholder="Unesite formulu" name="formula" value="<?php if (isset($_SESSION["formula"])) echo $_SESSION["formula"]; ?>" required autocomplete="off">
                <div class="invalid-feedback">
                  <?php echo $error_poruka; ?>
                </div>
              </form>
            </div>
          </div>
        <?php
        }
      }else{ ?>
        <div class="row">
          <div class="col-12">
            <form action=<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?> class="form-group" method="post" id="formula-forma">
              <input class="form-control form-control-lg forma" type="text" id="formula" placeholder="Unesite formulu" name="formula" value="<?php if (isset($_POST['formula'])) echo $_POST['formula']; ?>" required autocomplete="off">
              <small id="passwordHelpBlock" class="form-text text-muted">
                Ovdje unosite formulu logike sudova npr. AvB^(-C->B). Svaka varijabla mora biti napisana velikim slovom!
              </small>
            </form>
          </div>
        </div>

      <?php
      }
      ?>
      <div class="row">
        <div class="col-12 d-flex justify-content-center flex-wrap operacije-gumbi">
            <button data-toggle="tooltip" data-html="true" data-placement="bottom"
            title="
            <table>
              <tr>
                <th>A</th>
                <th>B</th>
                <th>A ^ B</th>
              </tr>
              <tr>
                <td>0</td>
                <td>0</td>
                <td>0</td>
              </tr>
              <tr>
                <td>1</td>
                <td>0</td>
                <td>0</td>
              </tr>
              <tr>
                <td>0</td>
                <td>1</td>
                <td>0</td>
              </tr>
              <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
              </tr>
            </table>" onclick="insertAtCaret('formula', '^')" class="btn btn-info btn-sm operacija-gumb-zasebno" type="button" name="konjukcija" value="^">^ (Konjunkcija)</button>

            <button data-toggle="tooltip" data-html="true" data-placement="bottom"
            title="
            <table>
              <tr>
                <th>A</th>
                <th>B</th>
                <th>A v B</th>
              </tr>
              <tr>
                <td>0</td>
                <td>0</td>
                <td>0</td>
              </tr>
              <tr>
                <td>1</td>
                <td>0</td>
                <td>1</td>
              </tr>
              <tr>
                <td>0</td>
                <td>1</td>
                <td>1</td>
              </tr>
              <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
              </tr>
            </table>"
            onclick="insertAtCaret('formula', 'v')" class="btn btn-info btn-sm operacija-gumb-zasebno" type="button" name="disjunkcija" value="v">v (Disjunkcija)</button>
            <button data-toggle="tooltip" data-html="true" data-placement="bottom"
            title="
            <table>
              <tr>
                <th>A</th>
                <th>B</th>
                <th>A -> B</th>
              </tr>
              <tr>
                <td>0</td>
                <td>0</td>
                <td>1</td>
              </tr>
              <tr>
                <td>1</td>
                <td>0</td>
                <td>0</td>
              </tr>
              <tr>
                <td>0</td>
                <td>1</td>
                <td>1</td>
              </tr>
              <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
              </tr>
            </table>" onclick="insertAtCaret('formula', '->')" class="btn btn-info btn-sm operacija-gumb-zasebno" type="button" name="implikacija" value="->">-&gt (Implikacija)</button>
            <button data-toggle="tooltip" data-html="true" data-placement="bottom"
            title="
            <table>
              <tr>
                <th>A</th>
                <th>-A</th>
              </tr>
              <tr>
                <td>0</td>
                <td>1</td>
              </tr>
              <tr>
                <td>1</td>
                <td>0</td>
              </tr>
            </table>" onclick="insertAtCaret('formula', '-')" class="btn btn-info btn-sm operacija-gumb-zasebno" type="button" name="negacija" value="-">- (Negacija)</button>
            <button data-toggle="tooltip" data-html="true" data-placement="bottom"
            title="
            <table>
              <tr>
                <th>A</th>
                <th>B</th>
                <th>A <-> B</th>
              </tr>
              <tr>
                <td>0</td>
                <td>0</td>
                <td>1</td>
              </tr>
              <tr>
                <td>1</td>
                <td>0</td>
                <td>0</td>
              </tr>
              <tr>
                <td>0</td>
                <td>1</td>
                <td>0</td>
              </tr>
              <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
              </tr>
            </table>" onclick="insertAtCaret('formula', '<->')" class="btn btn-info btn-sm operacija-gumb-zasebno" type="button" name="ekvivalencija" value="<->">&lt-&gt (Ekvivalencija)</button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button type="submit" class="d-flex btn btn-primary btn-lg submit-gumb" form="formula-forma" name="submit" value="Izracunaj">Izracunaj</button>
        </div>
      </div>

      <?php
      if(isset($_POST['formula'])){
        $string = $_POST['formula'];
        $string_formula_za_kraj = $string;
        $_SESSION["formula"] = $string;
        $operatori_dopusteni = "QWERTZUIOPASDFGHJKLYXCVBNM";
        $dopusteni_znakovi = "QWERTZUIOPASDFGHJKLYXCVBNM^-#%&()";
        $dopustene_varijable1 = ")QWERTZUIOPASDFGHJKLYXCVBNM";
        $dopustene_varijable2 = "(QWERTZUIOPASDFGHJKLYXCVBNM";
        $nedopusteni_znakovi_ispred = "(-#%&^";
        $nedopusteni_znakovi_iza = ")#%&^";
        $dopusteni_znakovi_ispred_negacija = "(#%&^";
        $operacije = "-^%&#";
        $operacije_duljina = strlen($operacije);
        $flag_valjanosti = 1;
        $URL =$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."";


        //Funkcija koja ce formatirati formulu u smislu promjene ->, <-> u neke jednoznakovne karaktere te obrisati razmake izmedu operacija i operanda
        $string = str_replace('<->', '#', $string); // ekvivalencija je u programu #
        $string = str_replace('->', '&', $string);  // implikacija je u programu &
        $string = str_replace('v', '%', $string);   // disjunkcija je u programu %
        $string = str_replace('()', '', $string);   // brisanje praznih zagrada
        $string = str_replace(' ', '', $string);    // brisanje svih razmaka
        $len = strlen($string);
        //Kraj funkcije

        //POCETAK PROVJERE ISPRAVNOSTI FORMULE

        //Funkcija koja pregledava ispravnost napisane formule u pogledu jesu li sve otvorene zagrade zatvorene!
        $balans_polje = '';
        $balans_zagrada = 0;
        $zagrada_postoji = 0;
        for ($i=0; $i < $len; $i++) {
          if($string[$i] == '(' ){
            $balans_zagrada++;
            $zagrada_postoji = 1;
          }elseif ($string[$i] == ')' ) {
            $balans_zagrada--;
          }
          if($balans_zagrada < 0){
            $flag_valjanosti = 0;
            header("Location: ".$URL."?error=11");
            exit("<br>OTVORENA JE PRVO ) PA TEK ONDA (<br>");
          }
          $balans_polje.= $balans_zagrada;
        }

        if($balans_zagrada != 0){
          $flag_valjanosti = 0;
          header("Location: ".$URL."?error=1");
          exit("<br>IMA VISKA OTVORENIH ZAGRADA (<br>");
        }
        //Kraj funkcije


        //Funkcija koja brise zagradu koja obavija cijelu funkciju (na prvom mjestu i na zadnjem mjestu zagrada)
        if($zagrada_postoji){
          $provjera_zagrada = $balans_polje[0];
          $provjera_zagrada = "$provjera_zagrada".($provjera_zagrada-1)."";
          while(strpos($balans_polje, $provjera_zagrada) === $len-2){
            $balans_polje = substr($balans_polje, 1, $len-2);
            $string = substr($string, 1, $len-2);
            $len = strlen($string);
            $provjera_zagrada = $balans_polje[0];
            $provjera_zagrada = "$provjera_zagrada".($provjera_zagrada-1)."";
          }
        }

        $balans_polje = "";
        for ($i=0; $i < $len; $i++) {
          if($string[$i] == '(' ){
            $balans_zagrada++;
          }elseif ($string[$i] == ')' ) {
            $balans_zagrada--;
          }
          $balans_polje.= $balans_zagrada;
        }
        //Kraj funkcije


        //Provjerava jel postoji varijabla pored varijable
        $iste_varijable_len = $len - 1;
        for($i = 0; $i < $iste_varijable_len; $i++){
          if(strpos($dopustene_varijable1, $string[$i]) > -1){
            if(strpos($dopustene_varijable2, $string[$i+1]) > -1){
              $flag_valjanosti = 0;
              header("Location: ".$URL."?error=2");
              exit("NEDOSTAJE OPERACIJA IZMEDU VARIJABLI I/ILI ZAGRADA");
            }
          }
         }
        //Kraj funkcije


        //Provjerava jel ima nedopustenih znakova u formi poput ,._!"'...
        for($i = 0; $i < $len; $i++){
          if(strpos($dopusteni_znakovi, $string[$i]) === false){
            $flag_valjanosti = 0;
            header("Location: ".$URL."?error=3");
            exit("POSTOJE NEDOPUSTENI ZNAKOVI U FORMI POPUT .,_!?");
          }
        }
        //Kraj funkcije

        //Provjerava jel unutar zagrade samo jedan operator npr. A<->(B). Ako je brise tu zagradu.
        $duljina_operatora = strlen($operatori_dopusteni);
        for($i = 0; $i <$duljina_operatora; $i++){
          $string = str_replace("(".$operatori_dopusteni[$i].")", $operatori_dopusteni[$i], $string);
        }
        $len = strlen($string);
        $balans_polje = "";
        for($t=0; $t < $len; $t++){
          if($string[$t] == '(' ){
            $balans_zagrada++;
          }elseif($string[$t] == ')' ){
            $balans_zagrada--;
          }
          $balans_polje.= $balans_zagrada;
        }
        //Kraj funkcije



        //Provjerava valjanost operacija, jel iza i ispred njega su valjani elementi
        for($i = 0; $i < $len; $i++){
          //Provjera za sve operacije osim negacije
          if(strpos("#%&^", $string[$i]) > -1){
            if($i==0){
              $flag_valjanosti = 0;
              header("Location: ".$URL."?error=4");
              exit("OPERACIJA JE NA NEDOZVOLJENOM MJESTU (PRVOM MJESTU)");
            }

            if($i == ($len-1)){
              $flag_valjanosti = 0;
              header("Location: ".$URL."?error=5");
              exit("OPERACIJA JE NA NEDOZVOLJENOM MJESTU (ZADNJEM MJESTU)");
            }

            if(strpos($nedopusteni_znakovi_ispred, $string[$i-1]) > -1){
              $flag_valjanosti = 0;
              header("Location: ".$URL."?error=6");
              exit("OPERACIJA ISPRED SEBE IMA NEDOPUSTEN ZNAK");
            }

            if(strpos($nedopusteni_znakovi_iza, $string[$i+1]) > -1){
              $flag_valjanosti = 0;
              header("Location: ".$URL."?error=7");
              exit("OPERACIJA IZA SEBE IMA NEDOPUSTEN ZNAK");
            }
          }
          //Kraj provjere za sve operacije osim negacije

          //Provjera za operaciju Negacija
          if(strpos("-", $string[$i]) > -1){
            if($i == ($len-1)){
              $flag_valjanosti = 0;
              header("Location: ".$URL."?error=8");
              exit("OPERACIJA JE NA NEDOZVOLJENOM MJESTU (ZADNJEM MJESTU)");
            }

            if($i != 0){
              if(strpos($dopusteni_znakovi_ispred_negacija, $string[$i-1]) === false){
                $flag_valjanosti = 0;
                header("Location: ".$URL."?error=9");
                exit("OPERACIJA ISPRED SEBE IMA NEDOPUSTEN ZNAK(negacija)");
              }
            }

            if(strpos($nedopusteni_znakovi_iza, $string[$i+1]) > -1){
              $flag_valjanosti = 0;
              header("Location: ".$URL."?error=10");
              exit("OPERACIJA IZA SEBE IMA NEDOPUSTEN ZNAK");
            }
          }
          //Kraj provjere za operaciju Negacija
        }
        //Kraj funkcije

        //KRAJ PROVJERE ISPRAVNOSTI FORMULE


        // Funkcija koja izvlaci sve operande iz formule!
        $registar_varijabli = '';
        for($i = 0; $i < $len; $i++){
          if(strpos($registar_varijabli, $string[$i]) > -1){
            continue;
          }

          for($slovo = 65; $slovo < 91; $slovo++){
            if($string[$i] == chr($slovo)){
              $char = chr($slovo);
              $registar_varijabli.=$char;
            }

          }
        } // Rezultat je $registar_varijabli koji sadrzi sve OPERANDE koji se nalaze u formuli
        //Kraj funkcije za izvlacenje operanda iz formule!


        //Funkcija popunjava pocetne vrijednosti operanada u tablici
        $broj_varijabli = strlen($registar_varijabli);
        $duljina_tablice = pow(2, $broj_varijabli);
        $value0 = 0;
        $value1 = 1;
        for($k = 0; $k < $broj_varijabli; $k++){
          $stupanj_izmjene = pow(2, $k);
          $izmjena = $stupanj_izmjene * (-1);
          for($z = 0; $z < $duljina_tablice; $z++){
            if($izmjena < 0){
              $tablica[$registar_varijabli[$k]][$z] = $value0;
              $polje[$z] = $value0;
              $izmjena++;
            }elseif($izmjena < $stupanj_izmjene && $izmjena >= 0){
              $tablica[$registar_varijabli[$k]][$z] = $value1;
              $polje[$z] = $value1;
              $izmjena++;
            }elseif ($izmjena == $stupanj_izmjene) {
              $izmjena = $izmjena * (-1);
              $z--;
            }
          }
        } //Kao rezultat daje 2D asocijativno polje gdje je kljuc operand npr. 'A', 'b', 'C'. A vrijednost polje vrijednosti 0 i 1.
        //Kraj funkcije



        $max_razina = -1;
        for ($i=0; $i < $len; $i++) {
          if($balans_polje[$i] > $max_razina){
            $max_razina = $balans_polje[$i];
          }
        }

        $min_razina = 9999;
        for ($i=0; $i < $len; $i++) {
          if($balans_polje[$i] < $min_razina){
            $min_razina = $balans_polje[$i];
          }
        }

        $pocetak_razine_zagrada = 0;
        $kraj_razine_zagrada = 0;
        $operacija_brojac = 0;
        $operacija_offset = 0;
        $temp_razina_sadrzaj = "";
        for(; $max_razina >= $min_razina; $max_razina--){
          for($i=0; $i < $len ; $i++) {
            if($balans_polje[$i] == $max_razina){
              if($max_razina == $min_razina){
                $temp_razina_sadrzaj = $string;
                $temp_razina_sadrzaj_2 = $string;
                $temp_duljina = strlen($temp_razina_sadrzaj);
              }else{
                $pocetak_razine_zagrada = $i;
                $kraj_razine_zagrada = strpos($string, ')', $pocetak_razine_zagrada);
                $temp_razina_sadrzaj = substr($string, $pocetak_razine_zagrada+1, $kraj_razine_zagrada-$pocetak_razine_zagrada-1); //TRENUTNA RAZINA ZAGRADE KOJA SE OBRADUJE (NAJVISA RAZINA)
                $temp_razina_sadrzaj_2 = substr($string, $pocetak_razine_zagrada, $kraj_razine_zagrada-$pocetak_razine_zagrada+1);
                $temp_duljina = strlen($temp_razina_sadrzaj);

                $i = $kraj_razine_zagrada;
              }
              for($k = 0; $k < $operacije_duljina; $k++){
                for($z = 0; $z < $temp_duljina; $z++){
                  if($temp_razina_sadrzaj[$z] == '['){
                    $balans_uglata_zagrada = 1;
                    $preskociti_uglate_kraj = $z+1;
                    while($balans_uglata_zagrada != 0){
                      if($temp_razina_sadrzaj[$preskociti_uglate_kraj] == '['){
                        $balans_uglata_zagrada++;
                      }elseif ($temp_razina_sadrzaj[$preskociti_uglate_kraj] == ']') {
                        $balans_uglata_zagrada--;
                      }
                      $preskociti_uglate_kraj++;
                    }
                    $preskociti_uglate_kraj--;
                    $z = $preskociti_uglate_kraj;
                    continue;
                  }

                  if($temp_razina_sadrzaj[$z] == $operacije[$k]){
                    switch ($operacije[$k]) {
                      case '-':
                        $flag_desna_uglata = 0;
                        if($temp_razina_sadrzaj[$z+1] == '['){
                          $balans_uglata_zagrada = 1;
                          $kraj_uglate_zagrade = $z+2;
                          while($balans_uglata_zagrada != 0){
                            if($temp_razina_sadrzaj[$kraj_uglate_zagrade] == '['){
                              $balans_uglata_zagrada++;
                            }elseif ($temp_razina_sadrzaj[$kraj_uglate_zagrade] == ']') {
                              $balans_uglata_zagrada--;
                            }
                            $kraj_uglate_zagrade++;
                          }
                          $kraj_uglate_zagrade--;
                          $pocetak_uglate_zagrade = $z+1;
                          $temp_sadrzaj_desno = substr($temp_razina_sadrzaj, $pocetak_uglate_zagrade+1, $kraj_uglate_zagrade-$pocetak_uglate_zagrade-1);
                          $flag_desna_uglata = 1;
                        }
                        if ($flag_desna_uglata == 1) {
                          $temp_naziv = "".$temp_razina_sadrzaj[$z]."[".$temp_sadrzaj_desno."]";
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = negacija($tablica[$temp_sadrzaj_desno][$j]);
                          }
                        }
                        if($flag_desna_uglata == 0){
                          $temp_naziv = "".$temp_razina_sadrzaj[$z].$temp_razina_sadrzaj[$z+1];
                          for ($j=0; $j < $duljina_tablice ; $j++) {
                            $tablica[$temp_naziv][$j] = negacija($tablica[$temp_razina_sadrzaj[$z+1]][$j]);
                          }
                        }

                        $temp_razina_sadrzaj = str_replace($temp_naziv, "[".$temp_naziv."]", $temp_razina_sadrzaj);
                        $temp_duljina = strlen($temp_razina_sadrzaj);
                        break;

                      case '^':
                        $flag_desna_uglata = 0;
                        $flag_lijeva_uglata = 0;
                        if($temp_razina_sadrzaj[$z+1] == '['){
                          $balans_uglata_zagrada = 1;
                          $kraj_uglate_zagrade = $z+2;
                          while($balans_uglata_zagrada != 0){
                            if($temp_razina_sadrzaj[$kraj_uglate_zagrade] == '['){
                              $balans_uglata_zagrada++;
                            }elseif ($temp_razina_sadrzaj[$kraj_uglate_zagrade] == ']') {
                              $balans_uglata_zagrada--;
                            }
                            $kraj_uglate_zagrade++;
                          }
                          $kraj_uglate_zagrade--;
                          $pocetak_uglate_zagrade = $z+1;
                          $temp_sadrzaj_desno = substr($temp_razina_sadrzaj, $pocetak_uglate_zagrade+1, $kraj_uglate_zagrade-$pocetak_uglate_zagrade-1);
                          $flag_desna_uglata = 1;
                        }
                        if ($temp_razina_sadrzaj[$z-1] == ']') {
                          $balans_uglata_zagrada = 1;
                          $pocetak_uglate_zagrade = $z-2;
                          while($balans_uglata_zagrada != 0){
                            if($temp_razina_sadrzaj[$pocetak_uglate_zagrade] == ']'){
                              $balans_uglata_zagrada++;
                            }elseif ($temp_razina_sadrzaj[$pocetak_uglate_zagrade] == '[') {
                              $balans_uglata_zagrada--;
                            }
                            $pocetak_uglate_zagrade--;
                          }
                          $pocetak_uglate_zagrade++;
                          $kraj_uglate_zagrade = $z-1;
                          $temp_sadrzaj_lijevo = substr($temp_razina_sadrzaj, $pocetak_uglate_zagrade+1, $kraj_uglate_zagrade-$pocetak_uglate_zagrade-1);
                          $flag_lijeva_uglata = 1;
                        }

                        if($flag_lijeva_uglata == 1 && $flag_desna_uglata == 1) {
                          $temp_naziv = "[".$temp_sadrzaj_lijevo."]".$temp_razina_sadrzaj[$z]."[".$temp_sadrzaj_desno."]";
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = konjukcija($tablica[$temp_sadrzaj_lijevo][$j], $tablica[$temp_sadrzaj_desno][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 1 && $flag_desna_uglata == 0) {
                          $temp_naziv = "[".$temp_sadrzaj_lijevo."]".$temp_razina_sadrzaj[$z].$temp_razina_sadrzaj[$z+1];
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = konjukcija($tablica[$temp_sadrzaj_lijevo][$j], $tablica[$temp_razina_sadrzaj[$z+1]][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 0 && $flag_desna_uglata == 1) {
                          $temp_naziv = "".$temp_razina_sadrzaj[$z-1].$temp_razina_sadrzaj[$z]."[".$temp_sadrzaj_desno."]";
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = konjukcija($tablica[$temp_razina_sadrzaj[$z-1]][$j], $tablica[$temp_sadrzaj_desno][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 0 && $flag_desna_uglata == 0) {
                          $temp_naziv = "".$temp_razina_sadrzaj[$z-1].$temp_razina_sadrzaj[$z].$temp_razina_sadrzaj[$z+1];
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = konjukcija($tablica[$temp_razina_sadrzaj[$z-1]][$j], $tablica[$temp_razina_sadrzaj[$z+1]][$j]);
                          }

                        }
                        $temp_razina_sadrzaj = str_replace($temp_naziv, "[".$temp_naziv."]", $temp_razina_sadrzaj);
                        $temp_duljina = strlen($temp_razina_sadrzaj);
                        break;

                      case '%':
                        $flag_desna_uglata = 0;
                        $flag_lijeva_uglata = 0;
                        if($temp_razina_sadrzaj[$z+1] == '['){
                          $balans_uglata_zagrada = 1;
                          $kraj_uglate_zagrade = $z+2;
                          while($balans_uglata_zagrada != 0){
                            if($temp_razina_sadrzaj[$kraj_uglate_zagrade] == '['){
                              $balans_uglata_zagrada++;
                            }elseif ($temp_razina_sadrzaj[$kraj_uglate_zagrade] == ']') {
                              $balans_uglata_zagrada--;
                            }
                            $kraj_uglate_zagrade++;
                          }
                          $kraj_uglate_zagrade--;
                          $pocetak_uglate_zagrade = $z+1;
                          $temp_sadrzaj_desno = substr($temp_razina_sadrzaj, $pocetak_uglate_zagrade+1, $kraj_uglate_zagrade-$pocetak_uglate_zagrade-1);
                          $flag_desna_uglata = 1;
                        }
                        if ($temp_razina_sadrzaj[$z-1] == ']') {
                          $balans_uglata_zagrada = 1;
                          $pocetak_uglate_zagrade = $z-2;
                          while($balans_uglata_zagrada != 0){
                            if($temp_razina_sadrzaj[$pocetak_uglate_zagrade] == ']'){
                              $balans_uglata_zagrada++;
                            }elseif ($temp_razina_sadrzaj[$pocetak_uglate_zagrade] == '[') {
                              $balans_uglata_zagrada--;
                            }
                            $pocetak_uglate_zagrade--;
                          }
                          $pocetak_uglate_zagrade++;
                          $kraj_uglate_zagrade = $z-1;
                          $temp_sadrzaj_lijevo = substr($temp_razina_sadrzaj, $pocetak_uglate_zagrade+1, $kraj_uglate_zagrade-$pocetak_uglate_zagrade-1);
                          $flag_lijeva_uglata = 1;
                        }
                        if($flag_lijeva_uglata == 1 && $flag_desna_uglata == 1) {
                          $temp_naziv = "[".$temp_sadrzaj_lijevo."]".$temp_razina_sadrzaj[$z]."[".$temp_sadrzaj_desno."]";
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = disjunkcija($tablica[$temp_sadrzaj_lijevo][$j], $tablica[$temp_sadrzaj_desno][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 1 && $flag_desna_uglata == 0) {
                          $temp_naziv = "[".$temp_sadrzaj_lijevo."]".$temp_razina_sadrzaj[$z].$temp_razina_sadrzaj[$z+1];
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = disjunkcija($tablica[$temp_sadrzaj_lijevo][$j], $tablica[$temp_razina_sadrzaj[$z+1]][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 0 && $flag_desna_uglata == 1) {
                          $temp_naziv = "".$temp_razina_sadrzaj[$z-1].$temp_razina_sadrzaj[$z]."[".$temp_sadrzaj_desno."]";
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = disjunkcija($tablica[$temp_razina_sadrzaj[$z-1]][$j], $tablica[$temp_sadrzaj_desno][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 0 && $flag_desna_uglata == 0) {
                          $temp_naziv = "".$temp_razina_sadrzaj[$z-1].$temp_razina_sadrzaj[$z].$temp_razina_sadrzaj[$z+1];
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = disjunkcija($tablica[$temp_razina_sadrzaj[$z-1]][$j], $tablica[$temp_razina_sadrzaj[$z+1]][$j]);
                          }

                        }
                        $temp_razina_sadrzaj = str_replace($temp_naziv, "[".$temp_naziv."]", $temp_razina_sadrzaj);
                        $temp_duljina = strlen($temp_razina_sadrzaj);
                        break;

                      case '&':
                        $flag_desna_uglata = 0;
                        $flag_lijeva_uglata = 0;
                        if($temp_razina_sadrzaj[$z+1] == '['){
                          $balans_uglata_zagrada = 1;
                          $kraj_uglate_zagrade = $z+2;
                          while($balans_uglata_zagrada != 0){
                            if($temp_razina_sadrzaj[$kraj_uglate_zagrade] == '['){
                              $balans_uglata_zagrada++;
                            }elseif ($temp_razina_sadrzaj[$kraj_uglate_zagrade] == ']') {
                              $balans_uglata_zagrada--;
                            }
                            $kraj_uglate_zagrade++;
                          }
                          $kraj_uglate_zagrade--;
                          $pocetak_uglate_zagrade = $z+1;
                          $temp_sadrzaj_desno = substr($temp_razina_sadrzaj, $pocetak_uglate_zagrade+1, $kraj_uglate_zagrade-$pocetak_uglate_zagrade-1);
                          $flag_desna_uglata = 1;
                        }
                        if ($temp_razina_sadrzaj[$z-1] == ']') {
                          $balans_uglata_zagrada = 1;
                          $pocetak_uglate_zagrade = $z-2;
                          while($balans_uglata_zagrada != 0){
                            if($temp_razina_sadrzaj[$pocetak_uglate_zagrade] == ']'){
                              $balans_uglata_zagrada++;
                            }elseif ($temp_razina_sadrzaj[$pocetak_uglate_zagrade] == '[') {
                              $balans_uglata_zagrada--;
                            }
                            $pocetak_uglate_zagrade--;
                          }
                          $pocetak_uglate_zagrade++;
                          $kraj_uglate_zagrade = $z-1;
                          $temp_sadrzaj_lijevo = substr($temp_razina_sadrzaj, $pocetak_uglate_zagrade+1, $kraj_uglate_zagrade-$pocetak_uglate_zagrade-1);
                          $flag_lijeva_uglata = 1;
                        }
                        if($flag_lijeva_uglata == 1 && $flag_desna_uglata == 1) {
                          $temp_naziv = "[".$temp_sadrzaj_lijevo."]".$temp_razina_sadrzaj[$z]."[".$temp_sadrzaj_desno."]";
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = implikacija($tablica[$temp_sadrzaj_lijevo][$j], $tablica[$temp_sadrzaj_desno][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 1 && $flag_desna_uglata == 0) {
                          $temp_naziv = "[".$temp_sadrzaj_lijevo."]".$temp_razina_sadrzaj[$z].$temp_razina_sadrzaj[$z+1];
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = implikacija($tablica[$temp_sadrzaj_lijevo][$j], $tablica[$temp_razina_sadrzaj[$z+1]][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 0 && $flag_desna_uglata == 1) {
                          $temp_naziv = "".$temp_razina_sadrzaj[$z-1].$temp_razina_sadrzaj[$z]."[".$temp_sadrzaj_desno."]";
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = implikacija($tablica[$temp_razina_sadrzaj[$z-1]][$j], $tablica[$temp_sadrzaj_desno][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 0 && $flag_desna_uglata == 0) {
                          $temp_naziv = "".$temp_razina_sadrzaj[$z-1].$temp_razina_sadrzaj[$z].$temp_razina_sadrzaj[$z+1];
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = implikacija($tablica[$temp_razina_sadrzaj[$z-1]][$j], $tablica[$temp_razina_sadrzaj[$z+1]][$j]);
                          }

                        }
                        $temp_razina_sadrzaj = str_replace($temp_naziv, "[".$temp_naziv."]", $temp_razina_sadrzaj);
                        $temp_duljina = strlen($temp_razina_sadrzaj);
                        break;

                      case '#':
                        $flag_desna_uglata = 0;
                        $flag_lijeva_uglata = 0;
                        if($temp_razina_sadrzaj[$z+1] == '['){
                          $balans_uglata_zagrada = 1;
                          $kraj_uglate_zagrade = $z+2;
                          while($balans_uglata_zagrada != 0){
                            if($temp_razina_sadrzaj[$kraj_uglate_zagrade] == '['){
                              $balans_uglata_zagrada++;
                            }elseif ($temp_razina_sadrzaj[$kraj_uglate_zagrade] == ']') {
                              $balans_uglata_zagrada--;
                            }
                            $kraj_uglate_zagrade++;
                          }
                          $kraj_uglate_zagrade--;
                          $pocetak_uglate_zagrade = $z+1;
                          $temp_sadrzaj_desno = substr($temp_razina_sadrzaj, $pocetak_uglate_zagrade+1, $kraj_uglate_zagrade-$pocetak_uglate_zagrade-1);
                          $flag_desna_uglata = 1;
                        }
                        if ($temp_razina_sadrzaj[$z-1] == ']') {
                          $balans_uglata_zagrada = 1;
                          $pocetak_uglate_zagrade = $z-2;
                          while($balans_uglata_zagrada != 0){
                            if($temp_razina_sadrzaj[$pocetak_uglate_zagrade] == ']'){
                              $balans_uglata_zagrada++;
                            }elseif ($temp_razina_sadrzaj[$pocetak_uglate_zagrade] == '[') {
                              $balans_uglata_zagrada--;
                            }
                            $pocetak_uglate_zagrade--;
                          }
                          $pocetak_uglate_zagrade++;
                          $kraj_uglate_zagrade = $z-1;
                          $temp_sadrzaj_lijevo = substr($temp_razina_sadrzaj, $pocetak_uglate_zagrade+1, $kraj_uglate_zagrade-$pocetak_uglate_zagrade-1);
                          $flag_lijeva_uglata = 1;
                        }
                        if($flag_lijeva_uglata == 1 && $flag_desna_uglata == 1) {
                          $temp_naziv = "[".$temp_sadrzaj_lijevo."]".$temp_razina_sadrzaj[$z]."[".$temp_sadrzaj_desno."]";
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = ekvivalencija($tablica[$temp_sadrzaj_lijevo][$j], $tablica[$temp_sadrzaj_desno][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 1 && $flag_desna_uglata == 0) {
                          $temp_naziv = "[".$temp_sadrzaj_lijevo."]".$temp_razina_sadrzaj[$z].$temp_razina_sadrzaj[$z+1];
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = ekvivalencija($tablica[$temp_sadrzaj_lijevo][$j], $tablica[$temp_razina_sadrzaj[$z+1]][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 0 && $flag_desna_uglata == 1) {
                          $temp_naziv = "".$temp_razina_sadrzaj[$z-1].$temp_razina_sadrzaj[$z]."[".$temp_sadrzaj_desno."]";
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = ekvivalencija($tablica[$temp_razina_sadrzaj[$z-1]][$j], $tablica[$temp_sadrzaj_desno][$j]);
                          }

                        }elseif ($flag_lijeva_uglata == 0 && $flag_desna_uglata == 0) {
                          $temp_naziv = "".$temp_razina_sadrzaj[$z-1].$temp_razina_sadrzaj[$z].$temp_razina_sadrzaj[$z+1];
                          for ($j = 0; $j < $duljina_tablice; $j++) {
                              $tablica[$temp_naziv][$j] = ekvivalencija($tablica[$temp_razina_sadrzaj[$z-1]][$j], $tablica[$temp_razina_sadrzaj[$z+1]][$j]);
                          }

                        }
                        $temp_razina_sadrzaj = str_replace($temp_naziv, "[".$temp_naziv."]", $temp_razina_sadrzaj);
                        $temp_duljina = strlen($temp_razina_sadrzaj);           
                        break;
                    }
                    $z++;
                  }
                }
              }
            }

            if($temp_razina_sadrzaj != ''){
            
              $string = str_replace($temp_razina_sadrzaj_2, $temp_razina_sadrzaj, $string);
              $len = strlen($string);
              $balans_polje = "";
              for ($t=0; $t < $len; $t++) {
                if($string[$t] == '(' ){
                  $balans_zagrada++;
                }elseif ($string[$t] == ')' ) {
                  $balans_zagrada--;
                }
                $balans_polje.= $balans_zagrada;
              }
            }

          }
        }
        ?>


        <?php
        //var_dump(count($tablica));
        $broj_stupaca_tablice = count($tablica);
        $stupci_tablice_racunanje = array_keys($tablica);
        $stupci_tablice = array_keys($tablica);
        //var_dump($stupci_tablice);

        for ($i=0; $i < $broj_stupaca_tablice ; $i++) {
          $stupci_tablice[$i] = str_replace('#', '<->', $stupci_tablice[$i]); // ekvivalencija je u programu #
          $stupci_tablice[$i] = str_replace('&', '->', $stupci_tablice[$i]);  // implikacija je u programu &
          $stupci_tablice[$i] = str_replace('%', 'v', $stupci_tablice[$i]);   // disjunkcija je u programu %
          $stupci_tablice[$i] = str_replace('[', '(', $stupci_tablice[$i]);
          $stupci_tablice[$i] = str_replace(']', ')', $stupci_tablice[$i]);
        }

        ?>

        <div class="row">
          <div class="col-12">
            <div class = "table-responsive">
              <table class = "table table-hover table-dark table-bordered">
                <?php
                  for($i = 0; $i <= $duljina_tablice; $i++){
                ?>
                    <tr>
                      <?php
                        for ($j=0; $j < $broj_stupaca_tablice; $j++) {
                          if($i == 0){
                            if($j == 0){
                      ?>
                              <th>#</th>
                            <?php
                            }
                            ?>
                            <th><?php echo $stupci_tablice[$j]; ?></th>

                            <?php
                            }else{
                              if($j == 0){
                            ?>
                                <td><?php echo $i; ?></td>
                              <?php
                              }
                              ?>

                              <td><?php echo $tablica[$stupci_tablice_racunanje[$j]][$i-1]; ?></td>

                        <?php
                            }
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>
              </table>
            </div>
          </div>
        </div>


        <?php
        $brojac_ishoda = 0;
        for ($i=0; $i <= $duljina_tablice; $i++) {
          if(isset($tablica[$stupci_tablice_racunanje[$broj_stupaca_tablice-1]][$i])){
            if($tablica[$stupci_tablice_racunanje[$broj_stupaca_tablice-1]][$i] == 1){
              $brojac_ishoda++;
            }
          }

        }
        ?>

        <div class="row">
          <div class="col-12">
            <?php
            if($brojac_ishoda == 0){
              echo "<p class='velicina-font'>Interpretacija Formule: <br>".$string_formula_za_kraj." <br> <strong>Antitautologija i Oboriva!</strong>";
            }elseif($brojac_ishoda >= 1){
              echo "<p class='velicina-font'>Interpretacija Formule: <br>".$string_formula_za_kraj." <br> <strong>Ispunjiva</strong>";
              if($brojac_ishoda == $duljina_tablice){
                echo " <strong>i Tautologija!</strong></p>";
              }else{
                echo " <strong>i Oboriva!</strong></p>";
              }
            }
          }
          ?>
          </div>
        </div>

        <?php
         ob_end_flush();
         ?>
    </div>

    <script>

      function scrollToTop(scrollDuration) {
        var scrollStep = -window.scrollY / (scrollDuration / 15),
            scrollInterval = setInterval(function(){
            if ( window.scrollY != 0 ) {
                window.scrollBy( 0, scrollStep );
            }
            else clearInterval(scrollInterval);
        },15);
      }


      window.onscroll = function() {
        scrollFunction()
      };

      function scrollFunction() {
        if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
            document.getElementById("top").style.display = "block";
        } else {
            document.getElementById("top").style.display = "none";
        }
      }

    </script>

    <script>
    //Funkcija koja omogucava ubacivanje OPERACIJA klikom na gumb tamo gdje je CARET
      function insertAtCaret(areaId, text) {
        var txtarea = document.getElementById(areaId);
        if (!txtarea) {
          return;
        }

        var scrollPos = txtarea.scrollTop;
        var strPos = 0;
        var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
          "ff" : (document.selection ? "ie" : false));
        if (br == "ie") {
          txtarea.focus();
          var range = document.selection.createRange();
          range.moveStart('character', -txtarea.value.length);
          strPos = range.text.length;
        } else if (br == "ff") {
            strPos = txtarea.selectionStart;
        }

        var front = (txtarea.value).substring(0, strPos);
        var back = (txtarea.value).substring(strPos, txtarea.value.length);
        txtarea.value = front + text + back;
        strPos = strPos + text.length;
        if (br == "ie") {
          txtarea.focus();
          var ieRange = document.selection.createRange();
          ieRange.moveStart('character', -txtarea.value.length);
          ieRange.moveStart('character', strPos);
          ieRange.moveEnd('character', 0);
          ieRange.select();
        } else if (br == "ff") {
            txtarea.selectionStart = strPos;
            txtarea.selectionEnd = strPos;
            txtarea.focus();
        }
        txtarea.scrollTop = scrollPos;
      }
    //Kraj funkcije
    </script>

    <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>


  </body>

</html>