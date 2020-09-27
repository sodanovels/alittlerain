<?php
$ChessImageBase = 'http://www.scsiwyg.com/wiki/chess_images/';

function view_macro_chess($text)
{
  static $square_color = 1;

  $rtn = '';
  for($i = 0; $i < strlen($text); $i++)
  {
    switch($text[$i])
    {
      case 'K': $rtn = $rtn . chess_square('wk', $square_color); break;
      case 'Q': $rtn = $rtn . chess_square('wq', $square_color); break;
      case 'R': $rtn = $rtn . chess_square('wr', $square_color); break;
      case 'B': $rtn = $rtn . chess_square('wb', $square_color); break;
      case 'N': $rtn = $rtn . chess_square('wn', $square_color); break;
      case 'P': $rtn = $rtn . chess_square('wp', $square_color); break;
      case 'k': $rtn = $rtn . chess_square('bk', $square_color); break;
      case 'q': $rtn = $rtn . chess_square('bq', $square_color); break;
      case 'r': $rtn = $rtn . chess_square('br', $square_color); break;
      case 'b': $rtn = $rtn . chess_square('bb', $square_color); break;
      case 'n': $rtn = $rtn . chess_square('bn', $square_color); break;
      case 'p': $rtn = $rtn . chess_square('bp', $square_color); break;
      default:  $rtn = $rtn . chess_square('',   $square_color); break;
    }
    $square_color = !$square_color;
  }

  $square_color = !$square_color;       // Start next line with same color.

  $rtn = $rtn . html_newline();
  return $rtn;
}

function chess_square($piece, $color)
{
  global $ChessImageBase;

  return '<img src="' . $ChessImageBase . $piece .
         ($color == 0 ? 'd' : 'l') . '.png" width="33" height="33" />';
}

?>
