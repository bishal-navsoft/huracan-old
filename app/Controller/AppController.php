<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $uses = array('ModuleSetting');

	echo "bishal das";exit();

	/* ///////////////////////////////////////////////////////////////////////////////////////////// */
	/* ///////////////////////// NEEDED FOR WOUMBA TOOL MODULE STARTS HERE ///////////////////////// */

	/* Function _assignArrayKeyValue() created by Naveen Gupta.
	   This function takes input a ~(tilt) separated string like "external~internal" and convert it into an array like 
			Array 
			(
				[external] => external
				[internal] => internal
			)*/
	function _assignArrayKeyValue($str = '')
	{
		$returnArray = array();
		if($str != '')
		{
			$explodeArray = explode('~', $str);
			foreach($explodeArray AS $explodeValue):
				$returnArray[$explodeValue] = $explodeValue;
			endforeach;
		}
		return $returnArray;
	}

	function _assignKeyValue($str = '')
	{
		$returnArray = array();
		if($str != '')
		{
			$tiltExplodedArray = explode('~', $str);
			foreach($tiltExplodedArray AS $tiltExplodedValue):
				$tmpArray = explode('^', $tiltExplodedValue);
				$returnArray[$tmpArray[0]] = $tmpArray[1];
			endforeach;
		}
		return $returnArray;
	}
	
	function _getModuleSettings()
	{
		$condn = array('id' => '1');
		$modulesettings = $this->ModuleSetting->find('first', $condn);

		$font_size = $this->_assignArrayKeyValue($modulesettings['ModuleSetting']['text_size']);
		$this->set('font_size', $font_size);

		$shadow_sizes = $this->_assignArrayKeyValue($modulesettings['ModuleSetting']['shadow_size']);
		$this->set('shadow_sizes', $shadow_sizes);

		$link_option = $this->_assignArrayKeyValue($modulesettings['ModuleSetting']['link_option']);
		$this->set('link_option', $link_option);

		$link_design = $this->_assignKeyValue($modulesettings['ModuleSetting']['link_design']);
		$this->set('link_design', $link_design);
	}

	/* List of font_sizes */
	//public $font_size =  array('10'=>'10px', '12'=>'12px', '14'=>'14px', '16'=>'16px', '18'=>'18px', '20'=>'20px', '22'=>'22px', '24'=>'24px', '26'=>'26px', '28'=>'28px', '30'=>'30px', '32'=>'32px', '34'=>'34px', '36'=>'36px', '38'=>'38px', '40'=>'40px');

	/* List of shadow_sizes */
	//public $shadow_sizes =  array('1'=>'1px', '2'=>'2px', '3'=>'3px', '4'=>'4px', '5'=>'5px', '6'=>'6px', '7'=>'7px', '8'=>'8px', '9'=>'9px', '10'=>'10px');

	/* List of link options like EXTERNAL & INTERNAL */
	//public $link_option = array('external' => 'external', 'internal' => 'internal');

	/* List of link_design on buttons like button+icon, button+icon+text, button+text, text etc */
	public $link_design = array('bi' => 'Button, Icon', 'bit' => 'Button, Icon, Text', 'bt' => 'Button, Text', 't' => 'Text');
	/* /////////////////////////  NEEDED FOR WOUMBA TOOL MODULE ENDS HERE  ///////////////////////// */
	/* ///////////////////////////////////////////////////////////////////////////////////////////// */

	/* List of speeches */
	public $speeches = array('Mr'=>'Mr', 'Ms'=>'Ms');

	/* List of 'Mobile Site' status */
	public $mobile_site_status = array('on'=>'online', 'off'=>'offline');

	/* List of allow scrolling */
	public $allow_scrolling = array('on'=>'online', 'off'=>'offline');

	/* List of credit card names */
	public $creditCardNames = array('visa'=>'Visa', 'mastercard'=>'Mastercard');

	/* List of months in a calendar year */
	public $months = array( '1'=>'January', '2'=>'February', '3'=>'March', '4'=>'April', '5'=>'May', '6'=>'June', '7'=>'July', '8'=>'August', '9'=>'September', '10'=>'October', '11'=>'November', '12'=>'December');

	function beforeFilter()
	{
		//define('WEB_SITE_URL','http://'.$_SERVER['HTTP_HOST'].$this->webroot);
		//Configure::write('Config.language', $this->Session->read('Config.language'));
	}

	// This function checks USER's type. Created by Naveen Gupta.
	// If PARTNER is accessing sections related to USER then PARTNER will be redirected to PARTNER's home page. 
	function _checkUserType()
	{
		if($this->Session->read('user_type') == 'P')
		{
			$this->redirect(array('controller' => 'Partners', 'action' => 'home')); 
		}
	}

	// This function checks USER's type. Created by Naveen Gupta.
	// If USER is accessing sections related to PARTNER then USER will be redirected to USER's home page. 
	function _checkPartnerType()
	{
		if($this->Session->read('user_type') == 'U')
		{
			$this->redirect(array('controller' => 'Users', 'action' => 'home')); 
		}
	}

	// This function checks whether user has logged in or not. Created by Naveen Gupta.
	function _checkUserLogin()
	{
		$userid = $this->Session->read('user_id');
		if(!$userid) {return false;}
		return true;
	}
	
	// This function redirects a user for log-in (if not logged in already) after storing reference URL. Created by Naveen Gupta.
	function _checkUserSession()
	{
		if(!$this->Session->check('user_id'))
		{
			$this->Session->setFlash('You need to be logged in to access this area.');
			if(isset($this->params['url']['url']))
			{
				$this->Session->write('referData', $this->params['url']['url']);
			}
			$this->redirect(array('controller' => 'Users', 'action'=>'index'));
			exit();
		}
	}

	// This function checks whether administrator has logged in or not. Created by Naveen Gupta.
	function _checkAdminLogin()
	{
		$adminid = $this->Session->read('admin_id');
		if(!$adminid) {return false;}
		return true;
	}
	
	// This function redirects administrator for log-in (if not logged in already) after storing reference URL. Created by Naveen Gupta.
	function _checkAdminSession()
	{
		
		//echo '<pre>'; print_r($this->Session); 
		if(!$this->Session->check('admin_id'))
		{   
			
			$this->Session->setFlash('You need to be logged in to access this area.');
			if(isset($this->params['url']['url']))
			{
				$this->Session->write('referAdminData', $this->params['url']['url']);
			}
			$this->redirect(array('controller' => 'AdminMasters', 'action'=>'index'));
			exit();
		}
		
	
	}
	
	/************************** FOR ADMIN USER MENU PERMISSION START BY PIYANWITA DEY ON 03-07-2012 ******************/
	/*function _getAdminMenus()
	{
		$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'),'RolePermission.view' => '1'),
			'fields' => array('RolePermission.admin_menu_id'),
			'order' => array('RolePermission.id')
		);
		$rolePermissionData = $this->RolePermission->find('list', $condn);
		//pr($rolePermissionData);
		$condn1 = array(
			'conditions' => array('AdminMenu.status' => 'Y', 'AdminMenu.show_menu' => 'Y', 'AdminMenu.id' => $rolePermissionData),
			'order' => array('AdminMenu.order_id')
		);
		$admin_menus = $this->AdminMenu->find('threaded', $condn1);
		$this->set('admin_menus', $admin_menus);
		//pr($admin_menus);
	}
	
	$this->AdminMenu->bindModel(
        array('hasOne' => array(
                'RolePermission' => array(
                    'className' => 'RolePermission',
										'foreignKey' => 'admin_menu_id',
												)
								)
				    )
				);
					$condn2 = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id')),
			'order' => array('AdminMenu.id')
		);
		$admin_menus2 = $this->AdminMenu->find('threaded', $condn2);
		$this->set('admin_menus2', $admin_menus2);
		pr($admin_menus2);*/
	
	function _getRoleMenuPermission()
	{
		     
		$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'RolePermission.view' => '1'),
			'fields' => array('RolePermission.admin_menu_id'),
			'order' => array('RolePermission.id')
		);

		$rpmData = $this->RolePermission->find('all', $condn);
		
				
		
		$rolePermissionData = $this->RolePermission->find('list', $condn);
	
	    
	       for($i=0;$i<count($rpmData);$i++){
	        $admin_menus_data = $this->AdminMenu->find('all', array('conditions' => array('AdminMenu.id' =>$rpmData[$i]['RolePermission']['admin_menu_id'])));
		$admin_menus_children[$admin_menus_data[0]['AdminMenu']['parent_id']][]=$admin_menus_data[0];
		$admin_menus_parentId[] = $admin_menus_data[0]['AdminMenu']['parent_id'];
	       }
	       
	       $admin_menus_parentId=array_values(array_unique($admin_menus_parentId));

	       
	       
	       for($p=0;$p<count($admin_menus_parentId);$p++){
	        $admin_menus_parrentdata[]= $this->AdminMenu->find('all', array('conditions' => array('AdminMenu.id' =>$admin_menus_parentId[$p])));
	        }
	       
	       
	      // echo '<pre>';
	     // print_r($admin_menus_parentId);
	       //echo '<br>';
	      // print_r($admin_menus_parrentdata);
	       //echo '<br>';
	//print_r($admin_menus_children);

	       $this->set('admin_menus_children', $admin_menus_children);
	       $this->set('admin_menus_parrentdata', $admin_menus_parrentdata);
	
	
	}
	
	/*********REPORT LISN********************************/


	
	function  report_hsse_link(){
		
		$allHsseReport = $this->Report->find('all' ,array('conditions' =>array('Report.isdeleted'=>'N'),'order' => 'Report.id DESC'));
		$this->Session->write('allHsseReport', $allHsseReport);
			
		
		
	}
	function  report_sq_link(){
		
		$allSqReport = $this->SqReportMain->find('all' ,array('conditions' =>array('SqReportMain.isdeleted'=>'N'),'order' => 'SqReportMain.id DESC'));
		$this->Session->write('allSqReport', $allSqReport);
			
		
		
	}
	
	function  hsse_client_tab(){
		
		
		$clientTab = $this->Report->find('all' ,array('conditions' =>array('Report.id'=>base64_decode($this->params['pass'][0]))));
		$this->Session->write('clienttab',$clientTab[0]['Report']['client']);
			
		
	}
	
	function link_search($value){
			$reportDetail = $this->Report->find('all',array('conditions'=>array('Report.report_no'=>trim($_REQUEST['value']))));
			
		       	 if(count($reportDetail)>0){
				$rID=$reportDetail[0]['Report']['id'];
				 $type='hsse';
				
					
			 }else{
			    $rID=0;
			     $type='hsse';
			 }
			 
			if($rID==0){
			
			
				$reportSqDetail = $this->SqReportMain->find('all', array('conditions' => array('SqReportMain.report_no' =>trim($_REQUEST['value']))));            
				if(count($reportSqDetail)>0){
				   $rID=$reportSqDetail[0]['SqReportMain']['id'];
				  
				}else{
					$rID=0;	
				}
				 $type='sq';
			}
			
			if($rID==0){
		       $reportJnDetail = $this->JnReportMain->find('all', array('conditions' => array('JnReportMain.trip_number' =>$_REQUEST['value'])));            
			        if(count($reportJnDetail)>0){
			            $rID=$reportJnDetail[0]['JnReportMain']['id'];
				   
				}else{
					$rID=0;	
				}
				 $type='jn';
			}
			
			if($rID==0){
	                $reportAuditDetail = $this->AuditReportMain->find('all', array('conditions' => array('AuditReportMain.report_no' =>trim($_REQUEST['value']))));            
			        if(count($reportAuditDetail)>0){
			            $rID=$reportAuditDetail[0]['AuditReportMain']['id'];
				     
				   
				}else{
					$rID=0;	
				}
				$type='audit';
			}
			if($rID==0){
			$reportJobDetail = $this->JobReportMain->find('all', array('conditions' => array('JobReportMain.report_no' =>trim($_REQUEST['value']))));
	
				
				if(count($reportJobDetail)>0){
					 $rID=$reportJobDetail[0]['JobReportMain']['id'];
					
					}else{
					$rID=0;	
				}
				 $type='job';
			}
			if($rID==0){
			$reportJobDetail = $this->LessonMain->find('all', array('conditions' => array('LessonMain.report_no' =>trim($_REQUEST['value']))));
	
				
				if(count($reportJobDetail)>0){
					 $rID=$reportJobDetail[0]['LessonMain']['id'];
					
					}else{
					$rID=0;	
				}
				 $type='lesson';
			}
			if($rID==0){
			  $reportJobDetail = $this->DocumentMain->find('all', array('conditions' => array('DocumentMain.report_no' =>trim($_REQUEST['value']))));
	
				
					if(count($reportJobDetail)>0){
						 $rID=$reportJobDetail[0]['DocumentMain']['id'];
						 
						}else{
						$rID=0;	
					}
					$type='document';
			}
			if($rID==0){
			$reportJobDetail = $this->SuggestionMain->find('all', array('conditions' => array('SuggestionMain.report_no' =>trim($_REQUEST['value']))));
	
				
				if(count($reportJobDetail)>0){
					 $rID=$reportJobDetail[0]['SuggestionMain']['id'];
					 
					}else{
					$rID=0;	
				}
				$type='suggestion';
			}
			if($rID==0){
			$reportJobDetail = $this->JhaMain->find('all', array('conditions' => array('JhaMain.report_no' =>trim($_REQUEST['value']))));
	
				
				if(count($reportJobDetail)>0){
					 $rID=$reportJobDetail[0]['JhaMain']['id'];
					 
					}else{
					$rID=0;	
				}
				$type='jha';
			}
		         
		        	 
		 return  $rID.'~'.$type;
		
	}
	function image_upload_type(){
	         
		 $allowed_image = array ('image/gif', 'image/jpeg', 'image/jpg','application/pdf', 'image/pjpeg','image/png','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.oasis.opendocument.text','application/vnd.oasis.opendocument.spreadsheet','application/vnd.oasis.opendocument.presentation');
		 return $allowed_image;
	}
	
	function  file_edit_list($filename,$modelName,$attchmentdetail){
		   $file_type_array = array ('pdf', 'xlsx', 'xls','doc','docx','odt','ods','odp');
		   $filetype1=explode('.',$filename);
		   $filetype = end($filetype1);

		   if(in_array($filetype,$file_type_array)){
			  $imagepath='<span id='.$attchmentdetail[0][$modelName]['file_name'].'><a href='.$this->webroot.'img/file_upload/'.$attchmentdetail[0][$modelName]['file_name'].' height="80" width="80" >'.$attchmentdetail[0][$modelName]['file_name'].'</a></span></br>';	
		   
		   }else{
			 $imagepath='<span id='.$attchmentdetail[0][$modelName]['file_name'].' class="picupload"><img src='.$this->webroot.'img/file_upload/'.$attchmentdetail[0][$modelName]['file_name'].' height="80" width="80" /></span>';	
		   }
		  
		  return  $imagepath;
		   
		
		   
	
	}
	
	function attachment_list($modleName,$rec){
		 //return (array)$rec; die();
		 $filetext1=explode(".",$rec[$modleName]['file_name']);
		 $filetext = end($filetext1);
		 switch($filetext){
			case'pdf':
			     $fileSRC='<a href='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].' ><img src='.$this->webroot.'img/file_upload/pdf.jpeg  height="80" width="80"></a>';
			break;
		        case'xlsx':
			      $fileSRC='<a href='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].'><img src='.$this->webroot.'img/file_upload/excel.jpeg  height="80" width="80"></a>';		
			break;
		        case'xls':
			      $fileSRC='<a href='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].' ><img src='.$this->webroot.'img/file_upload/excel.jpeg  height="80" width="80"></a>';	
			break;
		        case'xlsm':
				$fileSRC='<a href='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].' ><img src='.$this->webroot.'img/file_upload/excel.jpeg  height="80" width="80"></a>';	
			break;
		        case'doc':
			       $fileSRC='<a href='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].'><img src='.$this->webroot.'img/file_upload/doc.jpeg  height="80" width="80"></a>';		
			break;
			case'docx':
			       $fileSRC='<a href='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].'><img src='.$this->webroot.'img/file_upload/doc.jpeg  height="80" width="80"></a>';		
			break;
			case'odt':
			       $fileSRC='<a href='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].'><img src='.$this->webroot.'img/file_upload/doc.jpeg  height="80" width="80"></a>';		
			break;
			case'ods':
			       $fileSRC='<a href='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].'><img src='.$this->webroot.'img/file_upload/doc.jpeg  height="80" width="80"></a>';		
			break;
			case'odp':
			       $fileSRC='<a href='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].'><img src='.$this->webroot.'img/file_upload/doc.jpeg  height="80" width="80"></a>';		
			break;
		        default:
			       $fileSRC='<a href='.$this->webroot.'resize.php?src=img/file_upload/'.$rec[$modleName]['file_name'].'&w=300&h=300 target="_blank"><img src='.$this->webroot.'img/file_upload/'.$rec[$modleName]['file_name'].' height="80" width="80"></a>';
			break;       
			
		 }
		 return  $fileSRC;
		
	}
	
	
	function link_grid($adminA,$link_type,$modelName,$rec){
		
		  
		  switch($link_type){
			case'hsse':
			    $type = 'Hsse Report';
			    $reportdetail = $this->Report->find('all', array('conditions' => array('Report.id' =>$rec[$modelName]['link_report_id'])));
			    if(count($reportdetail)>0){  		    
			      $link_report_no ='<a href='.$this->webroot.'Reports/add_report_view/'.base64_encode($reportdetail[0]['Report']['id']).' target="_blank" >'.$reportdetail[0]['Report']['report_no'].'</a>';
			    }
			break;
		        case'sq':
			     $type = 'Sq Report';
			     $reportdetail = $this->SqReportMain->find('all', array('conditions' => array('SqReportMain.id' =>$rec[$modelName]['link_report_id'])));
			     if(count($reportdetail)>0){  	
			        $link_report_no='<a href='.$this->webroot.'Sqreports/add_sqreport_view/'.base64_encode($reportdetail[0]['SqReportMain']['id']).' target="_blank" >'.$reportdetail[0]['SqReportMain']['report_no'].'</a>';
			     }
				
			break;
		        case'jn':
			     $type= 'Journey Report';
			     $reportdetail = $this->JnReportMain->find('all', array('conditions' => array('JnReportMain.id' =>$rec[$modelName]['link_report_id'])));
			     if(count($reportdetail)>0){ 
				$link_report_no ='<a href='.$this->webroot.'Jrns/add_jrnreport_view/'.base64_encode($reportdetail[0]['JnReportMain']['id']).' target="_blank" >'.$reportdetail[0]['JnReportMain']['trip_number'].'</a>';
			     }
				
			break;
		        case'audit':
			      $type = 'Audit Report';
			      $reportdetail = $this->AuditReportMain->find('all', array('conditions' => array('AuditReportMain.id' =>$rec[$modelName]['link_report_id'])));
			      if(count($reportdetail)>0){ 
			        $link_report_no ='<a href='.$this->webroot.'Audits/add_audit_view/'.base64_encode($reportdetail[0]['AuditReportMain']['id']).' target="_blank" >'.$reportdetail[0]['AuditReportMain']['report_no'].'</a>';
			     }
				
			break;	 
			case'job':
			       $type = 'Job Report';
			       $reportdetail = $this->JobReportMain->find('all', array('conditions' => array('JobReportMain.id' =>$rec[$modelName]['link_report_id'])));
			       if(count($reportdetail)>0){ 
			          $link_report_no ='<a href='.$this->webroot.'Jobs/add_jobreport_view/'.base64_encode($reportdetail[0]['JobReportMain']['id']).' target="_blank" >'.$reportdetail[0]['JobReportMain']['report_no'].'</a>';
			       }
				
			break;
		        case'lesson':
			       $type = 'Best Practice / Lesson Learnt';
			       $reportdetail = $this->LessonMain->find('all', array('conditions' => array('LessonMain.id' =>$rec[$modelName]['link_report_id'])));
			       if(count($reportdetail)>0){ 
			         $link_report_no ='<a href='.$this->webroot.'Lessons/add_lsreport_view/'.base64_encode($reportdetail[0]['LessonMain']['id']).' target="_blank" >'.$reportdetail[0]['LessonMain']['report_no'].'</a>';
			         }
				
			break;
		         case'document':
			      $type = 'Document Report';
			      $reportdetail = $this->DocumentMain->find('all', array('conditions' => array('DocumentMain.id' =>$rec[$modelName]['link_report_id'])));
			      if(count($reportdetail)>0){ 
			       $link_report_no ='<a href='.$this->webroot.'Documents/add_dcreport_view/'.base64_encode($reportdetail[0]['DocumentMain']['id']).' target="_blank" >'.$reportdetail[0]['DocumentMain']['report_no'].'</a>';
			     }
			break;
		        case'suggestion':
			     $type = 'Suggestion Report';
			     $reportdetail = $this->SuggestionMain->find('all', array('conditions' => array('SuggestionMain.id' =>$rec[$modelName]['link_report_id'])));
			     if(count($reportdetail)>0){ 
			       $link_report_no ='<a href='.$this->webroot.'Suggestions/add_suggestionreport_view/'.base64_encode($reportdetail[0]['SuggestionMain']['id']).' target="_blank" >'.$reportdetail[0]['SuggestionMain']['report_no'].'</a>';
			     }
		        break;
		        case'jha':
			     $type = 'Job Hazard Analysis Report';
			     $reportdetail = $this->JhaMain->find('all', array('conditions' => array('JhaMain.id' =>$rec[$modelName]['link_report_id'])));
			     if(count($reportdetail)>0){ 
			       $link_report_no ='<a href='.$this->webroot.'Jhas/add_jha_view/'.base64_encode($reportdetail[0]['JhaMain']['id']).' target="_blank" >'.$reportdetail[0]['JhaMain']['report_no'].'</a>';
			     }
		        break; 
		  }
		  return $link_report_no.'~'.$type;
		
		
	}
	
	
	function upload_image_func($upparname,$contr,$allowed_image){
		if($upparname=='upload'){
			$filepath='img/file_upload/';
			$fileAttachData=$this->data;
			$replacech = array(" ",);
                        $replaceby   = array("_",);
                        $newFN = str_replace($replacech,$replaceby,$fileAttachData[$contr]['file_upload']['name']);
			$fileName=time().'_'.$newFN ;
			$imagetype=$fileAttachData[$contr]['file_upload']['type'];
			
			if(in_array($imagetype,$allowed_image)){
				   
				    
				    if(!empty($fileAttachData)){
				     
				       if(move_uploaded_file($fileAttachData[$contr]['file_upload']['tmp_name'],$filepath.$fileName)){
					       $iamgepath=$this->webroot.$filepath.$fileName; ?>
					       
						<script language='javascript' type="text/javascript">
						       parent.document.getElementById('image_upload_res').innerHTML='<font style="color:green;" >Uploaded successfully</font>';
						       parent.document.getElementById('displayFile').style.display='block';
						       parent.document.getElementById('del').style.display='block';
						       <?php
						       if($imagetype=='application/pdf'){?>
						       parent.document.getElementById('displayFile').innerHTML='<span  id="<?php echo $fileName;?>"   ><a href="<?php echo $iamgepath; ?>"><?php echo $fileName;?></a></span>';	
						       <?php }elseif($imagetype=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){?>
						       parent.document.getElementById('displayFile').innerHTML='<span  id="<?php echo $fileName;?>" ><a href="<?php echo $iamgepath; ?>"><?php echo $fileName;?></a></span>';	
						       <?php }elseif($imagetype=='application/vnd.ms-excel'){?>
						       parent.document.getElementById('displayFile').innerHTML='<span  id="<?php echo $fileName;?>" ><a href="<?php echo $iamgepath; ?>"><?php echo $fileName;?></a></span>';	
						       <?php }elseif($imagetype=='application/msword'){?>
						       parent.document.getElementById('displayFile').innerHTML='<span  id="<?php echo $fileName;?>" ><a href="<?php echo $iamgepath; ?>"><?php echo $fileName;?></a></span>';	
						       <?php }elseif($imagetype=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'){ ?>
						       parent.document.getElementById('displayFile').innerHTML='<span  id="<?php echo $fileName;?>" ><a href="<?php echo $iamgepath; ?>"><?php echo $fileName;?></a></span>';
						       <?php }elseif($imagetype=='application/vnd.oasis.opendocument.text'){ ?>
						       parent.document.getElementById('displayFile').innerHTML='<span  id="<?php echo $fileName;?>" ><a href="<?php echo $iamgepath; ?>"><?php echo $fileName;?></a></span>';
						       <?php }elseif($imagetype=='application/vnd.oasis.opendocument.spreadsheet'){ ?>
						       parent.document.getElementById('displayFile').innerHTML='<span  id="<?php echo $fileName;?>" ><a href="<?php echo $iamgepath; ?>"><?php echo $fileName;?></a></span>';
						       <?php }elseif($imagetype=='application/vnd.oasis.opendocument.presentation'){ ?>
						       parent.document.getElementById('displayFile').innerHTML='<span  id="<?php echo $fileName;?>" ><a href="<?php echo $iamgepath; ?>"><?php echo $fileName;?></a></span>';
						       <?php }else{
						       ?>
						       parent.document.getElementById('displayFile').innerHTML='<span  id="<?php echo $fileName;?>" class="picupload"><img  alt="" src="<?php echo $iamgepath; ?>" height="80" width="80" /></span>';
						       <?php } ?>
						       parent.document.getElementById('hiddenFile').value='<?php echo $fileName ?>';
					       </script>
				      <?php  }
				     }
				     
				     
			     }else
			     {?>
						<script language='javascript' type="text/javascript"> 
							 parent.document.getElementById('displayFile').innerHTML='';
							 parent.document.getElementById('image_upload_res').innerHTML='<font style="color:red">Only jpeg, png, jpg,gif,xlsx,xls,Doc,Docx,Odt,Ods files are allowed to upload</font>';
							 parent.document.getElementById('del').style.display='none';
						 </script> 
		      
			<?php  }				 
			}elseif($upparname=='delete'){
				
					unlink('../../app/webroot/img/file_upload/'.urldecode($deleteImageName)); ?>
					<script language='javascript' type="text/javascript"> 
					       parent.document.getElementById('hiddenFile').value='';
					       parent.document.getElementById('image_upload_res').innerHTML='<font style="color:green">File deleted successfully</font>';
				       </script>
                     <?php   
                          }
		
	}
	function derive_link_data($userDeatil){
		  $reportDeatil=array();
		  if(count($userDeatil[0]['Report'])>0){
			for($i=0;$i<count($userDeatil[0]['Report']);$i++){
				  $reportDeatil['Report'][$i]['report_name'][]=$userDeatil[0]['Report'][$i]['report_no'];
				  $reportDeatil['Report'][$i]['type'][]='Hsse Report';
				  $reportDeatil['Report'][$i]['id'][]=$userDeatil[0]['Report'][$i]['id'];
				  $reportDeatil['Report'][$i]['summary'][]=$userDeatil[0]['Report'][$i]['summary'];
			      
			}
		  }
		  if(count($userDeatil[0]['SqReportMain'])>0){
			for($i=0;$i<count($userDeatil[0]['SqReportMain']);$i++){
			       $reportDeatil['SqReportMain'][$i]['report_name'][]=$userDeatil[0]['SqReportMain'][$i]['report_no'];
			       $reportDeatil['SqReportMain'][$i]['type'][]='Sq Report';
			       $reportDeatil['SqReportMain'][$i]['id'][]=$userDeatil[0]['SqReportMain'][$i]['id'];
			       $reportDeatil['SqReportMain'][$i]['summary'][]=$userDeatil[0]['SqReportMain'][$i]['summary'];
			      
			}
		  }

                 if(count($userDeatil[0]['JnReportMain'])>0){
			for($i=0;$i<count($userDeatil[0]['JnReportMain']);$i++){
			       $reportDeatil['JnReportMain'][$i]['report_name'][]=$userDeatil[0]['JnReportMain'][$i]['trip_number'];
			       $reportDeatil['JnReportMain'][$i]['type'][]='Journey Report';
			       $reportDeatil['JnReportMain'][$i]['id'][]=$userDeatil[0]['JnReportMain'][$i]['id'];
			       $reportDeatil['JnReportMain'][$i]['summary'][]=$userDeatil[0]['JnReportMain'][$i]['summary'];
			      
			}
		  }
		  if(count($userDeatil[0]['AuditReportMain'])>0){
			for($i=0;$i<count($userDeatil[0]['AuditReportMain']);$i++){
			       $reportDeatil['AuditReportMain'][$i]['report_name'][]=$userDeatil[0]['AuditReportMain'][$i]['report_no'];
			       $reportDeatil['AuditReportMain'][$i]['type'][]='Audit Report';
			       $reportDeatil['AuditReportMain'][$i]['id'][]=$userDeatil[0]['AuditReportMain'][$i]['id'];
			       $reportDeatil['AuditReportMain'][$i]['summary'][]=$userDeatil[0]['AuditReportMain'][$i]['summary'];
			      
			}
		  }
	          if(count($userDeatil[0]['JobReportMain'])>0){
			for($i=0;$i<count($userDeatil[0]['JobReportMain']);$i++){
			       $reportDeatil['JobReportMain'][$i]['report_name'][]=$userDeatil[0]['JobReportMain'][$i]['report_no'];
			       $reportDeatil['JobReportMain'][$i]['type'][]='Job Report';
			       $reportDeatil['JobReportMain'][$i]['id'][]=$userDeatil[0]['JobReportMain'][$i]['id'];
			       $reportDeatil['JobReportMain'][$i]['summary'][]=$userDeatil[0]['JobReportMain'][$i]['comment'];
			      
			}
		  }
	
		if(count($userDeatil[0]['LessonMain'])>0){
			for($i=0;$i<count($userDeatil[0]['LessonMain']);$i++){
			       $reportDeatil['LessonMain'][$i]['report_name'][]=$userDeatil[0]['LessonMain'][$i]['report_no'];
			       $reportDeatil['LessonMain'][$i]['type'][]='Best Practice Lesson Report';
			       $reportDeatil['LessonMain'][$i]['id'][]=$userDeatil[0]['LessonMain'][$i]['id'];
			       $reportDeatil['LessonMain'][$i]['summary'][]=$userDeatil[0]['LessonMain'][$i]['summary'];
			      
			}
		  }
		  if(count($userDeatil[0]['DocumentMain'])>0){
			for($i=0;$i<count($userDeatil[0]['DocumentMain']);$i++){
			       $reportDeatil['DocumentMain'][$i]['report_name'][]=$userDeatil[0]['DocumentMain'][$i]['report_no'];
			       $reportDeatil['DocumentMain'][$i]['type'][]='Best Practice Lesson Report';
			       $reportDeatil['DocumentMain'][$i]['id'][]=$userDeatil[0]['DocumentMain'][$i]['id'];
			       $reportDeatil['DocumentMain'][$i]['summary'][]=$userDeatil[0]['DocumentMain'][$i]['summary'];
			      
			}
		  }
		  if(count($userDeatil[0]['SuggestionMain'])>0){
			for($i=0;$i<count($userDeatil[0]['SuggestionMain']);$i++){
			       $reportDeatil['SuggestionMain'][$i]['report_name'][]=$userDeatil[0]['SuggestionMain'][$i]['report_no'];
			       $reportDeatil['SuggestionMain'][$i]['type'][]='Suggestion Report';
			       $reportDeatil['SuggestionMain'][$i]['id'][]=$userDeatil[0]['SuggestionMain'][$i]['id'];
			       $reportDeatil['SuggestionMain'][$i]['summary'][]=$userDeatil[0]['SuggestionMain'][$i]['summary'];
			      
			}
		  }
		  if(count($userDeatil[0]['JhaMain'])>0){
			for($i=0;$i<count($userDeatil[0]['JhaMain']);$i++){
			       $reportDeatil['JhaMain'][$i]['report_name'][]=$userDeatil[0]['JhaMain'][$i]['report_no'];
			       $reportDeatil['JhaMain'][$i]['type'][]='Job Hazard Analysis Report';
			       $reportDeatil['JhaMain'][$i]['id'][]=$userDeatil[0]['JhaMain'][$i]['id'];
			       $reportDeatil['JhaMain'][$i]['summary'][]=$userDeatil[0]['JhaMain'][$i]['summary'];
			      
			}
		  }
		  
		  return $reportDeatil;
		
	}
	function remedial_email($to,$fullname,$remedialno,$rportno,$remidial_summery,$remidial_closure_date,$reporttype){
		 $subject='';
		// $to='debi15prasad@gmail.com';
		 $from = 'jhollingworth@huracan.com.au';
		 $subject='Your remedial action detail';
	         $message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Huracan</title></head><body style="padding:0; margin:0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="20" width="1" /></td>
  </tr><tr><td align="center" valign="top"><table width="625" border="0" cellspacing="0" cellpadding="0">
      <tr><td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/newstop.jpg" width="625" height="12" /></td>
      </tr><tr><td align="center" valign="top" bgcolor="#7b07de"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10" align="left" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/topleft.gif"/></td>
            <td width="579" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="7" width="1" /></td>
            <td width="11" align="right" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/topright.gif"/></td>
            </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="20" width="1" /></td>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="579" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="579" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="146" align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/huracan_logo.png" alt="Huracan" title="Huracan" /></td>
                    <td width="433" align="right" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Visit us on<br />
                      <a href="#" style="color:#7B07DE; text-decoration:none;">http://huracan.com.au</a></td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td style="font-family: Tahoma, Geneva, sans-serif; font-size:10px; color:#ccc;">................................................................................................................................................................................................</td>
                </tr>
              <tr>
                <td style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="10" width="1" /></td>
                </tr>
              <tr>
                <td align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;"><p>Hello <strong>'.ucwords(strtolower($fullname)).',</strong></p>
                  <p><strong>ReportNo:-&nbsp;'.$rportno.'</p>
                  <p>Report Type: '.$reporttype.'</p>
                  <p>Your Remedial Action No:'.$remedialno.'</p>
                  <p>Summary:- &nbsp;'.$remidial_summery.'</p>
                  <p>Closure Date:'.$remidial_closure_date.'</p>
                 </td>
                </tr>
              <tr>
                <td style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="10" width="1" /></td>
                </tr>
              <tr>
                <td bgcolor="#f0f0f0"><table width="579" border="0" cellspacing="8" cellpadding="0">
                  <tr>
                    <td width="358" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:18px; color:#7B07DE;">Thanks</td>
                    <td width="197" align="left" valign="top"><table width="197" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Hurracan PTY Ltd</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">PO-1070</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">ROMA</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Queensland 4455</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Email: <a href="#" style="color:#7B07DE; text-decoration:none;">info@huracan.com.au</a></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            <td align="right" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="20" width="1" /></td>
            </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/bottomleft.gif"/></td>
            <td bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="7" width="1" /></td>
            <td align="right" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/bottomright.gif"/></td>
            </tr>
          </table></td>
      </tr><tr><td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/newsbottom.jpg" width="625" height="12" /></td>
      </tr></table></td></tr><tr><td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" alt="" width="1" height="20" /></td>
  </tr></table></body></html>';

$this->PhpMailerEmail->send_mail($to,$subject,$message,$from,'','','');
$responsemsg='ok';
               return  $responsemsg; 
		
	}

   //function cert_email($fullname,$certificate_expire_date,$certificate_cert_date,$validate,$fullname,$type,$id,$from,$to,$subject){
  function cert_email($fullname,$certificate_expire_date,$certificate_cert_date,$validate,$type,$id,$from,$to,$subject){

 $message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Huracan</title></head><body style="padding:0; margin:0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="20" width="1" /></td>
  </tr><tr><td align="center" valign="top"><table width="625" border="0" cellspacing="0" cellpadding="0">
      <tr><td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/newstop.jpg" width="625" height="12" /></td>
      </tr>
      <tr>
        <td align="center" valign="top" bgcolor="#7b07de"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10" align="left" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/topleft.gif"/></td>
            <td width="579" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="7" width="1" /></td>
            <td width="11" align="right" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/topright.gif"/></td>
            </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="20" width="1" /></td>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="579" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="579" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="146" align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/huracan_logo.png" alt="Huracan" title="Huracan" /></td>
                    <td width="433" align="right" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Visit us on<br />
                      <a href="#" style="color:#7B07DE; text-decoration:none;">http://huracan.com</a></td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td style="font-family: Tahoma, Geneva, sans-serif; font-size:10px; color:#ccc;">................................................................................................................................................................................................</td>
                </tr>
              <tr>
                <td style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="10" width="1" /></td>
                </tr>
              <tr>
                <td align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;"><p>Hello <strong>'.ucwords(strtolower($fullname)).',</strong></p>
        	  <p><strong>Cert Name:- &nbsp;'.$type.'</p>
                  <p>Cert Date:- &nbsp;'.$certificate_cert_date.'</p>
                  <p>Validity (Days):- &nbsp; '.$validate.'</p>
		  <p>Expiry Date:- &nbsp; '.$certificate_expire_date.'</p>
                 </td>
                </tr>
              <tr>
                <td style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="10" width="1" /></td>
                </tr>
              <tr>
                <td bgcolor="#f0f0f0"><table width="579" border="0" cellspacing="8" cellpadding="0">
                  <tr>
                    <td width="358" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:18px; color:#7B07DE;">Thanks</td>
                    <td width="197" align="left" valign="top"><table width="197" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Hurracan PTY Ltd</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">PO-1070</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">ROMA</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Queensland 4455</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Email: <a href="#" style="color:#7B07DE; text-decoration:none;">info@huracan.com.au</a></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            <td align="right" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="20" width="1" /></td>
            </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/bottomleft.gif"/></td>
            <td bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="7" width="1" /></td>
            <td align="right" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/bottomright.gif"/></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/newsbottom.jpg" width="625" height="12" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" alt="" width="1" height="20" /></td>
  </tr>
</table>
</body>
</html>';
  
   $this->PhpMailerEmail->send_mail($to,$subject,$message,$from,'','','');
   $this->request->data['CertificationEmail']['id'] = $id;
   $this->request->data['CertificationEmail']['status'] = 'Y';
   $this->CertificationEmail->save($this->request->data,false);
   return $message;
	
  }




	
  
  function ldjs_email($fullname,$reportno,$validation,$revalidation,$summary,$detail,$tablename,$id,$subject,$from,$to,$rtype){

 $message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Huracan</title></head><body style="padding:0; margin:0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="20" width="1" /></td>
  </tr><tr><td align="center" valign="top"><table width="625" border="0" cellspacing="0" cellpadding="0">
      <tr><td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/newstop.jpg" width="625" height="12" /></td>
      </tr>
      <tr>
        <td align="center" valign="top" bgcolor="#7b07de"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10" align="left" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/topleft.gif"/></td>
            <td width="579" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="7" width="1" /></td>
            <td width="11" align="right" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/topright.gif"/></td>
            </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="20" width="1" /></td>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="579" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="579" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="146" align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/huracan_logo.png" alt="Huracan" title="Huracan" /></td>
                    <td width="433" align="right" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Visit us on<br />
                      <a href="#" style="color:#7B07DE; text-decoration:none;">http://huracan.com</a></td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td style="font-family: Tahoma, Geneva, sans-serif; font-size:10px; color:#ccc;">................................................................................................................................................................................................</td>
                </tr>
              <tr>
                <td style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="10" width="1" /></td>
                </tr>
              <tr>
                <td align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;"><p>Hello <strong>'.ucwords(strtolower($fullname)).',</strong></p>
                  <p><strong>Report No:- &nbsp;'.$reportno.'</p>
		  <p><strong>Report Type:- &nbsp;'.$rtype.'</p>
		  <p>Validation:-  date&nbsp;'.$validation.'</p>
                  <p>Revalidation:-  date&nbsp;'.$revalidation.'</p>
                  <p>Summary:- &nbsp;'.$summary.'</p>
                  <p>Detail:- &nbsp; '.$detail.'</p>
                 </td>
                </tr>
              <tr>
                <td style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="10" width="1" /></td>
                </tr>
              <tr>
                <td bgcolor="#f0f0f0"><table width="579" border="0" cellspacing="8" cellpadding="0">
                  <tr>
                    <td width="358" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:18px; color:#7B07DE;">Thanks</td>
                    <td width="197" align="left" valign="top"><table width="197" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Hurracan PTY Ltd</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">PO-1070</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">ROMA</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Queensland 4455</td>
                        </tr>
                      <tr>
                        <td height="22" align="left" valign="top" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; color:#333;">Email: <a href="#" style="color:#7B07DE; text-decoration:none;">info@huracan.com.au</a></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            <td align="right" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="20" width="1" /></td>
            </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/bottomleft.gif"/></td>
            <td bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" height="7" width="1" /></td>
            <td align="right" valign="top" bgcolor="#FFFFFF" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/bottomright.gif"/></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/newsbottom.jpg" width="625" height="12" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="font-size:0;"><img src="Huracan.com.au/'.$this->webroot.'app/webroot/images/spacer.png" alt="" width="1" height="20" /></td>
  </tr>
</table>
</body>
</html>';
  
   $this->PhpMailerEmail->send_mail($to,$subject,$message,$from,'','','');
   $this->request->data[$tablename]['id'] = $id;
   $this->request->data[$tablename]['status'] = 'Y';
   $this->LdjsEmail->save($this->request->data,false);
   return $message;
	
  }
	
	
	/************************** FOR ADMIN USER GRID PERMISSION START BY DEBI PRASAD SAHOO ON 04-04-2013******************/
	/************************** FOR ADMIN USER GRID PERMISSION START BY DEBI PRASAD SAHOO ON 04-04-2013 ******************/
	function grid_access()
	{
	        switch($this->params['controller']){
			case'Reports':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));	
			break;
		        case'Sqreports':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));	
			break;
		        case'Jrns':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));	
			break;
		        case'Audits':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));	
			break;
		        case'Jobs':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));	
			break;
		        case'Lessons':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));	
			break;
		        case'RoleMasters':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'RoleMasters/list_roles','parent_id !='=>0));	
			break;
		        case'Certifications':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));	
			break;
		        case'Documents':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));
			break;
		        case'Suggestions':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));
			break;
		        case'Jhas':
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' =>'Reports/report_hsse_list','parent_id !='=>0));
			break;
		        default:
			$condn = array(
			'conditions' => array('RolePermission.role_master_id' => $this->Session->read('adminData.AdminMaster.role_master_id'), 'AdminMenu.url like' => $this->params['controller'].'/'.$this->params['action'],'parent_id !='=>0));
			break;
				
			
		}
		
		$this->RolePermission->bindModel(array('belongsTo' => array('AdminMenu')));
		$roleMenuData = $this->RolePermission->find('first', $condn);
		
	       
	       
	
		if($roleMenuData['RolePermission']['add'] == '1')
		{
			$this->set('is_add', 1);
		}
		else
		{
			$this->set('is_add', 0);
		}
		if($roleMenuData['RolePermission']['view'] == '1')
		{
			$this->set('is_view', 1);
		}
		else
		{
			$this->set('is_view', 0);
		}
		if($roleMenuData['RolePermission']['edit'] == '1')
		{
			$this->set('is_edit', 1);
		}
		else
		{
			$this->set('is_edit', 0);
		}
		if($roleMenuData['RolePermission']['block'] == '1')
		{
			$this->set('is_block', 1);
		}
		else
		{
			$this->set('is_block', 0);
		}
		if($roleMenuData['RolePermission']['delete'] == '1')
		{
			$this->set('is_delete', 1);
		}
		else
		{
			$this->set('is_delete', 0);
		}
	}
	
	function retrive_link_summary($madleVal,$uniqueType,$aTP){
		$linkDataHolder=array();
		for($u=0;$u<count($uniqueType);$u++){
		    if($uniqueType[$u]=='lesson'){
			
			 $condition= $aTP.".type ='lesson'";
		         $reportType=$madleVal->find('all', array('conditions' => $condition ));
			  
			   for($t=0;$t<count($reportType);$t++){
			       $reportdetail = $this->LessonMain->find('all', array('conditions' => array('LessonMain.id' =>$reportType[$t][$aTP]['link_report_id'])));
				if(count($reportdetail)>0){
				
				   $linkHolder[$u]['report_number'][$t][]='<a href='.$this->webroot.'Lessons/add_lsreport_view/'.base64_encode($reportdetail[0]['LessonMain']['id']).' target="_blank" >'.$reportdetail[0]['LessonMain']['report_no'].'</a>';
				   $linkHolder[$u]['summary'][$t][]=$reportdetail[0]['LessonMain']['summary'];
				}
			    
			   }
			 
			   
			}	
		      if($uniqueType[$u]=='job'){
			
			  $condition= $aTP.".type ='job'";
			  $reportType=$madleVal->find('all', array('conditions' => $condition));
			  
			   for($t=0;$t<count($reportType);$t++){
			    $reportdetail = $this->JobReportMain->find('all', array('conditions' => array('JobReportMain.id' =>$reportType[$t][$aTP]['link_report_id'])));
				if(count($reportdetail)>0){
				
				   $linkHolder[$u]['report_number'][$t][]='<a href='.$this->webroot.'Jobs/add_jobreport_view/'.base64_encode($reportdetail[0]['JobReportMain']['id']).' target="_blank" >'.$reportdetail[0]['JobReportMain']['report_no'].'</a>';
				   $linkHolder[$u]['summary'][$t][]=$reportdetail[0]['JobReportMain']['comment'];
				}
			    
			   }
			 
			   
			}
			 if($uniqueType[$u]=='audit'){
			
		          $condition= $aTP.".type ='audit'";
			  $reportType=$madleVal->find('all', array('conditions' => $condition));
			  
			   for($t=0;$t<count($reportType);$t++){
			  
				$reportdetail = $this->AuditReportMain->find('all', array('conditions' => array('AuditReportMain.id' =>$reportType[$t][$aTP]['link_report_id'])));
					if(count($reportdetail)>0){
						$linkHolder[$u]['report_number'][$t][]='<a href='.$this->webroot.'Audits/add_audit_view/'.base64_encode($reportdetail[0]['AuditReportMain']['id']).' target="_blank" >'.$reportdetail[0]['AuditReportMain']['report_no'].'</a>';
						$linkHolder[$u]['summary'][$t][]=$reportdetail[0]['AuditReportMain']['summary'];
					}
			   }
			 
			   
			} 
	
			 if($uniqueType[$u]=='sq'){
			
				$condition= $aTP.".type ='sq'";
			         $reportType=$madleVal->find('all', array('conditions' => $condition));
			       
				for($t=0;$t<count($reportType);$t++){
			       
					$reportdetail = $this->SqReportMain->find('all', array('conditions' => array('SqReportMain.id' =>$reportType[$t][$aTP]['link_report_id'])));
					if(count($reportdetail)>0){
						$linkHolder[$u]['report_number'][$t][]='<a href='.$this->webroot.'SqReports/add_report_view/'.base64_encode($reportdetail[0]['SqReportMain']['id']).' target="_blank" >'.$reportdetail[0]['SqReportMain']['report_no'].'</a>';
						$linkHolder[$u]['summary'][$t][]=$reportdetail[0]['SqReportMain']['summary'];
					}
				}
			 
			   
			}
			if($uniqueType[$u]=='jn'){
			
			   $condition= $aTP.".type ='jn'";
			   $reportType=$madleVal->find('all', array('conditions' => $condition));
			   for($t=0;$t<count($reportType);$t++){
			  
				$reportdetail = $this->JnReportMain->find('all', array('conditions' => array('JnReportMain.id' =>$reportType[$t][$aTP]['link_report_id'])));
				if(count($reportdetail)>0){
			       
				   $linkHolder[$u]['report_number'][$t][]='<a href='.$this->webroot.'Jrns/add_report_view/'.base64_encode($reportdetail[0]['JnReportMain']['id']).' target="_blank" >'.$reportdetail[0]['JnReportMain']['trip_number'].'</a>';
				   $linkHolder[$u]['summary'][$t][]=$reportdetail[0]['JnReportMain']['summary'];
			       
				}
		 
			   
			   }
			 
			   
			}
		     if($uniqueType[$u]=='hsse'){
			
			   $condition= $aTP.".type ='hsse'";
			   $reportType=$madleVal->find('all', array('conditions' => $condition));
	  
				for($t=0;$t<count($reportType);$t++){
			       
				 $reportdetail = $this->Report->find('all', array('conditions' => array('Report.id' =>$reportType[$t][$aTP]['link_report_id'])));
					if(count($reportdetail)){
					     $linkHolder[$u]['report_number'][$t][]='<a href='.$this->webroot.'Reports/add_report_view/'.base64_encode($reportdetail[0]['Report']['id']).' target="_blank" >'.$reportdetail[0]['Report']['report_no'].'</a>';
					     $linkHolder[$u]['summary'][$t][]=$reportdetail[0]['Report']['summary'];
					  }
				
				}
			 
			   
			}
		    if($uniqueType[$u]=='suggestion'){
			
			   $condition= $aTP.".type ='suggestion'";
			   $reportType=$madleVal->find('all', array('conditions' => $condition));
	  
				for($t=0;$t<count($reportType);$t++){
			       
				 $reportdetail = $this->SuggestionMain->find('all', array('conditions' => array('SuggestionMain.id' =>$reportType[$t][$aTP]['link_report_id'])));
					if(count($reportdetail)){
					     $linkHolder[$u]['report_number'][$t][]='<a href='.$this->webroot.'Suggestions/add_suggestion_view/'.base64_encode($reportdetail[0]['SuggestionMain']['id']).' target="_blank" >'.$reportdetail[0]['SuggestionMain']['report_no'].'</a>';
					     $linkHolder[$u]['summary'][$t][]=$reportdetail[0]['SuggestionMain']['summary'];
					  }
				
				}
			 
			   
			}
		    if($uniqueType[$u]=='jha'){
			
			   $condition= $aTP.".type ='jha'";
			   $reportType=$madleVal->find('all', array('conditions' => $condition));
	  
				for($t=0;$t<count($reportType);$t++){
			       
				 $reportdetail = $this->JhaMain->find('all', array('conditions' => array('JhaMain.id' =>$reportType[$t][$aTP]['link_report_id'])));
					if(count($reportdetail)){
					     $linkHolder[$u]['report_number'][$t][]='<a href='.$this->webroot.'Jhas/add_jha_view/'.base64_encode($reportdetail[0]['JhaMain']['id']).' target="_blank" >'.$reportdetail[0]['JhaMain']['report_no'].'</a>';
					     $linkHolder[$u]['summary'][$t][]=$reportdetail[0]['JhaMain']['summary'];
					  }
				
				}
			 
			   
			}		
			
		      }
		      
	
		     for($h=0;$h<count($linkHolder);$h++){
			if(isset($linkHolder[$h])){
			
			  for($k=0;$k<count($linkHolder[$h]['report_number']);$k++){
				
				if(isset($linkHolder[$h]['report_number'][$k][0])){
				    $linkDataHolder['rep_no'][]=$linkHolder[$h]['report_number'][$k][0];	
				}
				
				
			  
			  }
			  for($k=0;$k<count($linkHolder[$h]['summary']);$k++){
				if(isset($linkHolder[$h]['summary'][$k][0])){
				   $linkDataHolder['rep_summary'][]=$linkHolder[$h]['summary'][$k][0];
				}
			  }
			}
		     }
		     
		return  $linkDataHolder; 
		
	}

}