<?php
define('Copyright', '����QQ��506694599');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
$db = new DB();
include_once (dirname(__FILE__)."/config.php");
?>
<? header("content-Type: text/html; charset=gb2312");?>
<?php
  // ������������
  function HexToStr($hex)
  {
     $string="";
     for ($i=0;$i<strlen($hex)-1;$i+=2)
         $string.=chr(hexdec($hex[$i].$hex[$i+1]));
     return $string;
  }

//=========================== ���̼ҵ������Ϣ����ȥ =======================

	$m_id		= 	'';			 //�̼Һ�
	$m_orderid	= 	'';			//�̼Ҷ�����
	$m_oamount	= 	'';			//֧�����
	$m_ocurrency= 	'';			//����
	$m_language	= 	'';			//����ѡ��
	$s_name		= 	'';			//����������
	$s_addr		= 	'';			//������סַ
	$s_postcode	= 	''; 		//��������
	$s_tel		= 	'';			//��������ϵ�绰
	$s_eml		= 	'';			//�������ʼ���ַ
	$r_name		= 	'';			//����������
	$r_addr		= 	'';			//�ջ���סַ
	$r_postcode	= 	''; 		//�ջ�����������
	$r_tel		= 	'';			//�ջ�����ϵ�绰
	$r_eml		= 	'';			//�ջ��˵��ӵ�ַ
	$m_ocomment	= 	''; 		//��ע
	$modate		=	'';			//��������
	$State		=	'';			//֧��״̬2�ɹ�,3ʧ��

	//��������ļ���
	$OrderInfo	=	$_POST['OrderMessage'];			//����������Ϣ

	$signMsg 	=	$_POST['Digest'];				//�ܳ�
	//�����µ�md5������֤


	//$digest = $MD5Digest->encrypt($OrderInfo.$key);
	$digest = strtoupper(md5($OrderInfo.$key));

?>
<?php
	if ($digest == $signMsg)
	{
		//����
		//$decode = $DES->Descrypt($OrderInfo, $key);
		$OrderInfo = HexToStr($OrderInfo);
		//=========================== �ֽ��ַ��� ====================================
		$parm=explode("|", $OrderInfo);

		$m_id		= 	$parm[0];
		$m_orderid	= 	$parm[1];
		$m_oamount	= 	$parm[2];
		$m_ocurrency= 	$parm[3];
		$m_language	= 	$parm[4];
		$s_name		= 	$parm[5];
		$s_addr		= 	$parm[6];
		$s_postcode	= 	$parm[7];
		$s_tel		= 	$parm[8];
		$s_eml		= 	$parm[9];
		$r_name		= 	$parm[10];
		$r_addr		= 	$parm[11];
		$r_postcode	= 	$parm[12];
		$r_tel		= 	$parm[13];
		$r_eml		= 	$parm[14];
		$m_ocomment	= 	$parm[15];
		$modate		=	$parm[16];
		$State		=	$parm[17];

		if ($State == 2)
		{ 
		echo "ok";
		$res=$db->query("select p.g_state,p.g_name,u.g_money_yes from g_qdetail p left join g_user u on p.g_name=u.g_name where p.ordernum='{$m_orderid}'",1);
		 
		if($res[0]['status']=="3"){
			
			$db->query("UPDATE g_qdetail set g_state='�Զ���ֵ���', g_type='0' where ordernum='{$m_orderid}'",0);
			$db->query("UPDATE g_user SET g_money_yes=g_money_yes+$m_oamount where g_name='".$res[0]['g_name']."'",0);
		 
		
			$valueList = array();
			$valueList['g_name'] = $res[0]['g_name'];
			$valueList['g_f_name'] = $_SESSION['sName'];
			$valueList['g_initial_value'] = $res[0]['g_money_yes'];
			$valueList['g_up_value'] = $res[0]['g_money_yes']+$m_oamount;
			$valueList['g_up_type'] = '��ֵ';
			$valueList['g_s_id'] = 1;
			insertLogValue($valueList);
		}
				echo "֧���ɹ�".'<br>';
				echo "�̼Һ�=".$m_id.'<br>';
				echo "������=".$m_orderid.'<br>';
				echo "���=".$m_oamount.'<br>';
				echo ".................";
			}
		else
			{
				echo "֧��ʧ��";
			}
?>
<?php
	}else{
?>
	ʧ�ܣ���Ϣ���ܱ��۸�
<?php
	}
?>
<!--
����ʹ��dinpayʵʱ�����ӿڵ��̻���ע�⣺
    Ϊ�˴Ӹ����Ͻ������֧���ɹ����̻��ղ���������Ϣ������(��Ƶ���).
�ҹ�˾��������Ϣ��������ʵ�з������˶Է������˵ķ�����ʽ.���ͻ�֧������.
����ϵͳ����̻�����վ��������֧����Ϣ�ķ���(����ͬһ�ʶ�����Ϣ�������η���).
��һ���Ƿ������˶Է������˵ķ���.�ڶ�������ҳ�����ʽ����.���η�����ʱ�Ӳ���10��֮��.
    ���̻��Ǳ����ö����Ƿ�����Ϣ�Ĵ���. ������ϵͳ������ͬ�Ķ�����Ϣ���Ǳ�ֻ
    ��һ�δ����Ϳ�����.��ȷ�������ߵ�ÿһ�ʶ�����Ϣ�����Ǳ�ֻ�õ�һ����Ӧ�ķ���!!
-->