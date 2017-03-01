<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mm_agenda_hom extends Root_Controller
{
    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Mm_agenda_hom');
        $this->locations=User_helper::get_locations();
        $this->controller_url='mm_agenda_hom';
    }
    public function index($action="list",$id=0)
    {
        if($action=="list")
        {
            $this->system_list($id);
        }
        elseif($action=="get_items")
        {
            $this->system_get_items();
        }
        elseif($action=="add")
        {
            $this->system_add();
        }
        elseif($action=="edit")
        {
            $this->system_edit($id);
        }
        elseif($action=="save")
        {
            $this->system_save();
        }
        elseif($action=="save_sales_bm")
        {
            $this->system_save_sales_bm();
        }
        elseif($action=="save_sales_im")
        {
            $this->system_save_sales_im();
        }
        elseif($action=="details")
        {
            $this->system_details($id);
        }
        else
        {
            $this->system_list($id);
        }
    }
    private function system_list()
    {
        if(isset($this->permissions['view'])&&($this->permissions['view']==1))
        {
            $data['title']="Agenda List";
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/list",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
    private function system_get_items()
    {
        $items=Query_helper::get_info($this->config->item('table_mm_agenda_hom'),array('id','purpose','date'),array('status !="'.$this->config->item('system_status_delete').'"'),0,0,array('id DESC'));
        foreach($items as &$item)
        {
            $item['date']=System_helper::display_date($item['date']);
        }
        $this->jsonReturn($items);
    }
    private function system_add()
    {
        if(isset($this->permissions['add'])&&($this->permissions['add']==1))
        {
            $data['title']="Create New Agenda";
            $data["item"] = Array(
                'id' => 0,
                'date' =>time(),
                'purpose' => '',
                'status' => $this->config->item('system_status_active')
            );
            $ajax['system_page_url']=site_url($this->controller_url."/index/add");
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
    private function system_edit($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            if(($this->input->post('id')))
            {
                $id=$this->input->post('id');
            }
            $data['item']=Query_helper::get_info($this->config->item('table_mm_agenda_hom'),'*',array('id ='.$id),1);
            $data['title']="Edit Agenda list ";
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/edit/'.$id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_save()
    {
        $id = $this->input->post("id");
        $user = User_helper::get_user();
        if($id>0)
        {
            if(!(isset($this->permissions['edit'])&&($this->permissions['edit']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }
        else
        {
            if(!(isset($this->permissions['add'])&&($this->permissions['add']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();

            }
        }
        if(!$this->check_validation())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->jsonReturn($ajax);
        }
        else
        {
            $data=$this->input->post('item');
            $items=Query_helper::get_info($this->config->item('table_mm_agenda_hom'),array('id','purpose','date'),array('id ='.$id,'status ="'.$this->config->item('system_status_active').'"'));
            if($items)
            {
                $time=time();
                $data['user_updated'] = $user->user_id;
                $data['date_updated'] = $time;
                Query_helper::update($this->config->item('table_mm_agenda_hom'),$data,array("id = ".$id));
            }else
            {
                $time=time();
                $data['user_created'] = $user->user_id;
                $data['date_created'] = $time;
                Query_helper::add($this->config->item('table_mm_agenda_hom'),$data);
            }
            $this->db->trans_complete();   //DB Transaction Handle END
            if ($this->db->trans_status() === TRUE)
            {
                $this->message=$this->lang->line("MSG_SAVED_SUCCESS");
                $this->system_list();
            }
            else
            {
                $ajax['status']=false;
                $ajax['desk_message']=$this->lang->line("MSG_SAVED_FAIL");
                $this->jsonReturn($ajax);
            }
        }
    }
    private function system_details($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            if(($this->input->post('id')))
            {
                $id=$this->input->post('id');
            }
            $data['item']=Query_helper::get_info($this->config->item('table_mm_agenda_hom'),'*',array('id ='.$id),1);
            $this->db->from($this->config->item('table_mm_agenda_hom_sales').' st');
            $this->db->select('st.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = st.id_division','INNER');
            $this->db->where('st.id_agenda',$id);
            $this->db->where('st.revision', 1);
            $data['sales_items']=$this->db->get()->result_array();
            if(!$data['sales_items'])
            {
                $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
                $data['sales_items']=array();
                foreach($div_items as &$item)
                {
                    $sales_item['id_agenda']=$id;
                    $sales_item['id_division']=$item['id'];
                    $sales_item['division_name']=$item['name'];
                    $sales_item['budget_total']='';
                    $sales_item['achievement_total']='';
                    $sales_item['target_current_month']='';
                    $sales_item['achievement_current_month']='';
                    $sales_item['target_next_month']='';
                    $sales_item['remarks_before_meeting']='';
                    if(($data['item']['status_forward']==$this->config->item('system_status_forward')))
                    {
                        $sales_item['target_next_month_im']='';
                        $sales_item['remarks_in_meeting']='';
                    }
                    $data['sales_items'][]=$sales_item;
                }
            }
            $this->db->from($this->config->item('table_mm_agenda_hom_collection').' ct');
            $this->db->select('ct.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = ct.id_division','INNER');
            $this->db->where('ct.id_agenda',$id);
            $this->db->where('ct.revision', 1);
            $data['collection_items']=$this->db->get()->result_array();
            if(!$data['collection_items'])
            {
                $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
                $data['collection_items']=array();
                foreach($div_items as &$item)
                {
                    $collection_item['id_agenda']=$id;
                    $collection_item['id_division']=$item['id'];
                    $collection_item['division_name']=$item['name'];
                    $collection_item['budget_total']='';
                    $collection_item['achievement_total']='';
                    $collection_item['target_current_month']='';
                    $collection_item['achievement_current_month']='';
                    $collection_item['target_next_month']='';
                    $collection_item['remarks_before_meeting']='';
                    if(($data['item']['status_forward']==$this->config->item('system_status_forward')))
                    {
                        $collection_item['target_next_month_im']='';
                        $collection_item['remarks_in_meeting']='';
                    }
                    $data['collection_items'][]=$collection_item;
                }
            }
            $this->db->trans_start();  //DB Transaction Handle START
            $data['agenda_id']=$id;
            $data['title']="Edit Agenda list ";
            $ajax['status']=true;
            if(($data['item']['status_forward']==$this->config->item('system_status_forward')) && !($data['item']['status_complete']==$this->config->item('system_status_complete')))
            {
                $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/details_im",$data,true));
            }
            else if(($data['item']['status_forward']==$this->config->item('system_status_forward')) && ($data['item']['status_complete']==$this->config->item('system_status_complete')))
            {
                $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/details_complete",$data,true));
            }else
            {
                $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/details_bm",$data,true));
            }
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
    private function system_save_sales_bm()
    {
        $id = $this->input->post("id");
        $user = User_helper::get_user();
        if($id>0)
        {
            if(!(isset($this->permissions['edit'])&&($this->permissions['edit']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }
        else
        {
            if(!(isset($this->permissions['add'])&&($this->permissions['add']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();

            }
        }
        $this->db->trans_start();
        $time=time();
        $this->db->select('*');
        $this->db->from($this->config->item('table_mm_agenda_hom_sales'));
        $this->db->where('id_agenda',$id);
        $items=$this->db->get()->result_array();
        if($items)
        {
            $this->db->where('id_agenda',$id);
            $this->db->set('revision', 'revision+1', FALSE);
            $this->db->update($this->config->item('table_mm_agenda_hom_sales'));
        }
        $sales_items=$this->input->post('sales_items');
        foreach($sales_items as $item)
        {
            $data=$item;
            $data['id_agenda']=$id;
            $data['date_created']=$time;
            $data['user_created'] = $user->user_id;
            Query_helper::add($this->config->item('table_mm_agenda_hom_sales'),$data);
        }
        if($items)
        {
            $this->db->where('id_agenda',$id);
            $this->db->set('revision', 'revision+1', FALSE);
            $this->db->update($this->config->item('table_mm_agenda_hom_collection'));
        }
        $collection_items=$this->input->post('collection_items');
        foreach($collection_items as $item)
        {
            $data=$item;
            $data['id_agenda']=$id;
            $data['date_created']=$time;
            $data['user_created'] = $user->user_id;
            Query_helper::add($this->config->item('table_mm_agenda_hom_collection'),$data);
        }
        $status_data['status_forward']=$this->input->post('status_forward');
        if(($status_data['status_forward']))
        {
           Query_helper::update($this->config->item('table_mm_agenda_hom'),$status_data,array("id = ".$id));
        }
        $this->db->trans_complete();   //DB Transaction Handle END
        if ($this->db->trans_status() === TRUE)
        {
            $this->message=$this->lang->line("MSG_SAVED_SUCCESS");
            $this->system_list();
        }
        else
        {
            $ajax['status']=false;
            $ajax['desk_message']=$this->lang->line("MSG_SAVED_FAIL");
            $this->jsonReturn($ajax);
        }
    }
    private function system_save_sales_im()
    {
        $id = $this->input->post("id");
        $user = User_helper::get_user();
        if($id>0)
        {
            if(!(isset($this->permissions['edit'])&&($this->permissions['edit']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }
        else
        {
            if(!(isset($this->permissions['add'])&&($this->permissions['add']==1)))
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();

            }
        }
        $time=time();
        $sales_items=$this->input->post('sales_items');
        foreach($sales_items as $division_id=>$item)
        {
            $data=$item;
            $data['id_agenda']=$id;
            $data['date_updated']=$time;
            $data['user_updated'] = $user->user_id;
            $sales_data['id_division']=$division_id;
            $this->db->where('id_agenda', $data['id_agenda']);
            $this->db->where('id_division', $sales_data['id_division']);
            $this->db->where('revision', 1);
            $this->db->update($this->config->item('table_mm_agenda_hom_sales'), $data);
        }
        $collection_items=$this->input->post('collection_items');
        foreach($collection_items as $division_id=>$item)
        {
            $data=$item;
            $data['id_agenda']=$id;
            $data['date_updated']=$time;
            $data['user_updated'] = $user->user_id;
            $collection_data['id_division']=$division_id;
            $this->db->where('id_agenda', $data['id_agenda']);
            $this->db->where('id_division', $collection_data['id_division']);
            $this->db->where('revision', 1);
            $this->db->update($this->config->item('table_mm_agenda_hom_collection'), $data);
        }
        $status_data['status_complete']=$this->input->post('status_complete');
        if(($status_data['status_complete']))
        {
            Query_helper::update($this->config->item('table_mm_agenda_hom'),$status_data,array("id = ".$id));
        }
        $this->db->trans_complete();   //DB Transaction Handle END
        if ($this->db->trans_status() === TRUE)
        {
            $this->message=$this->lang->line("MSG_SAVED_SUCCESS");
            $this->system_list();
        }
        else
        {
            $ajax['status']=false;
            $ajax['desk_message']=$this->lang->line("MSG_SAVED_FAIL");
            $this->jsonReturn($ajax);
        }
    }
    private function check_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('item[date]',$this->lang->line('LABEL_DATE_AGENDA'),'required');
        $this->form_validation->set_rules('item[purpose]',$this->lang->line('LABEL_PURPOSE'),'required');
        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
}
