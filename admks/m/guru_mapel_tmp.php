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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admks.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "guru_mapel_tmp.php";
$judul = "Penempatan Guru Mengajar";
$judulku = "[$ks_session : $nip4_session.$nm4_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$s = nosql($_REQUEST['s']);
$ke = "$filenya?tapelkd=$tapelkd&jnskd=$jnskd";




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}

else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}







//isi *START
ob_start();

//menu
require("../../inc/menu/admks.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//VIEW //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$ke.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Jenis Mata Pelajaran : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd = '$jnskd'");
$rowjnx = mysql_fetch_assoc($qjnx);

$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = balikin($rowjnx['jenis']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd <> '$jnskd' ".
						"ORDER BY jenis ASC");
$rowjn = mysql_fetch_assoc($qjn);

do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['jenis']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&keakd='.$keakd.'&kompkd='.$kompkd.'&kelkd='.$kelkd.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="jnskd" type="hidden" value="'.$jnskd.'">
</td>
</tr>
</table>
<br>';


//nek blm
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}

else if (empty($jnskd))
	{
	echo '<p>
	<strong><font color="#FF0000">JENIS PROGRAM PENDIDIKAN Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	//query
	$q = mysql_query("SELECT DISTINCT(m_pegawai.nip) AS nip ".
							"FROM m_guru, m_pegawai ".
							"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
							"ORDER BY round(m_pegawai.nip) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	if ($total != 0)
		{
		echo '<table width="700" border="1" cellpadding="3" cellspacing="0">
    	<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong>No.</strong></td>
		<td width="5" valign="top"><strong>NIP</strong></td>
    	<td valign="top"><strong><font color="'.$warnatext.'">Guru</font></strong></td>
    	<td width="300" valign="top"><strong><font color="'.$warnatext.'">Kelas - Mata Pelajaran</font></strong></td>
    	</tr>';

		do
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}

			$nomer = $nomer + 1;
			$i_nip = nosql($row['nip']);

			//detail
			$qpd = mysql_query("SELECT * FROM m_pegawai ".
						"WHERE nip = '$i_nip'");
			$rpd = mysql_fetch_assoc($qpd);
			$pd_kd = nosql($rpd['kd']);
			$pd_nama = balikin($rpd['nama']);


			//nek null
			if (empty($i_nip))
				{
				$i_nip = "-";
				}

			echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">'.$nomer.'. </td>
    			<td valign="top">'.$i_nip.'</td>
			<td valign="top">
			'.$pd_nama.'
			</td>
			<td valign="top">';


			//pel-nya
			$quru = mysql_query("SELECT m_guru_prog_pddkn.*, m_guru_prog_pddkn.kd AS mgkd, m_guru.* ".
								"FROM m_guru_prog_pddkn, m_guru ".
								"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
								"AND m_guru.kd_pegawai = '$pd_kd'");
			$ruru = mysql_fetch_assoc($quru);


			do
				{
				$gkd = nosql($ruru['mgkd']);
				$kd_prog_pddkn = nosql($ruru['kd_prog_pddkn']);
				$pkd = nosql($ruru['kd_prog_pddkn']);
				$kd_kelas = nosql($ruru['kd_kelas']);


				//mapel
				$q1 = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$kd_prog_pddkn'");
				$r1 = mysql_fetch_assoc($q1);
				$gpel = balikin($r1['prog_pddkn']);


				//kelas
				$q2 = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kd = '$kd_kelas'");
				$r2 = mysql_fetch_assoc($q2);
				$gkelas = balikin($r2['kelas']);


				//nek null
				if (empty($gkd))
					{
					echo "-";
					}
				else
					{
					//cek janissari
					$qcc1 = mysql_query("SELECT * FROM guru_mapel ".
								"WHERE kd_user = '$pd_kd' ".
								"AND kd_mapel = '$pkd'");
					$rcc1 = mysql_fetch_assoc($qcc1);
					$tcc1 = mysql_num_rows($qcc1);

					//jika ada, update
					if ($tcc1 != 0)
						{
						//cuekin aja...
						}
					else
						{
						//masukkan ke janissari
						mysql_query("INSERT INTO guru_mapel(kd, kd_user, kd_mapel) VALUES ".
								"('$pkd', '$pd_kd', '$pkd')");
						}

					echo '<strong>*</strong>('.$gkelas.') '.$gpel.'
					<br>';
					}
				}
			while ($ruru = mysql_fetch_assoc($quru));



			echo '</td>
    			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="700" border="0" cellspacing="0" cellpadding="3">
    	<tr>
    	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
    	</tr>
	  	</table>';
		}
	}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");
?>