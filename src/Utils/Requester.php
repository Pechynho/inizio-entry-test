<?php


namespace App\Utils;


use Exception;

class Requester
{
	public const METHOD_GET = "GET";
	public const METHOD_POST = "POST";


	/**
	 * @param string     $url
	 * @param string     $method
	 * @param array|null $data
	 * @return string|bool
	 * @throws Exception
	 */
	public static function makeRequest(string $url, string $method = self::METHOD_GET, ?array $data = null)
	{
		// Assemble request.
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Encoding: UTF-8']);
		curl_setopt($process, CURLOPT_HEADER, 0);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
		if ($data != null)
		{
			$requestBody = json_encode($data);
			curl_setopt($process, CURLOPT_POSTFIELDS, $requestBody);
		}

		// Process the request.
		$return = curl_exec($process);
		$requestInfo = curl_getinfo($process);
		curl_close($process);
		// Resolve response status to more descriptive messages.
		$statusCode = $requestInfo['http_code'];
		if ($statusCode === 200 || $statusCode === 201)
		{
			return $return;
		}
		else if ($statusCode === 400)
		{
			throw new Exception("Invalid request parameters.");
		}
		else if ($statusCode === 404)
		{
			throw new Exception("Invalid URL specified.");
		}
		else if ($statusCode === 401)
		{
			throw new Exception("Invalid credentials specified.");
		}
		else if ($statusCode === 403)
		{
			throw new Exception("User is not allowed to perform the operation.");
		}
		else
		{
			throw new Exception("Unexpected error occurred.");
		}
	}
}