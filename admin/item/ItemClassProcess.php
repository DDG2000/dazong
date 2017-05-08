<?php
/****************************************************************** 
**创建者：sakura
**创建时间：2014-11-04
**本页： 用户类型 管理
**说明：
******************************************************************/
error_reporting(0);
set_time_limit(0);
require_once('../include/TopFile.php'); 
require(WEBROOTINC.'ExcelImport.php');
require(WEBROOTINCCLASS.'ItemClass.php');
require(WEBROOTINCCLASS.'Item.php');
require(WEBROOTINCCLASS.'ItemFactory.php');
require(WEBROOTINCCLASS.'ItemStuff.php');
require(WEBROOTINCCLASS.'ItemSpecification.php');
$Admin->CheckPopedoms('SM_ITEM_CLASS');
$Work   = $FLib->RequestChar('Work',1,50,'参数',1);
if(!$Config->Link)
{
	$DataBase->OpenDataBase();
}
$mallclass='钢材市场';
$I_mall_classID=1;//钢材市场id
$tt = '分类管理';

$obj = $FLib->RequestChar('obj',1,50,'父窗口标记',1);
$ItemClass = new ItemClass();

switch($Work)
 {
 	case 'MdyReco': /**编辑**/
		 $Admin->CheckPopedoms('SM_ITEM_CLASS_MDY');
	     GetValue($FLib);
		 $Id = $FLib->RequestInt('Id',0,9,'ID');
		
		 //$DataBase->QuerySql("update sm_item_class set Vc_name='$name',I_order='$order' where id='$Id'");
		 $ItemClass->editItemClass($name, $order, $Id);
		 $r = createitemclasscache();
// 		 $msg = $r['flag']<1 ? ',生成失败!'.$r['err']:'';
		 $msg = $r['flag']<1 ? ',生成失败!':'';
		 $Admin ->AddLog($mallclass.'分类管理','修改类型：其Id为：'.$Id );
		 echo showSuc($tt.'编辑成功'.$msg,$FLib->IsRequest('backurl'),$obj);
         break;
	case 'AddReco': /**增加**/
		 $Admin->CheckPopedoms('SM_ITEM_CLASS_MDY');
		 GetValue($FLib);
		
// 		 $DataBase->QuerySql("insert into sm_item_class(I_mall_classID,Vc_name,I_order,Createtime,Status) values
// 		 ($I_mall_classID,'$name','$order',now(),1)");
		$r1= $ItemClass->addItemClass($I_mall_classID, $name, $order);
// 		 var_dump($r1);
// 		 exit();
		 $r = createitemclasscache();
		 $msg = $r['flag']<1 ? ',生成失败!':'';
		 $Admin ->AddLog($mallclass.'分类管理','增加类型：其名称为：'.$name);
		 
		 echo showSuc($tt.'添加成功'.$msg,$FLib->IsRequest('backurl'),$obj);
         break;
	case 'ImportReco': /**导入增加**/
		 $Admin->CheckPopedoms('SM_ITEM_CLASS_MDY');
		
		 if (! empty ( $_FILES ['file_stu'] ['name'] ))
		 {
		     $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
		     $file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
		     $file_type = $file_types [count ( $file_types ) - 1];
		     /*判别是不是.xls文件，判别是不是excel文件*/
		     if (strtolower ( $file_type ) != "xls")
		     {
		         //$this->error ( '不是后缀为xls的Excel文件，请重新上传' );
		         $msg = '不是后缀为xls的Excel文件，请重新上传';
		         echo showErr($msg);
		         exit;
		     }
		
		     /*设置上传路径*/
		     $savePath = WEBROOT . 'data/upfile/excel/';
		     /*以时间来命名上传的文件*/
		     $str = date ( 'Ymdhis' );
		     $file_name = $str . "." . $file_type;
		     /*是否上传成功*/
		     if (! copy ( $tmp_file, $savePath . $file_name ))
		     {
		        // $this->error ( '上传失败' );
		         $msg = '上传失败';
		         echo showErr($msg);
		         exit;
		     }
		     /*
		      *对上传的Excel数据进行处理生成编程数据,ExcelToArray类中
		      *这里调用执行了类里面的read函数，把Excel转化为数组并返回给$res,再进行数据库写入
		      */
		     $excel = new ExcelImport();
		     $res = $excel->read( $savePath . $file_name );
		  //   array_shift($res);//去除首行标题栏
// 		     var_dump($res);
// 		     exit();
		
		     /*对生成的数组进行数据库的写入*/
		     foreach ( $res as $k => $v )
		     {
		         if ($k != 0)
		         {
		             if($k>1){
		                 $name = trim($v [0]);
		                 $order = intval($v [1]);
		                 $result=$ItemClass->addItemClass($I_mall_classID, $name, $order);
		                 $Admin ->AddLog($mallclass.'分类管理','增加类型：其名称为：'.$name);
		                 if (! $result)
		                 {
		                     $msg = '导入数据库失败';
		                     echo showErr($msg);
		                     exit;
		                 }
		             }
		            
		         }
		     }
		 
		     if(is_file($savePath.$file_name)){
		         chmod($savePath.$file_name,0777);
		        // echo "文件存在！已经删除!--您可以重新上传文件";
		         if(!unlink($savePath.$file_name)){
		             $msg = '删除上传excel失败,文件权限问题';
		             echo showErr($msg);
		             exit;
		         }
		         
		     }

		     $r = createitemclasscache();
		     $msg = $r['flag']<1 ? ',生成失败!':'';
		     echo showSuc($tt.'添加成功'.$msg,$FLib->IsRequest('backurl'),$obj);
		     break;
		 
		 }else {
		     
		     $msg = '未选择任何文件';
		     echo showErr($msg);
		     break;
		     exit;
		     
		 }
		
// 		 exit;
         
    case 'DeleteReco': /**删除**/
		 $Admin->CheckPopedoms('SM_ITEM_CLASS_MDY');
		 $IdList = $FLib->RequestChar('IdList',0,100,'IdList',1);
		 if(!$FLib->IsIdList($IdList)) { echo showErr('参数错误'); exit; }
		 //$DataBase->QuerySql('update sm_item_class set Status=0 where ID in('.$IdList.')');
	     $ItemClass->deleteItemClass($IdList);
	     
	     //删除该类下所有品名
	     $Item = new Item();
	     //$DataBase->QuerySql("update sm_item set Status = 0 where  I_classID in ($IdList)");
	     $Item->deleteItemClass($IdList);
	     
	     //删除该类下所有钢厂
	     $ItemFactory = new ItemFactory();
	     $ItemFactory->deleteItemClass($IdList);
	     //删除该类下所有材质
	     $ItemStuff = new ItemStuff();
	     $ItemStuff->deleteItemClass($IdList);
	     //删除该类下所有规格
	     $ItemSpecification = new ItemSpecification();
	     $ItemSpecification->deleteItemClass($IdList);

	     
		 $r = createitemclasscache();
// 		 $msg = $r['flag']<1 ? ',生成失败!'.$r['err']:'';
		 $msg = $r['flag']<1 ? ',生成失败!':'';
		 $Admin ->AddLog($mallclass.'分类管理','删除类型：其ID为：'.$IdList);
		 echo showSuc($tt.'删除成功'.$msg,$FLib->IsRequest('backurl'),$obj);
		
         break;
    default:
	echo $FLib ->Alert('参数错误!','self','BACK');
	exit;
 } 

function GetValue($FLib)
{
	global $name,$order;
    $name = trim($FLib->requestchar('name',0,100,'标题',1));
	$order = $FLib->requestint('order',0,10,'序号',1);
}

function createitemclasscache(){
    
    global $DataBase;
    $itemClassArray = $DataBase->fetch_all_assoc("select * from sm_item_class where status=1 and I_mall_classID=1 order by I_order asc") ;
    $data = CacheManager::saveCache(CACHE_ITEM_CLASS, $itemClassArray) ;
    if($data==false){
        return array('flag'=>0);
    }
    return array('flag'=>1);
}

function createuserclasscache(){
	global $DataBase;
	$fname = WEBROOTDATA.'userclass.cache.inc.php';
	$rn = "\r\n";
	$str = '<?php'.$rn;
	$str .= '$da_userclass=array(';//.$rn
	$da = $DataBase->fetch_all("select * from user_class where status>0 order by I_order desc");
	foreach($da as $k=>$v){
		$str .= $rn.($k>0? ',':'');
		$str .= $v['ID'].'=>array(\'Vc_name\'=>\''.str_replace("'",'',$v['Vc_name']).'\')';
	}
	$str .= $rn.');';
	$r = writeincdata($str, $fname);
	if($r[0]<1){
		return array('flag'=>0,'err'=>$r[1]);
	}
	return array('flag'=>1);
}


$DataBase->CloseDataBase();   
?>