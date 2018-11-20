<?php
namespace Netliva\Helpers;

class IpGeo
{

	private $purpose, $ip, $deep_detect;
	public function __construct ($purpose = "all", $ip = NULL, $deep_detect = TRUE)
	{
		$this->purpose = $purpose;
		$this->deep_detect = $deep_detect;
		$this->setIp($ip);
	}

	function getInfo($purpose = null)
	{
		$output = NULL;
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose?$purpose:$this->purpose)));
		$support    = array("all", "ip", "country", "countrycode", "state", "region", "city", "address", "currencycode", "currencysymbol", "currencyconverter");

		if (filter_var($this->ip, FILTER_VALIDATE_IP) && in_array($purpose, $support))
		{
			$data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $this->ip));
			if (@strlen(trim($data->geoplugin_countryCode)) == 2)
			{
				switch ($purpose)
				{
					case "all":
						$output = array(
							"ip"					=> $this->ip,
							"city"					=> @$data->geoplugin_city,
							"state"					=> @$data->geoplugin_regionName,
							"country"				=> @$data->geoplugin_countryName,
							"country_code"			=> @$data->geoplugin_countryCode,
							"continent"				=> $this->getContinents(strtoupper($data->geoplugin_continentCode)),
							"continent_code"		=> @$data->geoplugin_continentCode,
							"currency_code" 		=> @$data->geoplugin_currencyCode,
							"currency_symbol" 		=> @$data->geoplugin_currencySymbol_UTF8,
							"currency_converter" 	=> @$data->geoplugin_currencyConverter
						);
						break;
					case "address":
						$address = array($data->geoplugin_countryName);
						if (@strlen($data->geoplugin_regionName) >= 1)
							$address[] = $data->geoplugin_regionName;
						if (@strlen($data->geoplugin_city) >= 1)
							$address[] = $data->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "ip":
						$output = $this->getIp();
						break;
					case "city":
						$output = @$data->geoplugin_city;
						break;
					case "state":
						$output = @$data->geoplugin_regionName;
						break;
					case "region":
						$output = @$data->geoplugin_regionName;
						break;
					case "country":
						$output = @$data->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$data->geoplugin_countryCode;
						break;
					case "currencycode":
						$output = @$data->geoplugin_currencyCode;
						break;
					case "currencysymbol":
						$output = @$data->geoplugin_currencySymbol_UTF8;
						break;
					case "currencyconverter":
						$output = @$data->geoplugin_currencyConverter;
						break;
				}
			}
		}
		return $output;
	}

	public function getContinents($key = null)
	{
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if ($key and key_exists($key, $continents))
			return $continents[$key];
		elseif (!$key) return$continents;

		return null;

	}

	/**
	 * @param string $purpose
	 */
	public function setPurpose (string $purpose): void
	{
		$this->purpose = $purpose;
	}

	/**
	 * @param null $ip
	 */
	public function setIp ($ip): void
	{
		$this->ip = $ip;

		if (filter_var($this->ip, FILTER_VALIDATE_IP) === FALSE) {
			$this->ip = @$_SERVER["REMOTE_ADDR"];
			if ($this->deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$this->ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}

	}
	/**
	 * @return null|string
	 */
	public function getIp ()
	{
		return $this->ip;
	}

	/**
	 * @param bool $deep_detect
	 */
	public function setDeepDetect (bool $deep_detect): void
	{
		$this->deep_detect = $deep_detect;
	}
}