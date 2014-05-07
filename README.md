Numberizer
=============

This Wordpress offers several shortcodes and functions which convert numbers of various types into 
their text equivalents.


## [Textualize](https://github.com/castleisland-wp/plm-numberize/wiki/textualize)
This shortcode converts a number to the word equivalent. 525 becomes "Five hundred twenty-five."
```
[textualize para="yes|no" caps="first|yes|no" end="any_char" ordinals="yes|no"]123[/textualize]

para:     Yes (Default) = Enclose output in paragraph tags.
caps:     First = Capitalize first word. Yes = Capitalize all words. No (default) = No 
          capitalization.
end:      End output with this character.
ordinals: End output with first, second, third instead on one, two, three.

```
### [Template Tag](https://github.com/castleisland-wp/plm-numberize/wiki/Template-Tags#text-number) 
```
$string = plm_text_number($number, $ordinal, $echo);

$echo:    TRUE = echo output. FALSE (Default) = return value.
```

## [TextDate](https://github.com/castleisland-wp/plm-numberize/wiki/TextDate)
This shortcode converts a standard date to a very wordy, text expression of the same value.
```
[textdate para="yes|no" end="char" format="short|medium|long|very long|very very long" date_fmt="string"]Date[/textdate] 

format:   Select the format for the return value.
date_fmt: Format string to use when format = "custom"
```
For more information on formats see the [wiki page](https://github.com/castleisland-wp/plm-numberize/wiki/TextDate). For more information about custom format strings, see [this page](https://github.com/castleisland-wp/plm-numberize/wiki/Custom-Date-Formats).

### [Template Tag](https://github.com/castleisland-wp/plm-numberize/wiki/Template-Tags#text-date)
```
plm_text_date($date, $format = 'short', $date_fmt, $echo)
```

## [HoursMins](https://github.com/castleisland-wp/plm-numberize/wiki/HoursMins)
This shortcode converts a number of minutes into a full text of hours and minutes. 135 becomes 
"Two hours and fifteen minutes."
```
[hoursmins para="yes|no" caps="first|yes" end="any_char"] 123 [/hoursmins] 
```
### [Template Tags](https://github.com/castleisland-wp/plm-numberize/wiki/Template-Tags#hours-and-minutes) 
```
$string = plm_hours_and_minutes($minutes, $echo) 
```
```
$array() = plm_get_hours_and_minutes($minutes) 
```

## [Dollarize](https://github.com/castleisland-wp/plm-numberize/wiki/Dollarize)
This shortcode converts a decimal number to text like this, "Two dollars, ninety-eight cents."
```
[dollarize para="yes|no" caps="first|yes" end="any_char"] 2.98 [/dollarize] 
```
### [Template Tag](https://github.com/castleisland-wp/plm-numberize/wiki/Template-Tags#dollars-and-cents)
```
plm_dollars_and_cents($number, $echo)
```

## [Romanize](https://github.com/castleisland-wp/plm-numberize/wiki/Romanize)
This shortcode converts a number (up to 3,999) to a Roman numeral.
```
[romanize]2014[/romanize]
```
### [Template Tag](https://github.com/castleisland-wp/plm-numberize/wiki/Template-Tags#roman-numeral)
```
plm_roman_numeral($number, $echo)
```
