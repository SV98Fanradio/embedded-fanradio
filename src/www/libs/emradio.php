<?php
/*
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */
 
 
class emradio
{
	private $api_buffer; // This is where the API response is being buffered. Attribute can be used by any local method
	private $vlc_buffer; // This variable buffers the response of a VLC status query
	private $is_Online;
	
	function __construct($init_api=true)
	{
		if($init_api) 
		{
			$this->GetAPIData();
			$this->GetVLCData();
		}
	}
	
	// Pull API data from the servers
	private function GetAPIData()
	{
		$ch = curl_init();
		// set timeouts
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // Max 5 seconds to connect
		curl_setopt($ch, CURLOPT_TIMEOUT, 8); // Max 8 more seconds to grab all data
		// set url
		curl_setopt($ch, CURLOPT_URL, "https://public.radio.co/stations/sb5fc57b15/status");
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $output contains the output string
		$output = curl_exec($ch);
		// close curl resource to free up system resources
		curl_close($ch); 
		
		// check reponse
		if($output==false)
		{
			$this->is_Online=false;
			return false;
		} else {
			// Parse and save to buffer variable
			$this->api_buffer=json_decode($output,true);	
			$this->is_Online=true;
			return true;
		}
	}
	
	// Get string between two strings
	private function GetStringBetween($string, $start, $finish)
	{
		$string = " ".$string;
		$position = strpos($string, $start);
		if ($position == 0) return "";
		$position += strlen($start);
		$length = strpos($string, $finish, $position) - $position;
		return substr($string, $position, $length);
	}
	
	// Get VLC data
	private function GetVLCData()
	{
		$ch = curl_init();
		// set timeouts
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); // Max 3 seconds to connect
		curl_setopt($ch, CURLOPT_TIMEOUT, 4); // Max 4 more seconds to grab all data
		// set auth
		curl_setopt($ch, CURLOPT_USERPWD, ":sv98fanradio");  
		// set url
		curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/requests/status.xml");
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $output contains the output string
		$this->vlc_buffer = curl_exec($ch);
		// close curl resource to free up system resources
		curl_close($ch); 
	}
	
	public function GetVLCState()
	{
		return $this->GetStringBetween($this->vlc_buffer,"<state>","</state>");
	}
	
	// Return online state
	public function IsOnline()
	{
		return $this->is_Online;
	}
	
	public function GetIP()
	{
		return $_SERVER['SERVER_ADDR'];
	}
	
	public function GetCurrentSong()
	{
		return $this->api_buffer['current_track']['title'];
	}
}

?>
