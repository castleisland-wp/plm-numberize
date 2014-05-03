<?php
/*
Plugin Name: Paul's Numberizer!
Plugin URI: http://www.paulmcelligott.com
Description: Turning numbers into words with shortcodes since 2014.
Version: 0.1
Author: Paul McElligott
Author URI: http://www.paulmcelligott.com
License: GPL
*/

function plm_textualize_number($the_number, $do_ord=FALSE)
{
	$textualized = '';

	if(!preg_match('%\d+%', $the_number)) return '';

	if ($the_number >= 1E+18)
	{
		$computed = 999999999999999999;
	} else {
		$computed = $the_number;
	} 

	if ($computed >= 1E+15) 
	{
		$quadrillions = intval($computed/1E+15);
		$computed = $computed - ($quadrillions * 1E+15);
		if ($computed != 0 OR !$do_ord) {
			$textualized .= plm_hundredize($quadrillions) . ' quadrillion ';
		} else {
			$textualized .= plm_hundredize($quadrillions) . ' quadrillionth';
		}
	}	


	if ($computed >= 1E+12) 
	{
		$trillions = intval($computed/1E+12);
		$computed = $computed - ($trillions * 1E+12);
		if ($computed != 0 OR !$do_ord) {
			$textualized .= plm_hundredize($trillions) . ' trillion ';
		} else {
			$textualized .= plm_hundredize($trillions) . ' trillionth';
		}		
	}	

	if ($computed >= 1E+9) 
	{
		$billions = intval($computed/1E+9);
		$computed = $computed - ($billions * 1E+9);
		if ($computed != 0 OR !$do_ord) {
			$textualized .= plm_hundredize($billions) . ' billion ';
		} else {
			$textualized .= plm_hundredize($billions) . ' billionth';
		}
	}	

	if ($computed >= 1E+6)
	{
		$millions = intval($computed/1E+6);
		$computed = $computed - ($millions * 1E+6);
		if ($computed != 0 OR !$do_ord) {
			$textualized .= plm_hundredize($millions) . ' million ';
		} else {
			$textualized .= plm_hundredize($millions) . ' millionth';
		}
	}

	if ($computed >= 1000)
	{
		$thousands = intval($computed/1000);
		$computed = $computed - ($thousands * 1000);
		if ($computed != 0 OR !$do_ord) {
			$textualized .= plm_hundredize($thousands) . ' thousand ';
		} else {
			$textualized .= plm_hundredize($thousands) . ' thousandth';
		}
	}

	if ($computed != 0)
	{
		$textualized .= plm_hundredize($computed, $do_ord);
	}

	return trim($textualized);
}

function plm_hundredize($the_number, $do_ord=FALSE)
{
	$hundredized = '';

	$the_number = intval($the_number);

	if ($the_number > 1000) 
	{
		$computed = 999;
	} else {
		$computed = $the_number;
	}

	$number_text = array(
		1 => 'one', 
		2 => 'two',
		3 => 'three',
		4 => 'four',
		5 => 'five',
		6 => 'six',
		7 => 'seven',
		8 => 'eight',
		9 => 'nine',
		10 => 'ten',
		11 => 'eleven',
		12 => 'twelve',
		13 => 'thirteen',
		14 => 'fourteen',
		15 => 'fifteen',
		16 => 'sixteen',
		17 => 'seventeen',
		18 => 'eighteen',
		19 => 'nineteen',
		20 => 'twenty',
		30 => 'thirty',
		40 => 'forty',
		50 => 'fifty',
		60 => 'sixty',
		70 => 'seventy',
		80 => 'eighty',
		90 => 'ninety');

	$ordinal_text = array(
		1 => 'first', 
		2 => 'second',
		3 => 'third',
		4 => 'fourth',
		5 => 'fifth',
		6 => 'sixth',
		7 => 'seventh',
		8 => 'eighth',
		9 => 'nineth',
		10 => 'tenth',
		11 => 'eleventh',
		12 => 'twelveth',
		13 => 'thirteenth',
		14 => 'fourteenth',
		15 => 'fifteenth',
		16 => 'sixteenth',
		17 => 'seventeenth',
		18 => 'eighteenth',
		19 => 'nineteenth',
		20 => 'twentieth',
		30 => 'thirtieth',
		40 => 'fortieth',
		50 => 'fiftieth',
		60 => 'sixtyieth',
		70 => 'seventieth',
		80 => 'eightieth',
		90 => 'ninetieth');

	if ($computed > 99) 
	{
		$hundreds = intval($computed/100);

		$computed = $computed - ($hundreds * 100);
		$hundredized = $number_text[$hundreds];
		if ($computed != 0 OR !$do_ord) {
			$hundredized .= ' hundred';
		} else {
			$hundredized .= ' hundredth';
		}

		if ($computed != 0)
		{
			$hundredized .= ' ';
		}
	}

	if ($computed > 19)
	{
		$tens = (intval($computed/10) * 10);

		if (($computed % 10) != 0 OR !$do_ord) {
			$hundredized .= $number_text[$tens];
		} else {
			$hundredized .= $ordinal_text[$tens];
		}
		
		if (($computed % 10) != 0)
		{
			$hundredized .= '-';
			
			if(!$do_ord) {

				$hundredized .= $number_text[($computed % 10)];
			} else {
				$hundredized .= $ordinal_text[($computed % 10)];
			}
		}
	} else {
		if (!$do_ord) {
			$hundredized .= $number_text[$computed];
		} else {
			$hundredized .= $ordinal_text[$computed];
		}
		
	}

	return $hundredized;
}

function plm_textualize_sc($atts, $content = NULL) 
{
	extract( shortcode_atts( array(
		'para' => 'yes', 
		'caps' => 'no', 
		'end' => '',
		'ord' => 'no',
		'ordinals' => 'no'
	), $atts ) );

	if ((strtoupper($ord) != 'YES') AND (strtoupper($ordinals) != 'YES')) {
		$do_ord = FALSE;
	} else {
		$do_ord = TRUE;
	}

	if (preg_match('%\d+%', $content)) 
	{
		$para = strtoupper($para);
		$caps = strtoupper($caps);
		$textnum = plm_textualize_number($content, $do_ord);

		if($caps == 'YES') 
		{
			$textnum = ucwords($textnum);
		} elseif ($caps == 'FIRST') {
			$textnum = ucfirst($textnum);
		}

		if($end != '') 
		{
			$textnum .= $end;
		}

		if ($para == 'YES') 
		{
			return '<p>' . $textnum  . '</p>';	
		} else {
			return $textnum;
		}

	} else {
		return '';
	}
}

add_shortcode('textualize', 'plm_textualize_sc');

function plm_hours_mins($mins) 
{
	$hoursmins = '';

	if (is_numeric($mins))
	{
		if($mins > 59) // More than an hour.
		{
			$hour_cnt = intval($mins/60);
			$min_cnt = $mins % 60;
		} else {
			$min_cnt = $mins;
		}

		if ($hour_cnt == 1) 
		{
			$hoursmins .= plm_textualize_number($hour_cnt) . ' hour ';
		} elseif ($hour_cnt > 1) {
			$hoursmins .= plm_textualize_number($hour_cnt) . ' hours ';
		}

		if(($hour_cnt != 0) & ($min_cnt != 0))
		{
			$hoursmins .= ' and ';
		}

		if($min_cnt == 1) 
		{
			$hoursmins .= plm_hundredize($min_cnt) . ' minute ';			
		} elseif($min_cnt > 1) {
			$hoursmins .= plm_hundredize($min_cnt) . ' minutes ';	
		}
	}

	return trim($hoursmins);
}

function plm_hours_mins_sc($atts, $content = NULL)
{
	extract( shortcode_atts( array(
		'para' => 'yes', 
		'caps' => 'no', 
		'end' => '',
	), $atts ) );

	if(is_numeric($content)) 
	{
		$para = strtoupper($para);
		$caps = strtoupper($caps);
		$hoursmins = plm_hours_mins($content);

		if($caps == 'YES')
		{
			$hoursmins = ucwords($hoursmins);
		} elseif ($caps == 'FIRST') {
			$hoursmins = ucfirst($hoursmins);
		}

		if($end != '')
		{
			$hoursmins .= $end;
		}

		if($para == 'YES') 
		{
			return '<p>' . $hoursmins . '</p>';
		} else {
			return $hoursmins;
		}
	} else {
		return '';
	}

}

add_shortcode('hoursmins', 'plm_hours_mins_sc');

function plm_dollarize_sc($atts, $content)
{
	extract( shortcode_atts( array(
		'para' => 'yes', 
		'caps' => 'no', 
		'end' => '',
	), $atts ) );

	$para = strtoupper($para);
	$caps = strtoupper($caps);
	$pieces = explode('.', $content, 2);
	$dollars = $pieces[0];
	$cents = $pieces[1];
	$dollarwords = '';
	$centwords = '';
	$dollarized = '';

	if(is_numeric($dollars))
	{
		$dollarwords = plm_textualize_number($dollars);
		if ($dollars == 1) 
		{
			$dollarized .= $dollarwords . ' dollar';
		} else {
			$dollarized .= $dollarwords . ' dollars';
		}
	}	

	if(is_numeric($cents))
	{
		if (strlen($cents) < 2)
		{
			$cents .= '00';
		}
		$cents = substr($cents, 0 , 2);

		$centwords = plm_textualize_number($cents);
		if (($dollarwords != '') & $centwords != '')
		{
			$dollarized .= ' and ';
		}
		if($centwords != '')
		{	
			if($cents > 1) 
			{
				$dollarized .= $centwords . ' cents';				
			} else {
				$dollarized .= $centwords . ' cent';
			}
		}
	}

	if ($dollarized != '') 
	{
		$dollarized = trim($dollarized);
	
		if($caps == 'YES')
	
		{
			$dollarized = ucwords($dollarized);
		} elseif ($caps == 'FIRST') {
			$dollarized = ucfirst($dollarized);
		}

		if($end != '') 
		{
			$dollarized .= $end;
		}
	
		if($para == 'YES')
		{
			$dollarized = '<p>' . $dollarized . '</p>';
		}

	}
	return $dollarized;
}

add_shortcode('dollarize', 'plm_dollarize_sc');

function plm_year_coder($year, $format = 'short') 
{
	$yreturn = '';

	switch (strtolower($format)) {
		case 'long':
		case 'formal':
		case 'wordy':
			return longyear(substr($year, -4));
			break;
		default: 
			return shortyear(substr($year, -4));
			break;
	}
}

function shortyear($year) {

	switch ($year) {
		case ($year < 1000): 						// first millenium.
			return ucfirst(plm_hundredize( substr( substr( $year, -3), 0, 1) ) ) . ' hundred and ' . plm_hundredize( substr( $year, -2 ) );
			break;
		case (($year >= 1001) AND ($year < 1100)): 	//Special cases for first centuries of milleniums.
		case (($year >= 2001) AND ($year < 2100)):
		case (($year >= 3001) AND ($year < 3100)):
		case (($year >= 4001) AND ($year < 4100)):
		case (($year >= 5001) AND ($year < 5100)):
		case (($year >= 6001) AND ($year < 6100)):
		case (($year >= 7001) AND ($year < 7100)):
		case (($year >= 8001) AND ($year < 8100)):
		case (($year >= 9001) AND ($year < 9100)):
			return ucfirst(plm_hundredize(substr(substr($year, -4), 0, 1) )) . ' thousand and ' . plm_hundredize(substr( $year, -2 ));
			break;
		case 1000: 									// special cases for even thousand years.
		case 2000:
		case 3000:
		case 4000:
		case 5000:
		case 6000:
		case 7000:
		case 8000:
		case 9000:
			return plm_textualize_number(substr($year, -4));
			break;
		case (($year > 1099) AND ($year < 2000)): 	// case of teen centuries.
		default:
			return ucfirst(plm_hundredize( substr( substr( $year, -4 ), 0, 2 ) )) . plm_hundredize( substr( $year, -2 ) );			
			break;
	}

}

function longyear($year) 
{

	$yreturn = '';

	switch ($year) {
		case ($year < 1000): 						// first millenium.
			return ucfirst(plm_hundredize( substr( substr( $year, -3), 0, 1) ) ) . ' hundred and ' . plm_hundredize( substr( $year, -2 ) );
			break;
		case (($year >= 1001) AND ($year < 1100)): 	//Special cases for first centuries of milleniums.
		case (($year >= 2001) AND ($year < 2100)):
		case (($year >= 3001) AND ($year < 3100)):
		case (($year >= 4001) AND ($year < 4100)):
		case (($year >= 5001) AND ($year < 5100)):
		case (($year >= 6001) AND ($year < 6100)):
		case (($year >= 7001) AND ($year < 7100)):
		case (($year >= 8001) AND ($year < 8100)):
		case (($year >= 9001) AND ($year < 9100)):
			return ucfirst(plm_hundredize(substr(substr($year, -4), 0, 1) )) . ' thousand and ' . plm_hundredize(substr( $year, -2 ));
			break;
		case 1000: 									// special cases for even thousand years.
		case 2000:
		case 3000:
		case 4000:
		case 5000:
		case 6000:
		case 7000:
		case 8000:
		case 9000:
			return plm_textualize_number(substr($year, -4));
			break;
		case (($year > 1099) AND ($year < 2000)): 	// case of teen centuries.
		default:
			return ucfirst(plm_hundredize( substr( substr( $year, -4 ), 0, 2 ) )) . ' hundred and ' . plm_hundredize( substr( $year, -2 ) );			
			break;
	}
}

function plm_textdate_sc($atts, $content) {
	extract( shortcode_atts( array(
		'para' => 'yes',
		'end' => '',
		'format' => 'short',
	), $atts ) );

	$para = strtolower($para);
	$format = strtolower($format);
	$caps = TRUE;
	$date_str = '';

	if (strtotime($content)) { 									// Make sure we have a date here!
		$the_date = new DateTime($content);
	} else {
		$the_date = new DateTime('Today');						// If not, use today's date.
	}

	$date_str = plm_text_date($the_date, $format);

	$date_str .= $end;

	if ($para == 'yes') 
	{
		$date_str = '<p>' . $date_str . '</p>';
	}

	return $date_str;
}

function plm_text_date( $the_date, $format = 'short' ) 
{
	if (!($the_date instanceof DateTime)) {
		$the_date = new DateTime('today');
	}

	switch ($format) {

		case 'super-archaic':
		case 'sa':
		case 'very old-timey':
			$date_str .= $the_date->format( 'l' ) . ', the ' . plm_hundredize( $the_date->format( 'j' ), TRUE );
			$date_str .= ' day in the month of ' . $the_date->format( 'F' ) . ' in the year ';
			$date_str .= plm_year_coder( $the_date->format( 'Y' ), 'long');
			break;

		case 'archaic':
		case 'old-timey':			
			$date_str .= $the_date->format('l') . ', the ' . plm_hundredize($the_date->format('j'), TRUE) . ' day of ';
			$date_str .= $the_date->format('F') . ', in the Year ' . plm_year_coder($the_date->format('Y'), 'long');
			break;

		case 'long':
		case 'l':
		case 'formal':
			$date_str .= $the_date->format('l') . ', the ' . plm_hundredize( $the_date->format( 'j'), TRUE ) . ' ';
			$date_str .= $the_date->format( 'F' ) . ', ' . plm_year_coder( $the_date->format( 'Y' ), 'long' );
			break;

		case 'medium':
		case 'm':
		case 'med';
			$date_str .= $the_date->format( 'l' ) . ', the ' . plm_hundredize( $the_date->format( 'j' ), TRUE ) . ' of ';
			$date_str .= $the_date->format( 'F' ) . ', ' . plm_year_coder( $the_date->format( 'Y' ), 'short');
			break;
		case 'super short':
		case 'ss':
		case 'super-short':
			$date_str .= $the_date->format( 'l, F jS, Y');
			break;
		
		default:
			$date_str .= $the_date->format('l') . ', ' . $the_date->format('F') . ' ' . plm_hundredize($the_date->format('d'), TRUE) . ', ';
			$date_str .= plm_year_coder($the_date->format('Y'));
			break;
	}

	return $date_str;
}

add_shortcode('textdate', 'plm_textdate_sc');
?>