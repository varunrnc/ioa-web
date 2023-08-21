<?php
namespace App\Helpers\Classes;
/**
 * Easy Response Data
 */
use Validator;
use Illuminate\Support\Facades\DB;

class EasyData
{
	public $status=false;
	public $message="Failed";
	public $validate = true;
	public $validate_array = [];
	public $validation_errors = [];
	public $model = '';
	public $request = '';
	public $success_msg = '';
	public $saved_id = '';
	public $error_msg = 1;
	public $search_bold = false;

	public function status($sts){
		$this->status = $sts;
		if($sts == true){ $this->message = 'Success'; }
	}
	public function message($msg){ $this->message = $msg; }
	public function uid(){ return auth()->user()->uid; }
	public function success_msg($msg){ $this->success_msg = $msg; }
	public function error_msg($msg){ $this->error_msg = $msg; }
    
	public function json_output($extra_array = []){
		if($this->status == true and $this->message == 'Failed'){
			$this->message == 'Success';
		}
		$final_arr = array_merge([
            'status'=> $this->status,
            'message' => $this->message,
        ],$extra_array);
		return response()->json($final_arr);
	}

	public function data($col_name,$input_name,$validate_string=''){
		if(!empty($col_name) and !empty($input_name)){
			$this->model->$col_name = $this->request->$input_name;
			if(!empty($validate_string)){
				$this->validate_array = array_merge($this->validate_array,array($input_name => $validate_string));
			}
		}
	}

	public function datax($col_name,$input_value){
		if(!empty($col_name) and !empty($input_value)){
			$this->model->$col_name = $input_value;
		}
	}

	public function vdata($input_name,$validate_string=''){
		if(!empty($input_name)){
			if(!empty($validate_string)){
				$this->validate_array = array_merge($this->validate_array,array($input_name => $validate_string));
			}
		}
	}

	public function validate($v_string=''){
		$validation = Validator::make($this->request->all(),$this->validate_array);
		if($validation->passes()){
			return true;
		}else{
			$this->status = false;
			$this->validation_errors = $validation->errors()->all();
			$this->message = $this->get_errors(1);
			return false;
		}
	}

	public function save($value=''){
		$validation = true;
		if($this->validate == true){
			$validation = Validator::make($this->request->all(),$this->validate_array);
			if($validation->passes()){ $validation = true;}
			else{ $this->validation_errors = $validation->errors()->all(); $validation = false; }
		}
		if($validation == true){
           if($this->model->save() == true){
                $this->status = true;
                $this->message = $this->success_msg != "" ? $this->success_msg : 'success';
                $this->saved_id = $this->model->id;
                return true;
           }
       	}else{
       		$this->message = $this->get_errors($this->error_msg);
       	}
	}

	public function get_errors($breakit = false){
        $retn = '';
        $i = 1;
        foreach ($this->validation_errors as $err_msg){
            $retn .= $err_msg;
            if($breakit != false and $breakit >= $i){
                break;
            }
            $i++;
        }
        return $retn;
    }

    public function search_bold($value=false){
    	$this->search_bold = $value;
    }

    public function easy_search($table_name,$col_name='',$search_string=''){
    	$list = false;
    	if(!empty($this->request)){
    		if(!empty($this->request->col_name)){
    			$col_name = $this->request->col_name;
    		}
    		if(!empty($this->request->search_string)){
    			$search_string = $this->request->search_string;
    		}
    	}

    	if(!empty($table_name) and !empty($col_name)){
    		$search_string = strtolower($search_string);
    		$data = DB::table($table_name)->where($col_name,"LIKE","%".$search_string."%")->take(20)->get();

    		if(!empty($data)){
    			foreach($data as $row) {
    				$this->status = true;
    				$this->message = 'Success';
    				$search_value = strtolower($row->$col_name);
    				if($this->search_bold == true){
    					$search_value = str_replace($search_string, '<strong>'.$search_string.'</strong>', $search_value);

    				}
                    $list .= '<li data-id="'.$row->id.'" data-value="'.$row->$col_name.'">'.$search_value.'</li>';
                }
    		}
    	}
    	return $list;
    }

    public function delete_file($file_dir=false,$file_name=false){
		if(is_dir($file_dir) and !empty($file_name)){
			$slash = substr($file_dir,-1) == '/'? null : '/';
			$delete_file = $file_dir.$slash.$file_name;
			if(file_exists($delete_file)){
				// Delete The Thumbnail
				if(file_exists($file_dir.$slash.'thumbnail/'.$file_name)){
					unlink($file_dir.$slash.'thumbnail/'.$file_name);
				}
				unlink($delete_file);
				return true;
			}else{ return false; }
		}else{ return false; }
	}

}



