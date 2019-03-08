<?php

function negacija($A){
 //logicki operator NE (!)
 if($A == 1){
   return 0;
 }else{
   return 1;
 }
}

function konjukcija ($A, $B){
  //logicki operator I (&&)
  if($A == 1 && $B == 1){
    return 1;
  }else{
    return 0;
  }
}

function disjunkcija($A, $B){
  //logicki operator ILI (||)
  if($A == 1 || $B == 1){
    return 1;
  }else{
    return 0;
  }
}



function implikacija($A, $B){
  if($A == 1 && $B == 0){
    return 0;
  }else{
    return 1;
  }

}

function ekvivalencija($A, $B){
  if ($A == $B){
    return 1;
  }else {
    return 0;
  }
}


 ?>
