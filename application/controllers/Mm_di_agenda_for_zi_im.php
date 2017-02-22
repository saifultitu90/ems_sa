<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mm_di_agenda_for_zi_im extends Root_Controller
{
    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Mm_di_agenda_for_zi_im');
        $this->locations=User_helper::get_locations();
        $this->controller_url='mm_di_agenda_for_zi_im';
    }
    public function index($action="list",$id=0)
    {
        if($action=="list")
        {
            $this->system_list($id);
        }elseif($action=="get_items")
        {
            $this->system_get_items();
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
    private function system_get_items()
    {
        $user = User_helper::get_user();
        if($user->user_group==1)
        {
            $this->db->from($this->config->item('table_mm_agenda_sales_hom').' shom');
            $this->db->select('shom.*');
            $this->db->order_by('shom.id DESC');
            $this->db->where('forwarded_to_di', $this->config->item('system_status_forwarded_to_di'));
            $items=$this->db->get()->result_array();
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
            $this->db->where('forwarded_to_di', $this->config->item('system_status_forwarded_to_di'));
            $items=$this->db->get()->result_array();
//          $items=Query_helper::get_info($this->config->item('table_mm_agenda_sales_hom'),array('id','purpose','date_hom_agenda','status'),array('status !="'.$this->config->item('system_status_delete').'"'),array('id DESC'));
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
            $results=$this->locations;
            $division_id=$results['division_id'];
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
            $this->db->where('st.division_id',$division_id);
            $this->db->where('st.revision', 1);
            $data['s_items_hom']=$this->db->get()->result_array();
            $this->db->select('*');
            $this->db->from($this->config->item('table_mm_di_sales_target_bm'));
            $this->db->where('agenda_id',$agenda_id);
            $this->db->where('division_id',$division_id);
            $data['get_s_items']=$this->db->get()->result_array();
//            $data['get_s_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id),1);
            if($data['get_s_items'])
            {
                $this->db->from($this->config->item('table_mm_di_sales_target_bm').' dist');
                $this->db->select('dist.*');
                $this->db->select('zones.name zone_name');
                $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dist.zone_id','INNER');
                $this->db->where('dist.agenda_id',$agenda_id);
                $this->db->where('dist.division_id',$division_id);
                $this->db->where('dist.revision', 1);
                $data['s_items']=$this->db->get()->result_array();
//                $data['s_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id));

            }else
            {
                $this->db->from($this->config->item('table_setup_location_zones'));
                $this->db->select('*');
                $this->db->where('division_id',$division_id);
                $zone_items=$this->db->get()->result_array();
//              $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
                foreach($zone_items as &$zone_item)
                {
                    $s_item['agenda_id']=$id;
                    $s_item['zone_id']=$zone_item['id'];
                    $s_item['zone_name']=$zone_item['name'];
                    $s_item['total_budget']='';
                    $s_item['total_achievement']='';
                    $s_item['current_month_target']='';
                    $s_item['current_month_achievement']='';
                    $s_item['next_month_target']='';
                    $s_item['next_month_target_im']='';
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
            $this->db->where('ct.division_id',$division_id);
            $this->db->where('ct.revision', 1);
            $data['c_items_hom']=$this->db->get()->result_array();
            $this->db->from($this->config->item('table_mm_di_collection_target_bm'));
            $this->db->select('*');
            $this->db->where('agenda_id',$agenda_id);
            $this->db->where('division_id',$division_id);
            $data['get_c_items']=$this->db->get()->result_array();
//          $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
            if($data['get_c_items'])
            {
                $this->db->from($this->config->item('table_mm_di_collection_target_bm').' dict');
                $this->db->select('dict.*');
                $this->db->select('zones.name zone_name');
                $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dict.zone_id','INNER');
                $this->db->where('dict.agenda_id',$agenda_id);
                $this->db->where('dict.division_id',$division_id);
                $this->db->where('dict.revision', 1);
                $data['c_items']=$this->db->get()->result_array();
//          $data['c_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id));
            }else
            {
                $this->db->from($this->config->item('table_setup_location_zones'));
                $this->db->select('*');
                $this->db->where('division_id',$division_id);
                $zone_items=$this->db->get()->result_array();
                foreach($zone_items as &$zone_item)
                {
                    $c_item['agenda_id']=$id;
                    $c_item['zone_id']=$zone_item['id'];
                    $c_item['zone_name']=$zone_item['name'];
                    $c_item['total_budget']='';
                    $c_item['total_achievement']='';
                    $c_item['current_month_target']='';
                    $c_item['current_month_achievement']='';
                    $c_item['next_month_target']='';
                    $c_item['next_month_target_im']='';
                    $c_item['remarks_before_meeting']='';
                    $c_item['remarks_in_meeting']='';
                    $data['c_items'][]=$c_item;
                }
            }
            $this->db->select('*');
            $this->db->from($this->config->item('table_mm_di_meeting_status'));
            $this->db->where('agenda_id',$agenda_id);
            $this->db->where('division_id',$division_id);
            $data['meeting_complete']=$this->db->get()->row_array();
            $data['title']="Edit Agenda list ";
            $ajax['status']=true;
            $data['div_id']=$results['division_id'];
            $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
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
        $div_id=$this->input->post('sales_division_id');
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
            foreach($sitems as $zone_id=>$item)
            {
                $data=$item;
                $data['agenda_id']=$agenda_id;
                $data['date_updated']=$time;
                $data['user_updated'] = $user->user_id;
                $sdata['zone_id']=$zone_id;
                $this->db->where('agenda_id', $data['agenda_id']);
                $this->db->where('zone_id', $sdata['zone_id']);
                $this->db->where('revision', 1);
                $this->db->update($this->config->item('table_mm_di_sales_target_bm'), $data);
            }
            $citems=$this->input->post('citems');
            foreach($citems as $zone_id=>$item)
            {
                $data=$item;
                $data['agenda_id']=$agenda_id;
                $data['date_updated']=$time;
                $data['user_updated'] = $user->user_id;
                $sdata['zone_id']=$zone_id;
                $this->db->where('agenda_id', $data['agenda_id']);
                $this->db->where('zone_id', $sdata['zone_id']);
                $this->db->where('revision', 1);
                $this->db->update($this->config->item('table_mm_di_collection_target_bm'), $data);
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
    private function check_validation()
    {
        return true;
    }
    private function system_details($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            $results=$this->locations;
            $division_id=$results['division_id'];
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
            $this->db->where('st.division_id',$division_id);
            $this->db->where('st.revision', 1);
            $data['s_items_hom']=$this->db->get()->result_array();
            $this->db->select('*');
            $this->db->from($this->config->item('table_mm_di_sales_target_bm'));
            $this->db->where('agenda_id',$agenda_id);
            $this->db->where('division_id',$division_id);
            $data['get_s_items']=$this->db->get()->result_array();
//            $data['get_s_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id),1);
            if($data['get_s_items'])
            {
                $this->db->from($this->config->item('table_mm_di_sales_target_bm').' dist');
                $this->db->select('dist.*');
                $this->db->select('zones.name zone_name');
                $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dist.zone_id','INNER');
                $this->db->where('dist.agenda_id',$agenda_id);
                $this->db->where('dist.division_id',$division_id);
                $this->db->where('dist.revision', 1);
                $data['s_items']=$this->db->get()->result_array();
//                $data['s_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id));

            }else
            {
                $this->db->from($this->config->item('table_setup_location_zones'));
                $this->db->select('*');
                $this->db->where('division_id',$division_id);
                $zone_items=$this->db->get()->result_array();
//                $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
                foreach($zone_items as &$zone_item)
                {
                    $s_item['agenda_id']=$id;
                    $s_item['zone_id']=$zone_item['id'];
                    $s_item['zone_name']=$zone_item['name'];
                    $s_item['total_budget']='';
                    $s_item['total_achievement']='';
                    $s_item['current_month_target']='';
                    $s_item['current_month_achievement']='';
                    $s_item['next_month_target']='';
                    $s_item['next_month_target_im']='';
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
            $this->db->where('ct.division_id',$division_id);
            $this->db->where('ct.revision', 1);
            $data['c_items_hom']=$this->db->get()->result_array();
            $this->db->select('*');
            $this->db->from($this->config->item('table_mm_di_collection_target_bm'));
            $this->db->where('agenda_id',$agenda_id);
            $this->db->where('division_id',$division_id);
            $data['get_c_items']=$this->db->get()->result_array();
//          $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
            if($data['get_c_items'])
            {
                $this->db->from($this->config->item('table_mm_di_collection_target_bm').' dict');
                $this->db->select('dict.*');
                $this->db->select('zones.name zone_name');
                $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dict.zone_id','INNER');
                $this->db->where('dict.agenda_id',$agenda_id);
                $this->db->where('dict.division_id',$division_id);
                $this->db->where('dict.revision', 1);
                $data['c_items']=$this->db->get()->result_array();
//          $data['c_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id));
            }else
            {
                $this->db->from($this->config->item('table_setup_location_zones'));
                $this->db->select('*');
                $this->db->where('division_id',$division_id);
                $zone_items=$this->db->get()->result_array();
                foreach($zone_items as &$zone_item)
                {
                    $c_item['agenda_id']=$id;
                    $c_item['zone_id']=$zone_item['id'];
                    $c_item['zone_name']=$zone_item['name'];
                    $c_item['total_budget']='';
                    $c_item['total_achievement']='';
                    $c_item['current_month_target']='';
                    $c_item['current_month_achievement']='';
                    $c_item['next_month_target']='';
                    $c_item['next_month_target_im']='';
                    $c_item['remarks_before_meeting']='';
                    $c_item['remarks_in_meeting']='';
                    $data['c_items'][]=$c_item;
                }
            }
            $data['agenda_id']=$agenda_id;
            $data['title']="Edit Agenda list ";
            $ajax['status']=true;
            $data['div_id']=$results['division_id'];
            $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
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
    private function system_meeting_complete($agenda_id)
    {
        $results=$this->locations;
        $division_id=$results['division_id'];
        $user = User_helper::get_user();
        $time=time();
        $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
        $this->db->trans_start();  //DB Transaction Handle START

        if($division_id>0)
        {
            $this->db->select('*');
            $this->db->from($this->config->item('table_mm_di_meeting_status'));
            $this->db->where('agenda_id',$agenda_id);
            $this->db->where('division_id',$division_id);
            $mdata['meeting_complete']=$this->db->get()->row_array();
            if($mdata['meeting_complete'])
            {
                $data['meeting_status']=$this->config->item('system_status_hom_approval_approved');
                $data['date_updated']=$time;
                $data['user_updated'] = $user->user_id;
                $this->db->where('agenda_id',$agenda_id);
                $this->db->where('division_id',$division_id);
                $this->db->update($this->config->item('table_mm_di_meeting_status'), $data);
            }else
            {
                $data['agenda_id']=$agenda_id;
                $data['division_id']=$division_id;
                $data['meeting_status']=$this->config->item('system_status_hom_approval_approved');
                $data['date_created']=$time;
                $data['user_created'] = $user->user_id;
                Query_helper::add($this->config->item('table_mm_di_meeting_status'),$data);
            }
        }else
        {
            $this->db->select('*');
            $this->db->from($this->config->item('table_mm_di_meeting_status'));
            $this->db->where('agenda_id',$agenda_id);
            $mdata['meeting_complete']=$this->db->get()->row_array();
            if($mdata['meeting_complete'])
            {
                foreach($div_items as $item)
                {
                    $data['meeting_status']=$this->config->item('system_status_hom_approval_approved');
                    $data['date_updated']=$time;
                    $data['user_updated'] = $user->user_id;
                    $this->db->where('agenda_id',$agenda_id);
                    $this->db->where('division_id',$item['id']);
                    $this->db->update($this->config->item('table_mm_di_meeting_status'), $data);
                }
            }else
            {
                foreach($div_items as $item)
                {
                    $data['agenda_id']=$agenda_id;
                    $data['division_id']=$item['id'];
                    $data['meeting_status']=$this->config->item('system_status_hom_approval_approved');
                    $data['date_created']=$time;
                    $data['user_created'] = $user->user_id;
                    Query_helper::add($this->config->item('table_mm_di_meeting_status'),$data);
                }

            }
        }
        $this->db->trans_complete();   //DB Transaction Handle END
        if ($this->db->trans_status() === TRUE)
        {
            $this->message=$this->lang->line("MSG_MEETING_COMPLETE");
            $this->system_list();
        }
        else
        {
            $ajax['status']=false;
            $ajax['desk_message']=$this->lang->line("MSG_SAVED_FAIL");
            $this->jsonReturn($ajax);
        }
    }
    public function get_zone()
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            $div_id=$this->input->post('division_id');
            $id=$this->input->post('agenda_id');
            $data['item']=Query_helper::get_info($this->config->item('table_mm_agenda_sales_hom'),'*',array('id ='.$id),1);
            $this->db->from($this->config->item('table_mm_hom_sales_target_bm').' st');
            $this->db->select('st.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = st.division_id','INNER');
            $this->db->where('st.agenda_id',$id);
            $this->db->where('st.division_id',$div_id);
            $this->db->where('st.revision', 1);
            $data['s_items_hom']=$this->db->get()->result_array();
            $this->db->from($this->config->item('table_mm_di_sales_target_bm'));
            $this->db->select('*');
            $this->db->where('agenda_id',$id);
            $this->db->where('division_id',$div_id);
            $data['get_s_items']=$this->db->get()->result_array();
//            $data['get_s_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id),1);
            if($data['get_s_items'])
            {
                $this->db->from($this->config->item('table_mm_di_sales_target_bm').' dist');
                $this->db->select('dist.*');
                $this->db->select('zones.name zone_name');
                $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dist.zone_id','INNER');
                $this->db->where('dist.agenda_id',$id);
                $this->db->where('dist.division_id',$div_id);
                $this->db->where('dist.revision',1);
                $data['s_items']=$this->db->get()->result_array();
//                $data['s_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id));
            }else
            {
                $this->db->from($this->config->item('table_setup_location_zones'));
                $this->db->select('*');
                $this->db->where('division_id',$div_id);
                $zone_items=$this->db->get()->result_array();
//              $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
                foreach($zone_items as &$zone_item)
                {
                    $s_item['agenda_id']=$id;
                    $s_item['zone_id']=$zone_item['id'];
                    $s_item['zone_name']=$zone_item['name'];
                    $s_item['total_budget']='';
                    $s_item['total_achievement']='';
                    $s_item['current_month_target']='';
                    $s_item['current_month_achievement']='';
                    $s_item['next_month_target']='';
                    $s_item['next_month_target_im']='';
                    $s_item['remarks_before_meeting']='';
                    $s_item['remarks_in_meeting']='';
                    $data['s_items'][]=$s_item;
                }
            }
            $this->db->from($this->config->item('table_mm_hom_collection_target_bm').' ct');
            $this->db->select('ct.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = ct.division_id','INNER');
            $this->db->where('ct.agenda_id',$id);
            $this->db->where('ct.division_id',$div_id);
            $this->db->where('ct.revision', 1);
            $data['c_items_hom']=$this->db->get()->result_array();
            $this->db->from($this->config->item('table_mm_di_collection_target_bm'));
            $this->db->select('*');
            $this->db->where('agenda_id',$id);
            $this->db->where('division_id',$div_id);
            $data['get_c_items']=$this->db->get()->result_array();
            if($data['get_c_items'])
            {
                $this->db->from($this->config->item('table_mm_di_collection_target_bm').' dict');
                $this->db->select('dict.*');
                $this->db->select('zones.name zone_name');
                $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dict.zone_id','INNER');
                $this->db->where('dict.agenda_id',$id);
                $this->db->where('dict.division_id',$div_id);
                $this->db->where('dict.revision',1);
                $data['c_items']=$this->db->get()->result_array();
//          $data['c_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id));
            }else
            {
                $this->db->from($this->config->item('table_setup_location_zones'));
                $this->db->select('*');
                $this->db->where('division_id',$div_id);
                $zone_items=$this->db->get()->result_array();
                foreach($zone_items as &$zone_item)
                {
                    $c_item['agenda_id']=$id;
                    $c_item['zone_id']=$zone_item['id'];
                    $c_item['zone_name']=$zone_item['name'];
                    $c_item['total_budget']='';
                    $c_item['total_achievement']='';
                    $c_item['current_month_target']='';
                    $c_item['current_month_achievement']='';
                    $c_item['next_month_target']='';
                    $c_item['next_month_target_im']='';
                    $c_item['remarks_before_meeting']='';
                    $c_item['remarks_in_meeting']='';
                    $data['c_items'][]=$c_item;
                }
            }
            $this->db->select('*');
            $this->db->from($this->config->item('table_mm_di_meeting_status'));
            $this->db->where('agenda_id',$id);
            $this->db->where('division_id',$div_id);
            $data['meeting_complete']=$this->db->get()->row_array();
            $data['title']="Edit Agenda list ";
            $ajax['status']=true;
            $html_container_id='#target_container';
//            $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $ajax['system_content'][]=array("id"=>$html_container_id,"html"=>$this->load->view("mm_di_agenda_for_zi_im/get_zone",$data,true));
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

    public function get_zone_for_details()
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            $div_id=$this->input->post('division_id');
            $id=$this->input->post('agenda_id');
            $data['item']=Query_helper::get_info($this->config->item('table_mm_agenda_sales_hom'),'*',array('id ='.$id),1);
            $this->db->from($this->config->item('table_mm_hom_sales_target_bm').' st');
            $this->db->select('st.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = st.division_id','INNER');
            $this->db->where('st.agenda_id',$id);
            $this->db->where('st.division_id',$div_id);
            $this->db->where('st.revision', 1);
            $data['s_items_hom']=$this->db->get()->result_array();
            $this->db->from($this->config->item('table_mm_di_sales_target_bm'));
            $this->db->select('*');
            $this->db->where('agenda_id',$id);
            $this->db->where('division_id',$div_id);
            $data['get_s_items']=$this->db->get()->result_array();
//            $data['get_s_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id),1);
            if($data['get_s_items'])
            {
                $this->db->from($this->config->item('table_mm_di_sales_target_bm').' dist');
                $this->db->select('dist.*');
                $this->db->select('zones.name zone_name');
                $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dist.zone_id','INNER');
                $this->db->where('dist.agenda_id',$id);
                $this->db->where('dist.division_id',$div_id);
                $this->db->where('dist.revision',1);
                $data['s_items']=$this->db->get()->result_array();
//                $data['s_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id));
            }else
            {
                $this->db->from($this->config->item('table_setup_location_zones'));
                $this->db->select('*');
                $this->db->where('division_id',$div_id);
                $zone_items=$this->db->get()->result_array();
//              $div_items=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"'));
                foreach($zone_items as &$zone_item)
                {
                    $s_item['agenda_id']=$id;
                    $s_item['zone_id']=$zone_item['id'];
                    $s_item['zone_name']=$zone_item['name'];
                    $s_item['total_budget']='';
                    $s_item['total_achievement']='';
                    $s_item['current_month_target']='';
                    $s_item['current_month_achievement']='';
                    $s_item['next_month_target']='';
                    $s_item['next_month_target_im']='';
                    $s_item['remarks_before_meeting']='';
                    $s_item['remarks_in_meeting']='';
                    $data['s_items'][]=$s_item;
                }
            }
            $this->db->from($this->config->item('table_mm_hom_collection_target_bm').' ct');
            $this->db->select('ct.*');
            $this->db->select('div.name division_name');
            $this->db->join($this->config->item('table_setup_location_divisions').' div','div.id = ct.division_id','INNER');
            $this->db->where('ct.agenda_id',$id);
            $this->db->where('ct.division_id',$div_id);
            $this->db->where('ct.revision', 1);
            $data['c_items_hom']=$this->db->get()->result_array();
            $this->db->from($this->config->item('table_mm_di_collection_target_bm'));
            $this->db->select('*');
            $this->db->where('agenda_id',$id);
            $this->db->where('division_id',$div_id);
            $data['get_c_items']=$this->db->get()->result_array();
            if($data['get_c_items'])
            {
                $this->db->from($this->config->item('table_mm_di_collection_target_bm').' dict');
                $this->db->select('dict.*');
                $this->db->select('zones.name zone_name');
                $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dict.zone_id','INNER');
                $this->db->where('dict.agenda_id',$id);
                $this->db->where('dict.division_id',$div_id);
                $this->db->where('dict.revision',1);
                $data['c_items']=$this->db->get()->result_array();
//          $data['c_items']=Query_helper::get_info($this->config->item('table_mm_di_sales_target_bm'),'*',array('agenda_id ='.$group_id));
            }else
            {
                $this->db->from($this->config->item('table_setup_location_zones'));
                $this->db->select('*');
                $this->db->where('division_id',$div_id);
                $zone_items=$this->db->get()->result_array();
                foreach($zone_items as &$zone_item)
                {
                    $c_item['agenda_id']=$id;
                    $c_item['zone_id']=$zone_item['id'];
                    $c_item['zone_name']=$zone_item['name'];
                    $c_item['total_budget']='';
                    $c_item['total_achievement']='';
                    $c_item['current_month_target']='';
                    $c_item['current_month_achievement']='';
                    $c_item['next_month_target']='';
                    $c_item['next_month_target_im']='';
                    $c_item['remarks_before_meeting']='';
                    $c_item['remarks_in_meeting']='';
                    $data['c_items'][]=$c_item;
                }
            }
            $this->db->from($this->config->item('table_mm_hom_meeting_status'));
            $this->db->select('*');
            $this->db->where('agenda_id',$id);
            $data['meeting_complete']=$this->db->get()->row_array();
            $data['title']="Edit Agenda list ";
            $ajax['status']=true;
            $html_container_id='#target_container';
//            $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $ajax['system_content'][]=array("id"=>$html_container_id,"html"=>$this->load->view("mm_di_agenda_for_zi_im/get_zone_for_details",$data,true));
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
}
