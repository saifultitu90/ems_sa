<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mm_hom_agenda extends Root_Controller
{
    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Mm_hom_agenda');
        $this->locations=User_helper::get_locations();
        $this->controller_url='mm_hom_agenda';
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
        elseif($action=="forward")
        {
            $this->system_forward($id);
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

    private function system_add()
    {
        if(isset($this->permissions['add'])&&($this->permissions['add']==1))
        {
            $data['title']="Create New Agenda";
            $data["item"] = Array(
                'id' => 0,
                'date_hom_agenda' =>time(),
                'purpose' => '',
                'status' => $this->config->item('system_status_active')
            );
            $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
            $data['items']=array();
            foreach($div_items as &$item)
            {
                $s_item['agenda_id']='';
                $s_item['division_id']=$item['id'];
                $s_item['division_name']=$item['name'];
                $s_item['total_budget']='';
                $s_item['last_target']='';
                $s_item['last_achievement']='';
                $s_item['total_achievement']='';
                $s_item['next_month_target']='';
                $s_item['remarks_before_meeting']='';
                $data['sitems'][]=$s_item;
            }
            foreach($div_items as &$item)
            {
                $c_item['agenda_id']='';
                $c_item['division_id']=$item['id'];
                $c_item['division_name']=$item['name'];
                $c_item['total_budget']='';
                $c_item['last_target']='';
                $c_item['last_achievement']='';
                $c_item['total_achievement']='';
                $c_item['next_month_target']='';
                $c_item['remarks_before_meeting']='';
                $data['citems'][]=$c_item;
            }
            $data['meeting_complete']['meeting_status']='';
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
            $data['sitems']=$this->db->get()->result_array();
            if(!$data['sitems'])
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
                    $data['s_items'][]=$s_item;
                }
            }
            $this->db->from($this->config->item('table_mm_hom_collection_target_bm').' ct');
            $this->db->select('ct.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = ct.division_id','INNER');
            $this->db->where('ct.agenda_id',$agenda_id);
            $this->db->where('ct.revision', 1);
            $data['citems']=$this->db->get()->result_array();
            if(!$data['citems'])
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
                    $data['c_items'][]=$c_item;
                }
            }
            $this->db->from($this->config->item('table_mm_hom_meeting_status'));
            $this->db->select('*');
            $this->db->where('agenda_id',$agenda_id);
            $data['meeting_complete']=$this->db->get()->row_array();
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
            $this->db->trans_start();
            $time=time();
            $data=$this->input->post('item');
            $data['date_hom_agenda']=System_helper::get_time($data['date_hom_agenda']);
            $this->db->select('*');
            $this->db->from($this->config->item('table_mm_agenda_sales_hom'));
            $this->db->where('id',$id);
            $get_agenda_items=$this->db->get()->row_array();
            if($get_agenda_items)
            {
                $agenda_id=$id;
                $data['user_updated'] = $user->user_id;
                $data['date_updated'] = time();
                Query_helper::update($this->config->item('table_mm_agenda_sales_hom'),$data,array("id = ".$id));
            }else
            {
                $time=time();
                $data['user_created'] = $user->user_id;
                $data['date_created'] = time();
                $agenda_id=Query_helper::add($this->config->item('table_mm_agenda_sales_hom'),$data);
            }
            if($get_agenda_items)
            {
                $this->db->where('agenda_id',$id);
                $this->db->set('revision', 'revision+1', FALSE);
                $this->db->update($this->config->item('table_mm_hom_sales_target_bm'));
            }
            $sitems=$this->input->post('sitems');
            foreach($sitems as $division_id=>$item)
            {
                $data=$item;
                $data['agenda_id']=$agenda_id;
                $data['date_created']=$time;
                $data['user_created'] = $user->user_id;
                $sdata['division_id']=$division_id;
                $this->db->where('agenda_id', $data['agenda_id']);
                $this->db->where('division_id', $sdata['division_id']);
                Query_helper::add($this->config->item('table_mm_hom_sales_target_bm'),$data);
            }
            if($get_agenda_items)
            {
                $this->db->where('agenda_id',$id);
                $this->db->set('revision', 'revision+1', FALSE);
                $this->db->update($this->config->item('table_mm_hom_collection_target_bm'));
            }
            $citems=$this->input->post('citems');
            foreach($citems as $division_id=>$item)
            {
                $data=$item;
                $data['agenda_id']=$agenda_id;
                $data['date_created']=$time;
                $data['user_created'] = $user->user_id;
                $cdata['division_id']=$division_id;
                $this->db->where('agenda_id', $data['agenda_id']);
                $this->db->where('division_id', $cdata['division_id']);
                Query_helper::add($this->config->item('table_mm_hom_collection_target_bm'),$data);
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
        $this->load->library('form_validation');
        $this->form_validation->set_rules('item[date_hom_agenda]',$this->lang->line('LABEL_DATE_AGENDA'),'required');
        $this->form_validation->set_rules('item[purpose]',$this->lang->line('LABEL_PURPOSE'),'required');

        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }

    public function system_forward()
    {
        $id=$this->input->post('id');
        $this->db->trans_start();  //DB Transaction Handle START
        $data['forwarded_to_di']=$this->config->item('system_status_forwarded_to_di');
        $this->db->where('id', $id);
        $this->db->update($this->config->item('table_mm_agenda_sales_hom'), $data);
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
