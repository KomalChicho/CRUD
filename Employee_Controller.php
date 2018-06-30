<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Employee_Controller extends CI_Controller
	{		
		function __construct()
		{
				parent::__construct();
				$this->load->model('Employee_Model');
				$this->load->library('pagination');
		}

		public function index()
		{
			$config = array();
			$config["base_url"] = base_url()."index.php/Employee_Controller/index";

			$config["total_rows"] = $this->Employee_Model->record_count();	
			$config["per_page"] = 5;
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["results"] = $this->Employee_Model->fetch_id($config["per_page"],$page);

			$data["links"] = $this->pagination->create_links();

			$this->load->view('Emp_insert',$data);
		}
		public function InsertData()
		{
			# code...
			/*$data['e_name'] = $_POST['emp_name'];
			$data['e_salary'] = $_POST['emp_salary'];
			$data['e_designation'] = $_POST['emp_desig'];
			$data['e_hobbies'] = $hob; */

			$this->form_validation->set_rules('emp_name','name','required');
			$this->form_validation->set_rules('emp_salary','salary','required');
			$this->form_validation->set_rules('emp_desig','desig','required');
			$this->form_validation->set_rules('chk[]','hobbies','required');
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('Emp_insert');
			}
			else
			{
				$hobbies = $this->input->post('chk');
				$hob = implode(',', $hobbies);

				$data = array('e_id'=>null,'e_name'=>$this->input->post('emp_name'),'e_salary'=>$this->input->post('emp_salary'),'e_designation'=>$this->input->post('emp_desig'),'e_hobbies'=>($hob));
				$res = $this->Employee_Model->Ins('employee',$data);
				if ($res) 
				{
				# code...
					redirect('Employee_Controller');
				}
				else
				{
					echo "Not Inserted";
				}	
			}			
		}
		public function delid($id)
		{
			# code...
			$this->Employee_Model->dlt('employee',$id);
			redirect('Employee_Controller');
		}
		public function editid($id)
		{
			$this->form_validation->set_rules('emp_name','name','required');
			$this->form_validation->set_rules('emp_salary','salary','required');
			$this->form_validation->set_rules('emp_desig','desig','required');
			$this->form_validation->set_rules('chk[]','hobbies','required');
			if ($this->form_validation->run() == FALSE)
			{
				$l['id'] = $id;
				$this->load->view('Emp_edit',$l);
			}
			else
			{
				$hobbies = $this->input->post('chk');
				$hob = implode(',', $hobbies);

				$data = array('e_name'=>$this->input->post('emp_name'),'e_salary'=>$this->input->post('emp_salary'),'e_designation'=>$this->input->post('emp_desig'),'e_hobbies'=>($hob));
				$res = $this->Employee_Model->edit('employee',$data,'e_id',$id);
				if ($res) 
				{
				# code...
					redirect('Employee_Controller');
				}
				else
				{
					echo "Not Inserted";
				}	
			}	
		}
	}
 ?>
