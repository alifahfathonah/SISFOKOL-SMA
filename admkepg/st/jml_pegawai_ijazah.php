<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMA_v5.0_(PernahJaya)                          ///////
/////// (Sistem Informasi Sekolah untuk SMA)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://omahbiasawae.com/                          ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS/WA : 081-829-88-54                               ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admkepg.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "jml_pegawai_ijazah.php";
$judul = "Jumlah Pegawai Menurut Ijazah";
$judulku = "[$kepg_session : $nip16_session.$nm16_session] ==> $judul";
$judulx = $judul;








//isi *START
ob_start();

//menu
require("../../inc/menu/admkepg.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();




//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table border="1" cellpadding="3" cellspacing="0">
<tr bgcolor="'.$warnaheader.'">';

//ijazah
$qkdt = mysql_query("SELECT * FROM m_ijazah ".
			"ORDER BY ijazah ASC");
$rkdt = mysql_fetch_assoc($qkdt);
$tkdt = mysql_num_rows($qkdt);

do
	{
	//nilai
	$kdt_kd = nosql($rkdt['kd']);
	$kdt_ijazah = balikin2($rkdt['ijazah']);

	echo '<td width="50"><strong>'.$kdt_ijazah.'</strong></td>';
	}
while ($rkdt = mysql_fetch_assoc($qkdt));

echo '</tr>';
echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";

//ijazah
$qkdt = mysql_query("SELECT * FROM m_ijazah ".
			"ORDER BY ijazah ASC");
$rkdt = mysql_fetch_assoc($qkdt);
$tkdt = mysql_num_rows($qkdt);

do
	{
	//nilai
	$i_kd = nosql($rkdt['kd']);
	$i_ijazah = balikin2($rkdt['ijazah']);


	//ketahui jumlahnya
	$qjlx = mysql_query("SELECT m_pegawai.*, m_pegawai_pendidikan.* ".
				"FROM m_pegawai, m_pegawai_pendidikan ".
				"WHERE m_pegawai_pendidikan.kd_pegawai = m_pegawai.kd ".
				"AND m_pegawai_pendidikan.kd_ijazah = '$i_kd'");
	$rjlx = mysql_fetch_assoc($qjlx);
	$tjlx = mysql_num_rows($qjlx);


	echo '<td valign="top">
	'.$tjlx.'
	</td>';
	}
while ($rkdt = mysql_fetch_assoc($qkdt));

echo '</tr>
</table>

</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>