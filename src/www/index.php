<?php
/* 
 * 
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
 
require("libs/emradio.php");
$emr=new emradio(true);
if($emr->IsOnline())
{
	$online_string="<div class=\"onlinestring\">Verbunden</div>";
} else {
	$online_string="<div class=\"offlinestring\">Getrennt</div>";
}

$vlcstatebuffer=$emr->GetVLCState();

switch ($vlcstatebuffer)
{
	case "playing":
		$sh_vlcstatebuffer="Spielt ab";
		break;
	case "stopped":
		$sh_vlcstatebuffer="Wiedergabe gestoppt";
		break;
	case "paused":
		$sh_vlcstatebuffer="Pausiert";
		break;
	case "buffering":
		$sh_vlcstatebuffer="Puffert Daten";
		break;
	case "ended":
		$sh_vlcstatebuffer="Verbindung abgerissen";
		break;
	case "error":
		$sh_vlcstatebuffer="Fehler";
		break;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>SV 98 Fanradio</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	 <meta http-equiv="refresh" content="10" />
	<meta name="generator" content="Geany 1.32" />
	<link rel="stylesheet" href="style.css" />
</head>

<body>
	
	<table class="maintable">
	<tr class="mainheader">
	<td class="logotd"><img src="fr_logo_trans.png" class="frlogo"></td>
	<td>
		<?php include("header.php"); ?>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<table class="gridtable">
		<tr>
			<td class="gridtd"><div class="gridheader">Netzwerkstatus</div><br>
			<div class="gridbody">
				Verbindungsstatus: <?php echo $online_string; ?><br>
				IP-Adresse des Systems: <?php echo $emr->GetIP(); ?>
			</div>
			</td>
			<td class="gridtd"><div class="gridheader">Jetzt im Stream:</div><br>
			<div class="gridbody">
				<?php echo $emr->GetCurrentSong(); ?>
			</div>
			</td>
			<td class="gridtd"><div class="gridheader">Radio-Status</div><br>
			<div class="gridbody">
				<?php echo $sh_vlcstatebuffer; ?>
			</div>
			</td>
		</tr>
		<tr>
		<td class="gridtd" colspan="3">
		<div class="gridheader">Lizenzinformationen</div><br>
		<div class="gridbody">
		<?php include("licinfo.php"); ?>
		</div>
		</td>
		</tr>
	</table>
	</td>
	</tr>
	</table>
	
</body>

</html>
