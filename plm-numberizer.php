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
Class plm_Numberize {

	protected $number_text = array(
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
	
	protected $ordinal_text = array(
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

	protected $roman_numerals = array(
		'M'  => 1000,
		'CM' => 900,
		'D'  => 500,
		'CD' => 400,
		'C'  => 100,
		'XC' => 90,
		'L'  => 50,
		'XL' => 40,
		'X'  => 10,
		'IX' => 9,
		'V'  => 5,
		'IV' => 4,
		'I'  => 1);

	public function romanize($number = 1)
	{
		$num = intval($number);
		$ret = '';

		foreach ($this->roman_numerals as $roman => $decimal) {
			$matches = intval($num/$decimal);
			$ret .= str_repeat($roman, $matches);
			$num = $num % $decimal;
		}

		return $ret;
	}

	public function roman_shortcode($atts, $content) 
	{
		if(is_numeric($content) & !(is_null($content)|($content==''))) {
			return $this->romanize($content);
		}
	}

	public function hundredize($the_number, $do_ord=FALSE)
	{
		$hundredized = '';
	
		$the_number = intval($the_number);
	
		if ($the_number > 1000) 
		{
			$computed = 999;
		} else {
			$computed = $the_number;
		}
		
		if ($computed > 99) 
		{
			$hundreds = intval($computed/100);
	
			$computed = $computed - ($hundreds * 100);
			$hundredized = $this->number_text[$hundreds];
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
				$hundredized .= $this->number_text[$tens];
			} else {
				$hundredized .= $this->ordinal_text[$tens];
			}
			
			if (($computed % 10) != 0)
			{
				$hundredized .= '-';
				
				if(!$do_ord) {
	
					$hundredized .= $this->number_text[($computed % 10)];
				} else {
					$hundredized .= $this->ordinal_text[($computed % 10)];
				}
			}
		} else {
			if (!$do_ord) {
				$hundredized .= $this->number_text[$computed];
			} else {
				$hundredized .= $this->ordinal_text[$computed];
			}
			
		}
	
		return $hundredized;
	}

	public function textualize($the_number, $do_ord=FALSE)
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
				$textualized .= $this->hundredize($quadrillions) . ' quadrillion ';
			} else {
				$textualized .= $this->hundredize($quadrillions) . ' quadrillionth';
			}
		}	
	
	
		if ($computed >= 1E+12) 
		{
			$trillions = intval($computed/1E+12);
			$computed = $computed - ($trillions * 1E+12);
			if ($computed != 0 OR !$do_ord) {
				$textualized .= $this->hundredize($trillions) . ' trillion ';
			} else {
				$textualized .= $this->hundredize($trillions) . ' trillionth';
			}		
		}	
	
		if ($computed >= 1E+9) 
		{
			$billions = intval($computed/1E+9);
			$computed = $computed - ($billions * 1E+9);
			if ($computed != 0 OR !$do_ord) {
				$textualized .= $this->hundredize($billions) . ' billion ';
			} else {
				$textualized .= $this->hundredize($billions) . ' billionth';
			}
		}	
	
		if ($computed >= 1E+6)
		{
			$millions = intval($computed/1E+6);
			$computed = $computed - ($millions * 1E+6);
			if ($computed != 0 OR !$do_ord) {
				$textualized .= $this->hundredize($millions) . ' million ';
			} else {
				$textualized .= $this->hundredize($millions) . ' millionth';
			}
		}
	
		if ($computed >= 1000)
		{
			$thousands = intval($computed/1000);
			$computed = $computed - ($thousands * 1000);
			if ($computed != 0 OR !$do_ord) {
				$textualized .= $this->hundredize($thousands) . ' thousand ';
			} else {
				$textualized .= $this->hundredize($thousands) . ' thousandth';
			}
		}
	
		if ($computed != 0)
		{
			$textualized .= $this->hundredize($computed, $do_ord);
		}
	
		return trim($textualized);
	}
	
	public function text_shortcode($atts, $content = NULL) 
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
			$textnum = $this->textualize($content, $do_ord);
	
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
	
	public function hours_mins($mins) 
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
				$hoursmins .= $this->textualize($hour_cnt) . ' hour ';
			} elseif ($hour_cnt > 1) {
				$hoursmins .= $this->textualize($hour_cnt) . ' hours ';
			}
	
			if(($hour_cnt != 0) & ($min_cnt != 0))
			{
				$hoursmins .= ' and ';
			}
	
			if($min_cnt == 1) 
			{
				$hoursmins .= $this->hundredize($min_cnt) . ' minute ';			
			} elseif($min_cnt > 1) {
				$hoursmins .= $this->hundredize($min_cnt) . ' minutes ';	
			}
		}
	
		return trim($hoursmins);
	}
	
	public function hm_shortcode($atts, $content = NULL)
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
			$hoursmins = $this->hours_mins($content);
	
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
	
	public function dollar_shortcode($atts, $content)
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
			$dollarwords = $this->textualize($dollars);
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
	
			$centwords = $this->textualize($cents);
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
	
	public function year_coder($year, $format = 'short') 
	{
		$yreturn = '';
	
		switch (strtolower($format)) {
			case 'long':
			case 'formal':
			case 'wordy':
				return $this->longyear(substr($year, -4));
				break;
			default: 
				return $this->shortyear(substr($year, -4));
				break;
		}
	}
	
	public function shortyear($year) 
	{
	
		switch ($year) {
			case ($year < 1000): 						// first millenium.
				return ucfirst($this->hundredize( substr( substr( $year, -3), 0, 1) ) ) . ' hundred and ' . $this->hundredize( substr( $year, -2 ) );
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
				return ucfirst($this->hundredize(substr(substr($year, -4), 0, 1) )) . ' thousand and ' . $this->hundredize(substr( $year, -2 ));
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
				return $this->textualize(substr($year, -4));
				break;
			case (($year > 1099) AND ($year < 2000)): 	// case of teen centuries.
			default:
				return ucfirst($this->hundredize( substr( substr( $year, -4 ), 0, 2 ) )) . $this->hundredize( substr( $year, -2 ) );			
				break;
		}
	
	}
	
	public function longyear($year) 
	{
	
		$yreturn = '';
	
		switch ($year) {
			case ($year < 1000): 						// first millenium.
				return ucfirst($this->hundredize( substr( substr( $year, -3), 0, 1) ) ) . ' hundred and ' . $this->hundredize( substr( $year, -2 ) );
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
				return ucfirst($this->hundredize(substr(substr($year, -4), 0, 1) )) . ' thousand and ' . $this->hundredize(substr( $year, -2 ));
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
				return $this->textualize(substr($year, -4));
				break;
			case (($year > 1099) AND ($year < 2000)): 	// case of teen centuries.
			default:
				return ucfirst($this->hundredize( substr( substr( $year, -4 ), 0, 2 ) )) . ' hundred and ' . $this->hundredize( substr( $year, -2 ) );			
				break;
		}
	}
	
	public function date_shortcode($atts, $content) 
	{
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
	
		$date_str = $this->text_date($the_date, $format);
	
		$date_str .= $end;
	
		if ($para == 'yes') 
		{
			$date_str = '<p>' . $date_str . '</p>';
		}
	
		return $date_str;
	}
	
	public function text_date( $the_date, $format = 'short', $date_fmt = '%1$s, %3$s %2$s, %4$s' ) 
	{
		if (!($the_date instanceof DateTime)) {
			$the_date = new DateTime('today');
		}

		$date_str = '';
	
		switch ($format) {
	
			case 'super-archaic':
			case 'sa':
			case 'very old-timey':
			case 'very very long':
				$date_fmt = '%s, the %s day in the month of %s in the year %s';
				break;
	
			case 'archaic':
			case 'old-timey':
			case 'very long':
				$date_fmt = '%s, the %s day of %s, in the Year %s';
				break;
	
			case 'long':
			case 'l':
			case 'formal':
				$date_fmt = '%s, the %s of %s, %s';
				break;
	
			case 'medium':
			case 'm':
			case 'med';
				$date_fmt = '%1$s, %3$s %2$s, %4$s';
				break;
			case 'super short':
			case 'ss':
			case 'super-short':
				$date_str .= $the_date->format( 'l, F jS, Y');
				break;
			case 'custom':
				break;
			default:
				$date_fmt = '%1$s, %3$s %2$s, %4$s';
				break;
		}

		if($date_str == '') {
			$date_str = sprintf($date_fmt, 
				$the_date->format( 'l' ),
				$this->hundredize($the_date->format( 'j' ), TRUE),
				$the_date->format( 'F' ),
				$this->year_coder( $the_date->format( 'Y' ), 'long')
				);
		}
	
		return $date_str;
	}

	public function __construct() 
	{
		add_shortcode('textdate', array($this, 'date_shortcode'));
		add_shortcode('textualize', array($this, 'text_shortcode'));
		add_shortcode('hoursmins', array($this, 'hm_shortcode'));
		add_shortcode('dollarize', array($this, 'dollar_shortcode'));
		add_shortcode('roman', array($this, 'roman_shortcode'));
	}
}

$plm_numberizer = new plm_Numberize;

function plm_romanize($number, $echo = FALSE) {
	$ret = '';
	global $plm_numberizer;

	if (is_numeric($number)) {
		$ret = $plm_numberizer->romanize($number);
	}

	if($echo) {
		echo $ret;
	} else {
		return $ret;
	}
}

function plm_textdate($the_date, $format = 'short', $date_fmt = '%1$s, %3$s %2$s, %4$s')
{

}
?>