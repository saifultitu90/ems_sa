<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mm_agenda_zi extends Root_Controller
{
    private  $message;
    public $permissions;
    public $controller_url;
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->message="";
        $this->permissions=User_helper::get_permission('Mm_agenda_zi');
        $this->locations=User_helper::get_locations();
        $this->controller_url='mm_agenda_zi';
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
        elseif($action=="details")
        {
            $this->system_details($id);
        }
        elseif($action=="save")
        {
            $this->system_save();
        }
        elseif($action=="save_im")
        {
            $this->system_save_im();
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
        $location_results=$this->locations;
        $division_id=$location_results['division_id'];
        $zone_id=$location_results['zone_id'];
        $this->db->select('agenda_zi.agenda_id,agenda_zi.date,agenda_zi.status_forward,agenda_zi.status_complete');
        $this->db->select('agenda_di.status_forward status_forward_di,agenda_di.status_complete status_complete_di,agenda_di.date date_di');
        $this->db->select('agenda_hom.purpose,agenda_hom.id');
        $this->db->from($this->config->item('table_mm_agenda_zi').' agenda_zi');
        $this->db->join($this->config->item('table_mm_agenda_di').' agenda_di','agenda_di.agenda_id=agenda_zi.agenda_id','INNER');
        $this->db->join($this->config->item('table_mm_agenda_hom').' agenda_hom','agenda_hom.id=agenda_zi.agenda_id');
        if($zone_id>0 && $division_id>0)
        {
            $this->db->where('agenda_di.status_forward',$this->config->item('system_status_forward'));
            $this->db->where('agenda_zi.zone_id',$zone_id);
            $this->db->where('agenda_di.division_id',$division_id);
            $items=$this->db->get()->result_array();

            foreach($items as &$item)
            {
                $item['date_di']=System_helper::display_date($item['date_di']);
            }
        }
        elseif($division_id>0)
        {
            $this->db->where('agenda_di.status_forward',$this->config->item('system_status_forward'));
            $this->db->where('agenda_di.division_id',$division_id);
            $this->db->group_by('agenda_di.agenda_id');
            $items=$this->db->get()->result_array();
            foreach($items as &$item)
            {
                $item['date_di']=System_helper::display_date($item['date_di']);
            }
        }
        else
        {
            $this->db->group_by('agenda_di.agenda_id');
            $results=$this->db->get()->result_array();
            $items=array();
            $temp=array();
            foreach($results as $result)
            {
                if($result['status_forward_di']==$this->config->item('system_status_forward'))
                {
                    if(!isset($temp[$result['agenda_id']]))
                    {
                        $items[]=$result;
                        $temp[$result['agenda_id']]=true;
                    }
                }
            }
            foreach($items as &$item)
            {
                $item['date_di']=System_helper::display_date($item['date_di']);
            }
        }

        foreach($items as &$item)
        {
            $item['date']=System_helper::display_date($item['date']);
        }
        $this->jsonReturn($items);
    }
    public function system_details($id)
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            $location_results=$this->locations;
            $division_id=$location_results['division_id'];
            $zone_id=$location_results['zone_id'];
            if(($this->input->post('id')))
            {

                $id=$this->input->post('id');
            }
            if($zone_id==0)
            {
                $this->get_details($id);
            }
            $this->db->select('az.*');
            $this->db->select('ah.purpose');
            $this->db->select('agenda_di.date date_di');
            $this->db->from($this->config->item('table_mm_agenda_zi').' az');
            $this->db->join($this->config->item('table_mm_agenda_hom').' ah','ah.id = az.agenda_id','LEFT');
            $this->db->join($this->config->item('table_mm_agenda_di').' agenda_di','agenda_di.agenda_id=az.agenda_id','INNER');
            $this->db->where('az.zone_id',$zone_id);
            $this->db->where('az.agenda_id',$id);
            $data['item']=$this->db->get()->row_array();
            if(is_null($data['item']['date']))
            {
                $data["item"]['date'] ='';
            }
            $this->db->from($this->config->item('table_mm_agenda_di_sales').' dist');
            $this->db->select('dist.*');
            $this->db->select('zones.name zone_name');
            $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dist.zone_id','INNER');
            $this->db->where('dist.agenda_id',$id);
            $this->db->where('dist.zone_id',$zone_id);
            $this->db->where('dist.revision', 1);
            $data['s_items_di']=$this->db->get()->result_array();
            $data['di_meeting_status']=Query_helper::get_info($this->config->item('table_mm_agenda_di'),'*',array('agenda_id ='.$id,'division_id ='.$division_id),1);
            $data['sales_result']=Query_helper::get_info($this->config->item('table_mm_agenda_zi_sales'),array('*'),array('agenda_id ='.$id,'zone_id ='.$zone_id));
            if($data['sales_result'])
            {
                $this->db->from($this->config->item('table_mm_agenda_zi_sales').' zist');
                $this->db->select('zist.*');
                $this->db->select('territories.name territory_name');
                $this->db->join($this->config->item('table_setup_location_territories').' territories','territories.id = zist.territory_id','INNER');
                $this->db->where('zist.agenda_id',$id);
                $this->db->where('zist.zone_id',$zone_id);
                $this->db->where('zist.revision', 1);
                $data['sales_items']=$this->db->get()->result_array();
            }
            else
            {
                $results=Query_helper::get_info($this->config->item('table_setup_location_territories'),'*',array('zone_id ='.$zone_id));
                foreach($results as &$result)
                {
                    $sales_item['agenda_id']=$id;
                    $sales_item['territory_id']=$result['id'];
                    $sales_item['territory_name']=$result['name'];
                    $sales_item['budget_total']='';
                    $sales_item['achievement_total']='';
                    $sales_item['target_last_month']='';
                    $sales_item['achievement_last_month']='';
                    $sales_item['target_current_month']='';
                    $sales_item['achievement_current_month']='';
                    $sales_item['target_next_month']='';
                    $sales_item['remarks_before_meeting']='';
                    if(($data['item']['status_forward']==$this->config->item('system_status_forward')))
                    {
                        $sales_item['target_next_month_im']='';
                        $sales_item['remarks_in_meeting']='';
                    }
                    if(($data['di_meeting_status']['status_complete']==$this->config->item('system_status_complete')))
                    {
                        $sales_item['target_next_month_for_ti']='';
                    }
                    $data['sales_items'][]=$sales_item;
                }
            }
            $this->db->from($this->config->item('table_mm_agenda_di_collection').' dict');
            $this->db->select('dict.*');
            $this->db->select('zones.name zone_name');
            $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dict.zone_id','INNER');
            $this->db->where('dict.agenda_id',$id);
            $this->db->where('dict.zone_id',$zone_id);
            $this->db->where('dict.revision', 1);
            $data['c_items_di']=$this->db->get()->result_array();
            $data['collection_result']=Query_helper::get_info($this->config->item('table_mm_agenda_zi_collection'),array('*'),array('agenda_id ='.$id,'zone_id ='.$zone_id));
            if($data['collection_result'])
            {
                $this->db->from($this->config->item('table_mm_agenda_zi_collection').' zict');
                $this->db->select('zict.*');
                $this->db->select('territories.name territory_name');
                $this->db->join($this->config->item('table_setup_location_territories').' territories','territories.id = zict.territory_id','INNER');
                $this->db->where('zict.agenda_id',$id);
                $this->db->where('zict.zone_id',$zone_id);
                $this->db->where('zict.revision', 1);
                $data['collection_items']=$this->db->get()->result_array();
            }else
            {
                $results=Query_helper::get_info($this->config->item('table_setup_location_territories'),'*',array('zone_id ='.$zone_id));
                foreach($results as &$result)
                {
                    $collection_item['agenda_id']=$id;
                    $collection_item['territory_id']=$result['id'];
                    $collection_item['territory_name']=$result['name'];
                    $collection_item['budget_total']='';
                    $collection_item['achievement_total']='';
                    $collection_item['target_last_month']='';
                    $collection_item['achievement_last_month']='';
                    $collection_item['target_current_month']='';
                    $collection_item['achievement_current_month']='';
                    $collection_item['target_next_month']='';
                    $collection_item['remarks_before_meeting']='';
                    if(($data['item']['status_forward']==$this->config->item('system_status_forward')))
                    {
                        $collection_item['target_next_month_im']='';
                        $collection_item['remarks_in_meeting']='';
                    }
                    if(($data['di_meeting_status']['status_complete']==$this->config->item('system_status_complete')))
                    {
                        $collection_item['target_next_month_for_ti']='';
                    }
                    $data['collection_items'][]=$collection_item;
                }
            }
            $data['title']="Agenda";
            $ajax['status']=true;
            $data['id']=$id;
            $data['div_id']=$location_results['division_id'];
            $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            $data['zones']=Query_helper::get_info($this->config->item('table_setup_location_zones'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
            if(($data['item']['status_forward']==$this->config->item('system_status_forward')) && !($data['item']['status_complete']==$this->config->item('system_status_complete')))
            {
                $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/details_im",$data,true));
            }
            else if(($data['item']['status_forward']==$this->config->item('system_status_forward')) && ($data['item']['status_complete']==$this->config->item('system_status_complete')))
            {
                $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/details_complete",$data,true));
            }
            else
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

    private function system_save()
    {
        $user = User_helper::get_user();
        $time=time();
        $results=$this->locations;
        if($results['division_id']>0)
        {
            $division_id=$results['division_id'];
        }else
        {
            $division_id=$this->input->post('division_id');
        }
        $zone_id=$this->input->post('sales_zone_id');
        $agenda_id = $this->input->post("agenda_id");
        $data['di_meeting_status']=Query_helper::get_info($this->config->item('table_mm_agenda_di'),'*',array('agenda_id ='.$agenda_id,'division_id ='.$division_id),1);
        if($agenda_id>0)
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
        if(!($data['di_meeting_status']['status_complete']==$this->config->item('system_status_complete')) && ($this->input->post('status_forward')))
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("MSG_MEETING_COMPLETE_ERR_DI");
            $this->jsonReturn($ajax);
            die();
        }
        else
        {
            if(!($data['di_meeting_status']['status_complete']==$this->config->item('system_status_complete')))
            {
                $this->db->trans_start();  //DB Transaction Handle START
                $data=$this->input->post('item');
                $data['date']=System_helper::get_time($data['date']);
                $data['user_updated'] = $user->user_id;
                $data['date_updated'] = $time;
                if($data['date'])
                {
                    Query_helper::update($this->config->item('table_mm_agenda_zi'),$data,array("agenda_id = ".$agenda_id,"zone_id = ".$zone_id));
                }
                $data['get_sales_items']=Query_helper::get_info($this->config->item('table_mm_agenda_zi_sales'),'*',array('agenda_id ='.$agenda_id,'zone_id ='.$zone_id));
                if($data['get_sales_items'])
                {
                    $this->db->where('agenda_id',$agenda_id);
                    $this->db->where('zone_id',$zone_id);
                    $this->db->set('revision', 'revision+1', FALSE);
                    $this->db->update($this->config->item('table_mm_agenda_zi_sales'));
                    $sales_items=$this->input->post('s_items');
                    $s_data_di_nm='';
                    foreach($sales_items as $item)
                    {
                        $data=$item;
                        $data['agenda_id']=$agenda_id;
                        $data['zone_id']=$zone_id;
                        $data['date_created']=$time;
                        $data['user_created'] = $user->user_id;
                        Query_helper::add($this->config->item('table_mm_agenda_zi_sales'),$data);
                        $s_data_di_nm+=$item['target_next_month'];
                    }
                    $s_data_di_nm_t['target_next_month_im']=$s_data_di_nm;
                    $this->db->where('agenda_id', $agenda_id);
                    $this->db->where('zone_id', $zone_id);
                    $this->db->where('revision', 1);
                    $this->db->update($this->config->item('table_mm_agenda_di_sales'), $s_data_di_nm_t);
                    $this->db->where('agenda_id',$agenda_id);
                    $this->db->where('zone_id',$zone_id);
                    $this->db->set('revision', 'revision+1', FALSE);
                    $this->db->update($this->config->item('table_mm_agenda_zi_collection'));
                    $collection_items=$this->input->post('c_items');
                    $c_data_di_nm='';
                    foreach($collection_items as $item)
                    {
                        $data=$item;
                        $data['agenda_id']=$agenda_id;
                        $data['zone_id']=$zone_id;
                        $data['date_created']=$time;
                        $data['user_created'] = $user->user_id;
                        Query_helper::add($this->config->item('table_mm_agenda_zi_collection'),$data);
                        $c_data_di_nm+=$item['target_next_month'];
                    }
                    $c_data_di_nm_t['target_next_month_im']=$c_data_di_nm;
                    $this->db->where('agenda_id', $agenda_id);
                    $this->db->where('zone_id', $zone_id);
                    $this->db->where('revision', 1);
                    $this->db->update($this->config->item('table_mm_agenda_di_collection'), $c_data_di_nm_t);
                }
                else
                {
                    $sales_items=$this->input->post('s_items');
                    $s_data_di_nm='';
                    foreach($sales_items as $item)
                    {
                        $data=$item;
                        $data['agenda_id']=$agenda_id;
                        $data['zone_id']=$zone_id;
                        $data['date_created']=$time;
                        $data['user_created'] = $user->user_id;
                        Query_helper::add($this->config->item('table_mm_agenda_zi_sales'),$data);
                        $s_data_di_nm+=$item['target_next_month'];
                    }
                    $s_data_di_nm_t['target_next_month_im']=$s_data_di_nm;
                    $this->db->where('agenda_id', $agenda_id);
                    $this->db->where('zone_id', $zone_id);
                    $this->db->where('revision', 1);
                    $this->db->update($this->config->item('table_mm_agenda_di_sales'), $s_data_di_nm_t);
                    $collection_items=$this->input->post('c_items');
                    $c_data_di_nm='';
                    foreach($collection_items as $item)
                    {
                        $data=$item;
                        $data['agenda_id']=$agenda_id;
                        $data['zone_id']=$zone_id;
                        $data['date_created']=$time;
                        $data['user_created'] = $user->user_id;
                        Query_helper::add($this->config->item('table_mm_agenda_zi_collection'),$data);
                        $c_data_di_nm+=$item['target_next_month'];
                    }
                    $c_data_di_nm_t['target_next_month_im']=$c_data_di_nm;
                    $this->db->where('agenda_id', $agenda_id);
                    $this->db->where('zone_id', $zone_id);
                    $this->db->where('revision', 1);
                    $this->db->update($this->config->item('table_mm_agenda_di_collection'), $c_data_di_nm_t);
                }
            }
            else
            {
                $status_data['status_forward']=$this->input->post('status_forward');
                if(($status_data['status_forward']) && ($data['di_meeting_status']['status_complete']==$this->config->item('system_status_complete')))
                {
                    Query_helper::update($this->config->item('table_mm_agenda_zi'),$status_data,array("agenda_id = ".$agenda_id,"zone_id = ".$zone_id));
                    $results=Query_helper::get_info($this->config->item('table_setup_location_territories'),array('id','name','status','ordering'),array('status !="'.$this->config->item('system_status_delete').'"',"zone_id = ".$zone_id));
                    foreach($results as $result)
                    {
                        if(!$this->check_validation())
                        {
                            $ajax['status']=false;
                            $ajax['system_message']=$this->message;
                            $this->jsonReturn($ajax);
                        }
                        $ti_agenda_data['agenda_id']=$agenda_id;
                        $ti_agenda_data['territory_id']=$result['id'];
                        $ti_agenda_data['date_created']=$time;
                        $ti_agenda_data['user_created']=$user->user_id;
                        Query_helper::add($this->config->item('table_mm_agenda_ti'),$ti_agenda_data);
                        $data=$this->input->post('item');
                        $data['date']=System_helper::get_time($data['date']);
                        $data['user_updated'] = $user->user_id;
                        $data['date_updated'] = $time;
                        if($data['date'])
                        {
                            Query_helper::update($this->config->item('table_mm_agenda_zi'),$data,array("agenda_id = ".$agenda_id,"zone_id = ".$zone_id));
                        }
                    }

                    $sales_items=$this->input->post('s_items');
                    foreach($sales_items as $territory_id=>$item)
                    {
                        $data=$item;
                        $data['user_updated'] = $user->user_id;
                        $data['date_updated'] = $time;
                        $this->db->where('agenda_id', $agenda_id);
                        $this->db->where('zone_id', $zone_id);
                        $this->db->where('territory_id', $territory_id);
                        $this->db->where('revision', 1);
                        $this->db->update($this->config->item('table_mm_agenda_zi_sales'), $data);
                    }

                    $collection_items=$this->input->post('c_items');
                    foreach($collection_items as $territory_id=>$item)
                    {
                        $data=$item;
                        $data['user_updated'] = $user->user_id;
                        $data['date_updated'] = $time;
                        $this->db->where('agenda_id', $agenda_id);
                        $this->db->where('zone_id', $zone_id);
                        $this->db->where('territory_id', $territory_id);
                        $this->db->where('revision', 1);
                        $this->db->update($this->config->item('table_mm_agenda_zi_collection'), $data);
                    }
                }
                else if(!($status_data['status_forward']) && ($data['di_meeting_status']['status_complete']==$this->config->item('system_status_complete')))
                {
                    $sales_items=$this->input->post('s_items');
                    foreach($sales_items as $territory_id=>$item)
                    {
                        $data=$item;
                        $data['user_updated'] = $user->user_id;
                        $data['date_updated'] = $time;
                        $this->db->where('agenda_id', $agenda_id);
                        $this->db->where('zone_id', $zone_id);
                        $this->db->where('territory_id', $territory_id);
                        $this->db->where('revision', 1);
                        $this->db->update($this->config->item('table_mm_agenda_zi_sales'), $data);
                    }
                    $collection_items=$this->input->post('c_items');
                    foreach($collection_items as $territory_id=>$item)
                    {
                        $data=$item;
                        $data['user_updated'] = $user->user_id;
                        $data['date_updated'] = $time;
                        $this->db->where('agenda_id', $agenda_id);
                        $this->db->where('zone_id', $zone_id);
                        $this->db->where('territory_id', $territory_id);
                        $this->db->where('revision', 1);
                        $this->db->update($this->config->item('table_mm_agenda_zi_collection'), $data);
                    }
                    $data=$this->input->post('item');
                    $data['date']=System_helper::get_time($data['date']);
                    $data['user_updated'] = $user->user_id;
                    $data['date_updated'] = $time;
                    if($data['date'])
                    {
                        Query_helper::update($this->config->item('table_mm_agenda_zi'),$data,array("agenda_id = ".$agenda_id,"zone_id = ".$zone_id));
                    }
                }
                else
                {
                    $this->message=$this->lang->line("MSG_MEETING_COMPLETE_ERR");
                    $this->system_list();
                }
            }
            $this->db->trans_complete();   //DB Transaction Handle END
            if ($this->db->trans_status() === TRUE)
            {
                $this->message=$this->lang->line("MSG_SAVED_SUCCESS");
                $this->system_details($agenda_id);
            }
            else
            {
                $ajax['status']=false;
                $ajax['desk_message']=$this->lang->line("MSG_SAVED_FAIL");
                $this->jsonReturn($ajax);
            }
        }
    }
    private function system_save_im()
    {
        $zone_id=$this->input->post('sales_zone_id');
        $id = $this->input->post("agenda_id");
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
        $this->db->trans_start();  //DB Transaction Handle START
        $time=time();
        $agenda_id=$this->input->post('agenda_id');
        $sales_items=$this->input->post('sitems');
        foreach($sales_items as $territory_id=>$item)
        {
            $data=$item;
            $data['agenda_id']=$agenda_id;
            $data['date_updated']=$time;
            $data['user_updated'] = $user->user_id;
            $sdata['territory_id']=$territory_id;
            $this->db->where('agenda_id', $data['agenda_id']);
            $this->db->where('territory_id', $sdata['territory_id']);
            $this->db->where('revision', 1);
            $this->db->update($this->config->item('table_mm_agenda_zi_sales'), $data);
        }
        $collection_items=$this->input->post('citems');
        foreach($collection_items as $territory_id=>$item)
        {
            $data=$item;
            $data['agenda_id']=$agenda_id;
            $data['date_updated']=$time;
            $data['user_updated'] = $user->user_id;
            $cdata['territory_id']=$territory_id;
            $this->db->where('agenda_id', $data['agenda_id']);
            $this->db->where('territory_id', $cdata['territory_id']);
            $this->db->where('revision', 1);
            $this->db->update($this->config->item('table_mm_agenda_zi_collection'), $data);
        }
        $status_data['status_complete']=$this->input->post('status_complete');
        if(($status_data['status_complete']))
        {
            Query_helper::update($this->config->item('table_mm_agenda_zi'),$status_data,array("agenda_id = ".$agenda_id,"zone_id = ".$zone_id));
        }
        $this->db->trans_complete();   //DB Transaction Handle END
        if ($this->db->trans_status() === TRUE)
        {
            $this->message=$this->lang->line("MSG_SAVED_SUCCESS");
            $this->system_details($agenda_id);
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
        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }
    public function get_zone()
    {
        if(isset($this->permissions['edit'])&&($this->permissions['edit']==1))
        {
            $zone_id=$this->input->post('zone_id');
            $id=$this->input->post('agenda_id');
            $division_id=$this->input->post('division_id');
            $this->db->select('az.*');
            $this->db->select('ah.purpose');
            $this->db->select('agenda_di.date date_di');
            $this->db->from($this->config->item('table_mm_agenda_zi').' az');
            $this->db->join($this->config->item('table_mm_agenda_hom').' ah','ah.id = az.agenda_id','LEFT');
            $this->db->join($this->config->item('table_mm_agenda_di').' agenda_di','agenda_di.agenda_id=az.agenda_id','INNER');
            $this->db->where('az.zone_id',$zone_id);
            $this->db->where('az.agenda_id',$id);
            $data['item']=$this->db->get()->row_array();
            if(is_null($data['item']['date']))
            {
                $data['item']['date'] ='';
            }
            $this->db->from($this->config->item('table_mm_agenda_di_sales').' dist');
            $this->db->select('dist.*');
            $this->db->select('zones.name zone_name');
            $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dist.zone_id','INNER');
            $this->db->where('dist.agenda_id',$id);
            $this->db->where('dist.zone_id',$zone_id);
            $this->db->where('dist.revision', 1);
            $data['s_items_di']=$this->db->get()->result_array();
            $data['di_meeting_status']=Query_helper::get_info($this->config->item('table_mm_agenda_di'),'*',array('agenda_id ='.$id,'division_id ='.$division_id),1);
            $data['sales_result']=Query_helper::get_info($this->config->item('table_mm_agenda_zi_sales'),array('*'),array('agenda_id ='.$id,'zone_id ='.$zone_id));
            if($data['sales_result'])
            {
                $this->db->from($this->config->item('table_mm_agenda_zi_sales').' zist');
                $this->db->select('zist.*');
                $this->db->select('territories.name territory_name');
                $this->db->join($this->config->item('table_setup_location_territories').' territories','territories.id = zist.territory_id','INNER');
                $this->db->where('zist.agenda_id',$id);
                $this->db->where('zist.zone_id',$zone_id);
                $this->db->where('zist.revision', 1);
                $data['sales_items']=$this->db->get()->result_array();

            }
            else
            {
                $results=Query_helper::get_info($this->config->item('table_setup_location_territories'),'*',array('zone_id ='.$zone_id));
                foreach($results as &$result)
                {
                    $sales_item['agenda_id']=$id;
                    $sales_item['territory_id']=$result['id'];
                    $sales_item['territory_name']=$result['name'];
                    $sales_item['budget_total']='';
                    $sales_item['achievement_total']='';
                    $sales_item['target_last_month']='';
                    $sales_item['achievement_last_month']='';
                    $sales_item['target_current_month']='';
                    $sales_item['achievement_current_month']='';
                    $sales_item['target_next_month']='';
                    $sales_item['remarks_before_meeting']='';
                    if(($data['item']['status_forward']==$this->config->item('system_status_forward')))
                    {
                        $sales_item['target_next_month_im']='';
                        $sales_item['remarks_in_meeting']='';
                    }
                    if(($data['di_meeting_status']['status_complete']==$this->config->item('system_status_complete')))
                    {
                        $sales_item['target_next_month_for_ti']='';
                    }
                    $data['sales_items'][]=$sales_item;
                }
            }
            $this->db->from($this->config->item('table_mm_agenda_di_collection').' dict');
            $this->db->select('dict.*');
            $this->db->select('zones.name zone_name');
            $this->db->join($this->config->item('table_setup_location_zones').' zones','zones.id = dict.zone_id','INNER');
            $this->db->where('dict.agenda_id',$id);
            $this->db->where('dict.zone_id',$zone_id);
            $this->db->where('dict.revision', 1);
            $data['c_items_di']=$this->db->get()->result_array();
            $data['collection_result']=Query_helper::get_info($this->config->item('table_mm_agenda_zi_collection'),array('*'),array('agenda_id ='.$id,'zone_id ='.$zone_id));
            if($data['collection_result'])
            {
                $this->db->from($this->config->item('table_mm_agenda_zi_collection').' zict');
                $this->db->select('zict.*');
                $this->db->select('territories.name territory_name');
                $this->db->join($this->config->item('table_setup_location_territories').' territories','territories.id = zict.territory_id','INNER');
                $this->db->where('zict.agenda_id',$id);
                $this->db->where('zict.zone_id',$zone_id);
                $this->db->where('zict.revision', 1);
                $data['collection_items']=$this->db->get()->result_array();
            }else
            {
                $results=Query_helper::get_info($this->config->item('table_setup_location_territories'),'*',array('zone_id ='.$zone_id));
                foreach($results as &$result)
                {
                    $collection_item['agenda_id']=$id;
                    $collection_item['territory_id']=$result['id'];
                    $collection_item['territory_name']=$result['name'];
                    $collection_item['budget_total']='';
                    $collection_item['achievement_total']='';
                    $collection_item['target_last_month']='';
                    $collection_item['achievement_last_month']='';
                    $collection_item['target_current_month']='';
                    $collection_item['achievement_current_month']='';
                    $collection_item['target_next_month']='';
                    $collection_item['remarks_before_meeting']='';
                    if(($data['item']['status_forward']==$this->config->item('system_status_forward')))
                    {
                        $collection_item['target_next_month_im']='';
                        $collection_item['remarks_in_meeting']='';
                    }
                    if(($data['di_meeting_status']['status_complete']==$this->config->item('system_status_complete')))
                    {
                        $collection_item['target_next_month_for_ti']='';
                    }
                    $data['collection_items'][]=$collection_item;
                }
            }
            $data['agenda_id']=$id;
            $data['division_id']=$this->input->post('division_id');
            $html_container_id='#target_container';
            if(($data['item']['status_forward']==$this->config->item('system_status_forward')) && !($data['item']['status_complete']==$this->config->item('system_status_complete')))
            {
                $ajax['system_content'][]=array("id"=>$html_container_id,"html"=>$this->load->view("mm_agenda_zi/get_zone_im",$data,true));
            }
            else if(($data['item']['status_forward']==$this->config->item('system_status_forward')) && ($data['item']['status_complete']==$this->config->item('system_status_complete')))
            {
                $ajax['system_content'][]=array("id"=>$html_container_id,"html"=>$this->load->view("mm_agenda_zi/get_zone_details",$data,true));
            }else
            {
                $ajax['system_content'][]=array("id"=>$html_container_id,"html"=>$this->load->view("mm_agenda_zi/get_zone_bm",$data,true));
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
    private function get_details($id)
    {
        $data['agenda_id']=$id;
        $data['title']="Agenda";
        $ajax['status']=true;
        $results=$this->locations;
        $data['div_id']=$results['division_id'];
        $data['divisions']=Query_helper::get_info($this->config->item('table_setup_location_divisions'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
        $data['zones']=Query_helper::get_info($this->config->item('table_setup_location_zones'),array('id value','name text'),array('status ="'.$this->config->item('system_status_active').'"'));
        $ajax['system_content'][]=array("id"=>"#system_content","html"=>$this->load->view($this->controller_url."/details",$data,true));
        $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$id);
        $this->jsonReturn($ajax);
    }
    public function get_zone_by_division_id()
    {
        $agenda_id=$this->input->post('agenda_id');
        $division_id=$this->input->post('division_id');
        $this->db->from($this->config->item('table_setup_location_zones'));
        $this->db->select('*');
        $this->db->where('division_id',$division_id);
        $data['zones']=$this->db->get()->result_array();
        $ajax['status']=true;
        $html_container_id='#zone_container';
        $ajax['system_content'][]=array("id"=>$html_container_id,"html"=>$this->load->view("mm_agenda_zi/get_zone_by_division_id",$data,true));
        if($this->message)
        {
            $ajax['system_message']=$this->message;
        }
        $ajax['system_page_url']=site_url($this->controller_url.'/index/details/'.$agenda_id);
        $this->jsonReturn($ajax);
    }
}