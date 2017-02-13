<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mm_hom_agenda_im extends Root_Controller
{
    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Mm_hom_agenda_im');
        $this->locations=User_helper::get_locations();
        $this->controller_url='mm_hom_agenda_im';
    }
    public function index($action="list",$id=0)
    {
        if($action=="list")
        {
            $this->system_list($id);
        }elseif($action=="get_items")
        {
            $this->get_items();
        }
        elseif($action=="edit")
        {
            $this->system_edit($id);
        }
        elseif($action=="save")
        {
            $this->system_save();
        }elseif($action=="details")
        {
            $this->system_details($id);
        }elseif($action=="meeting_complete")
        {
            $this->system_meeting_complete($id);
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

    private function get_items()
    {
        $user = User_helper::get_user();
        if($user->user_group==1)
        {
            $this->db->from($this->config->item('table_mm_agenda_sales_hom').' shom');
            $this->db->select('shom.*');
            $this->db->order_by('shom.id DESC');
            $items=$this->db->get()->result_array();
//            $items=Query_helper::get_info($this->config->item('table_mm_agenda_sales_hom'),array('id','purpose','date_hom_agenda','status'),array('status !="'.$this->config->item('system_status_delete').'"'),array('id DESC'));
            foreach($items as &$item)
            {
                $item['date_hom_agenda']=System_helper::display_date($item['date_hom_agenda']);
            }
        }
        else
        {
            $this->db->from($this->config->item('table_mm_agenda_sales_hom').' shom');
            $this->db->select('shom.*');
            $this->db->order_by('shom.id DESC');
            $items=$this->db->get()->result_array();
//            $items=Query_helper::get_info($this->config->item('table_mm_agenda_sales_hom'),array('id','purpose','date_hom_agenda','status'),array('status !="'.$this->config->item('system_status_delete').'"'),array('id DESC'));
            foreach($items as &$item)
            {
                $item['date_hom_agenda']=System_helper::display_date($item['date_hom_agenda']);
            }
        }
        $this->jsonReturn($items);
    }

    private function system_edit($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            if(($this->input->post('id')))
            {
                $agenda_id=$this->input->post('id');
            }
            else
            {
                $agenda_id=$id;
            }
            $data['item']=Query_helper::get_info($this->config->item('table_mm_agenda_sales_hom'),'*',array('id ='.$agenda_id),1);
            $this->db->from($this->config->item('table_mm_hom_sales_target_bm').' st');
            $this->db->select('st.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = st.division_id','INNER');
            $this->db->where('st.agenda_id',$agenda_id);
            $this->db->where('st.revision', 1);
            $data['s_items']=$this->db->get()->result_array();
            if(!$data['s_items'])
            {
                $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
                $data['items']=array();
                foreach($div_items as &$item)
                {
                    $s_item['agenda_id']=$agenda_id;
                    $s_item['division_id']=$item['id'];
                    $s_item['division_name']=$item['name'];
                    $s_item['total_budget']='';
                    $s_item['last_target']='';
                    $s_item['last_achievement']='';
                    $s_item['total_achievement']='';
                    $s_item['next_month_target']='';
                    $s_item['remarks_before_meeting']='';
                    $s_item['remarks_in_meeting']='';
                    $data['s_items'][]=$s_item;
                }
            }
            $this->db->from($this->config->item('table_mm_hom_collection_target_bm').' ct');
            $this->db->select('ct.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = ct.division_id','INNER');
            $this->db->where('ct.agenda_id',$agenda_id);
            $this->db->where('ct.revision', 1);
            $data['c_items']=$this->db->get()->result_array();
            if(!$data['c_items'])
            {
                $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
                $data['items']=array();
                foreach($div_items as &$item)
                {
                    $c_item['agenda_id']=1;
                    $c_item['division_id']=$item['id'];
                    $c_item['division_name']=$item['name'];
                    $c_item['total_budget']='';
                    $c_item['last_target']='';
                    $c_item['last_achievement']='';
                    $c_item['total_achievement']='';
                    $c_item['next_month_target']='';
                    $c_item['remarks_before_meeting']='';
                    $c_item['remarks_in_meeting']='';
                    $data['c_items'][]=$c_item;
                }
            }
//            $data['c_items']=Query_helper::get_info($this->config->item('table_mm_hom_collection_target_bm'),'*',array('agenda_id ='.$group_id));
            $this->db->trans_start();  //DB Transaction Handle START
            $this->db->from($this->config->item('table_mm_hom_meeting_status'));
            $this->db->select('*');
            $this->db->where('agenda_id',$agenda_id);
            $data['meeting_complete']=$this->db->get()->row_array();
            $data['agenda_id']=$agenda_id;
            $data['title']="Edit Agenda list ";
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/edit/'.$agenda_id);
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
            $this->db->trans_start();  //DB Transaction Handle START
            $time=time();
            $agenda_id=$this->input->post('agenda_id');
            $sitems=$this->input->post('sitems');
            foreach($sitems as $division_id=>$item)
            {
                $data=$item;
                $data['agenda_id']=$agenda_id;
                $data['date_updated']=$time;
                $data['user_updated'] = $user->user_id;
                $sdata['division_id']=$division_id;
                $this->db->where('agenda_id', $data['agenda_id']);
                $this->db->where('division_id', $sdata['division_id']);
                $this->db->where('revision', 1);
                $this->db->update($this->config->item('table_mm_hom_sales_target_bm'), $data);
            }
            $citems=$this->input->post('citems');
            foreach($citems as $division_id=>$item)
            {
                $data=$item;
                $data['agenda_id']=$agenda_id;
                $data['date_updated']=$time;
                $data['user_updated'] = $user->user_id;
                $sdata['division_id']=$division_id;
                $this->db->where('agenda_id', $data['agenda_id']);
                $this->db->where('division_id', $sdata['division_id']);
                $this->db->where('revision', 1);
                $this->db->update($this->config->item('table_mm_hom_collection_target_bm'), $data);
            }
            $this->db->trans_complete();   //DB Transaction Handle END
            if ($this->db->trans_status() === TRUE)
            {
                $save_and_new=$this->input->post('system_save_new_status');
                $this->message=$this->lang->line("MSG_SAVED_SUCCESS");
                if($save_and_new==1)
                {
                    $this->system_add($id);
                }
                else
                {
                    $this->system_list();
                }
            }
            else
            {
                $ajax['status']=false;
                $ajax['desk_message']=$this->lang->line("MSG_SAVED_FAIL");
                $this->jsonReturn($ajax);
            }
        }
    }
    private function check_validation()
    {
        return true;
    }
    private function system_meeting_complete($agenda_id)
    {
        $user = User_helper::get_user();
        $time=time();
        $this->db->trans_start();  //DB Transaction Handle START
        $this->db->from($this->config->item('table_mm_hom_meeting_status'));
        $this->db->select('*');
        $this->db->where('agenda_id',$agenda_id);
        $mdata['meeting_complete']=$this->db->get()->row_array();
        if($mdata['meeting_complete'])
        {
            $this->message=$this->lang->line("MSG_MEETING_COMPLETED_ALREADY");
            $this->system_list();
        }else
        {
            $data['agenda_id']=$agenda_id;
            $data['meeting_status']=$this->config->item('system_status_hom_approval_approved');
            $data['date_created']=$time;
            $data['user_created'] = $user->user_id;
            Query_helper::add($this->config->item('table_mm_hom_meeting_status'),$data);
        }
        $this->db->trans_complete();   //DB Transaction Handle END
        if ($this->db->trans_status() === TRUE)
        {
            $save_and_new=$this->input->post('system_save_new_status');
            if($save_and_new==1)
            {
                $this->system_add($agenda_id);
            }
            else
            {
                $this->message=$this->lang->line("MSG_MEETING_COMPLETE");
                $this->system_list();
            }
        }
        else
        {
            $ajax['status']=false;
            $ajax['desk_message']=$this->lang->line("MSG_SAVED_FAIL");
            $this->jsonReturn($ajax);
        }
    }
    private function system_details($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            if(($this->input->post('id')))
            {
                $agenda_id=$this->input->post('id');
            }
            else
            {
                $agenda_id=$id;
            }
            $data['item']=Query_helper::get_info($this->config->item('table_mm_agenda_sales_hom'),'*',array('id ='.$agenda_id),1);
            $this->db->from($this->config->item('table_mm_hom_sales_target_bm').' st');
            $this->db->select('st.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = st.division_id','INNER');
            $this->db->where('st.agenda_id',$agenda_id);
            $this->db->where('st.revision', 1);
            $data['s_items']=$this->db->get()->result_array();
            $this->db->from($this->config->item('table_mm_hom_collection_target_bm').' ct');
            $this->db->select('ct.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = ct.division_id','INNER');
            $this->db->where('ct.agenda_id',$agenda_id);
            $this->db->where('ct.revision', 1);
            $data['c_items']=$this->db->get()->result_array();
            $data['agenda_id']=$agenda_id;
            $data['title']="Edit Agenda list ";
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/details",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$agenda_id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
}
