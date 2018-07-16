<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Task\Model\TaskModel;
use App\Modules\Task\Model\TaskTypeModel;
use App\Modules\User\Model\UserModel;
use Symfony\Component\Console\Helper\ProgressBar;
use Excel;
use File;
class KppwAddTask extends Command
{
    
    protected $signature = 'update:kppwTask';
    protected $TaskExcelLoad="task.xls";
	protected $excelData=array();
    
    protected $description = 'Add Task';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {   
	   if(!file_exists($this->TaskExcelLoad)){
		  $this->info('task.xls Not Found');exit;
	   }  
       Excel::load($this->TaskExcelLoad, function($reader) {
		  
		  $reader = $reader->getSheet(0);
		  $data = $reader->toArray();
		  $this->excelData=[];
		  $this->excelData=$data;
       });
	    
	    $TaskType=TaskTypeModel::select('id')->where('alias','xuanshang')->first();
	    $strString="abcdefghijkopqrstvuwrxz";
		for($j=0;$j<10;$j++){
			$User[]=json_decode(UserModel::create([
		       'name'=>$strString[rand(0,22)].$strString[rand(0,22)].$strString[rand(0,22)].$strString[rand(0,22)],
               'email_status'=>'2']),true);
		}
		unset($this->excelData[0]);
			$ResultData=[];
         foreach($this->excelData as $Ked=>$Ved){
			 $Ved[6]=$Ved[6]>0?$Ved[6]:rand(1000,4000);
			  $ResultData[]=[
			     'title'   => $Ved[1] ,
				 'desc'    => $Ved[10],
				 'type_id' =>$TaskType['id'],
				 'cate_id' =>166,
				 'status'  =>9,
				 'bounty'  =>$Ved[6],
				 'bounty_status' =>1,
				 'verified_at' =>'',
				 'begin_at'  =>'',
				 'end_at'  =>'',
				 'delivery_deadline' =>'',
				 'selected_work_at'=>'',
				 'publicity_at'=>'',
				 'checked_at'=>'',
				 'comment_at'=>'',
				 'show_cash'=>$Ved[6],
				 'real_cash'=>$Ved[6],
				 'deposit_cash'=>$Ved[6],
				 'province'=>1,
				 'city'=>37,
				 'area'=>0,
				 'view_count'=>$Ved[8],
				 'delivery_count'=>rand(1,10),
				 'uid'=>$User[rand(0,9)]['id'],
				 'username'=>$User[rand(0,9)]['name'],
				 'worker_num'=>1,
				 'created_at'=>date('Y-m-d H:i:s',strtotime($Ved[23])),
				 'updated_at'=>date('Y-m-d H:i:s',strtotime($Ved[24])),
				 
			];
		}
		$this->output->progressStart(10000);
		for($i=0;$i<10;$i++){
			$this->info('Data is migrating');
			$this->output->progressAdvance();
			$Task=TaskModel::insert(array_slice($ResultData,$i*1000,1000),true);
		}
		$this->output->progressFinish();
		if($Task){
			 File::delete($this->TaskExcelLoad);
		}
		 $this->info('add success');
    }
}
