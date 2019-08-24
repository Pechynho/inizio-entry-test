<?php


namespace App\Utils;


class Strings extends \Nette\Utils\Strings
{
	const CASE_TYPE_CAMEL = "camel_case"; //konstanta pro camel case
	const CASE_TYPE_PASCAL = "pascal_case"; //konstanta pro pascal case

	/**
	 * Nahradí hodnot $oldValue hodnotou $newValue v $text.
	 * @param string $text
	 * @param string $oldValue
	 * @param string $newValue
	 * @return string
	 */
	public static function simpleReplace($text, $oldValue, $newValue)
	{
		return str_replace($oldValue, $newValue, $text);
	}

	/**
	 * Vrátí výsledek, jestli $text obsahuje null, prázdný řetězec nebo je tvořen jen bílými znaky.
	 * @param string $text
	 * @return bool
	 */
	public static function isNullOrWhiteSpace($text)
	{
		return is_null($text) || (is_string($text) && trim($text) === "");
	}

	/**
	 * Vrátí výsledek, jestli $text obsahuje null nebo prázdný řetězec.
	 * @param string $text
	 * @return bool
	 */
	public static function isNullOrEmpty($text)
	{
		return is_null($text) || (is_string($text) && $text === "");
	}


	/**
	 * Převede $text do camel case nebo pascal case ($caseType), podle zadaného separátoru ($separator).
	 * @param string $text
	 * @param string $separator
	 * @param string $caseType
	 * @return string
	 */
	private static function convertToCase($text, $separator, $caseType = self::CASE_TYPE_CAMEL)
	{
		$result = str_replace(' ', '', mb_convert_case(str_replace($separator, ' ', $text), MB_CASE_TITLE));
		if ($caseType == self::CASE_TYPE_CAMEL)
		{
			$result = self::firstLower($result);
		}

		return $result;
	}

	/**
	 * Převede $text z pascal case nebo camel case a spojí ho požadovaným separátorem ($separator).
	 * @param string $text
	 * @param string $separator
	 * @return string
	 */
	private static function convertFromCase($text, $separator)
	{
		return ltrim(mb_strtolower(preg_replace('/[A-Z]/', $separator . '$0', $text)), $separator);
	}

	/**
	 * Převede $text obsahující pomlčky do camel case nebo pascal case ($caseType).
	 * Př: user-controller => userController/UserController
	 * @param string $text
	 * @param string $caseType
	 * @return string
	 */
	public static function dashesToCase($text, $caseType = self::CASE_TYPE_CAMEL)
	{
		return self::convertToCase($text, '-', $caseType);
	}

	/**
	 * Převede $text obsahující podtržítka do camel case nebo pascal case ($caseType).
	 * Př: user_controller => userController/UserController
	 * @param string $text
	 * @param string $caseType
	 * @return string
	 */
	public static function underscoresToCase($text, $caseType = self::CASE_TYPE_CAMEL)
	{
		return self::convertToCase($text, '_', $caseType);
	}

	/**
	 * Převede $text z camel case nebo pascal case do tvaru s pomlačkami.
	 * Př: userController/UserController => user-controller
	 * @param string $text
	 * @return string
	 */
	public static function caseToDashes($text)
	{
		return self::convertFromCase($text, '-');
	}

	/**
	 * Převede $text z camel case nebo pascal case do tvaru s podtržítkami.
	 * Př: userController/UserController => user_controller
	 * @param string $text
	 * @return string
	 */
	public static function caseToUnderscores($text)
	{
		return self::convertFromCase($text, '_');
	}

}