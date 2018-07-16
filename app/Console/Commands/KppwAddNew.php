<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Article\Model\ArticleModel;
use App\Modules\Manage\Model\ArticleCategoryModel;
use App\Modules\User\Model\UserModel;
use Excel;
use File;
class KppwAddNew extends Command
{
    
    protected $signature = 'update:kppwNew';
    protected $NewExcelLoad="new.xls";
	protected $excelData=array();
    
    protected $description = 'Add New';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {   
	   if(!file_exists($this->NewExcelLoad)){
		  $this->info('new.xls Not Found');exit;
	   }  
       Excel::load($this->NewExcelLoad, function($reader) {
		  $reader = $reader->getSheet(0);
		  $data = $reader->toArray();
		  $this->excelData=[];
		  $this->excelData=$data;
       });
	   unset($this->excelData[0]);
	   
	   $ArticleCategory=ArticleCategoryModel::where('pid',1)->lists('id');
	   
	   $countLen=intval(count($this->excelData)/count($ArticleCategory));
       $strString="abcdefghijkopqrstvuwrxz";
		for($j=0;$j<5;$j++){
			$User[]=json_decode(UserModel::create([
		       'name'=>$strString[rand(0,22)].$strString[rand(0,22)].$strString[rand(0,22)].$strString[rand(0,22)],
               'email_status'=>'2']),true);
		}
	   $ResultData=[];
	   $this->output->progressStart(count($this->excelData));
	    for($i=0;$i<count($ArticleCategory);$i++)
		 {
			$ResDataArry=$i==(count($ArticleCategory)-1)?array_slice($this->excelData,$i*$countLen):array_slice($this->excelData,$i*$countLen,$countLen);			
			foreach($ResDataArry as $Ked=>$Ved){
			  $this->output->progressAdvance();
			  $keyVal=rand(0,4);
			  $ResultData[]=[
			     'cat_id'   => $ArticleCategory[$i],
				 'title'    => $Ved[2],
				 'author' =>$User[$keyVal]['name'],
				 'from' =>$Ved[4],
				 'fromurl'  =>$Ved[5],
				 'url'  =>$Ved[5],
				 'summary' =>'',
				 'pic' =>'',
				 'thumb'  =>'',
				 'tag'  =>'',
				 'created_at' =>date('Y-m-d H:i:s',1511 .rand(100000,999999)),
				 'status'=>0,
				 'content'=>$Ved[7],
				 'view_times'=>rand(10,100),
				 'seotitle'=>'',
				 'keywords'=>'',
				 'description'=>'',
				 'display_order'=>$Ked,
				 'is_recommended'=>1,
				 'updated_at'=>date('Y-m-d H:i:s',1511 .rand(100000,999999)),
				 'user_id'=>$User[$keyVal]['id'],
				 'user_name'=>$User[$keyVal]['name'], 
			];
		  }
		  
		}
		$Article=ArticleModel::insert($ResultData,true);

		$this->output->progressFinish();
		if($Article){
			 
		}
		 $this->info('add success');
    }
}
