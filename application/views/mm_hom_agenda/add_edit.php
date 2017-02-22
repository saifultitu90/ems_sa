<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$action_data["action_save"]='#save_form';
$action_data["action_clear"]='#save_form';
$CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $item['id']; ?>" />
    <input type="hidden" id="system_save_new_status" name="system_save_new_status" value="0" />
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle external" data-toggle="collapse" data-target="#collapse1" href="#">
                            Create Agenda</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <?php if(isset($meeting_complete)&& ($meeting_complete['meeting_status']==$this->config->item('system_status_hom_approval_approved'))){?>
                        <div class="row show-grid">
                            <div class="col-xs-4">
                                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_AGENDA');?></label>
                            </div>
                            <div class="col-sm-4 col-xs-8">
                                <?php echo System_helper::display_date($item['date_hom_agenda']);?>
                            </div>
                        </div>
                    <?php } else{?>
                        <div class="row show-grid">
                            <div class="col-xs-4">
                                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_AGENDA');?><span style="color:#FF0000">*</span></label>
                            </div>
                            <div class="col-sm-4 col-xs-8">
                                <input type="text" name="item[date_hom_agenda]" id="date_stock_in" class="form-control datepicker" value="<?php echo System_helper::display_date($item['date_hom_agenda']);?>"/>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if(isset($meeting_complete) && ($meeting_complete['meeting_status']==$this->config->item('system_status_hom_approval_approved'))){?>
                        <div class="row show-grid">
                            <div class="col-xs-4">
                                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_PURPOSE');?></label>
                            </div>
                            <div class="col-sm-4 col-xs-8">
                                <?php echo $item['purpose'];?>
                            </div>
                        </div>
                    <?php } else{?>
                        <div class="row show-grid">
                            <div class="col-xs-4">
                                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_PURPOSE');?><span style="color:#FF0000">*</span></label>
                            </div>
                            <div class="col-sm-4 col-xs-8">
                                <input type="text" name="item[purpose]" id="name" class="form-control" value="<?php echo $item['purpose'];?>"/>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="external" data-toggle="collapse" data-target="#collapse2" href="#">
                            Sales</a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="row show-grid">
                        <div class="col-xs-12" id="system_jqx_containers">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Total Budget</th>
                                        <th>Total Achievement</th>
                                        <th>Current Month Target</th>
                                        <th>Current Month Achievement</th>
                                        <th>Next Month Target</th>
                                        <th>Remarks Before Meeting</th>
                                    </tr>
                                    </thead>
                                    <?php foreach($sitems as $s_item){?>
                                        <tbody>
                                        <tr>
                                            <?php if(isset($meeting_complete) && ($meeting_complete['meeting_status']==$this->config->item('system_status_hom_approval_approved'))){?>
                                                <td><?php echo $s_item['division_name'];?></td>
                                                <input type="hidden" name="sales_division_id[]" value="<?php echo $s_item['division_id'];?>"></td>
                                                <td><?php echo $s_item['total_budget'];?></td>
                                                <td><?php echo $s_item['total_achievement'];?></td>
                                                <td><?php echo $s_item['current_month_target'];?></td>
                                                <td><?php echo $s_item['current_month_achievement'];?></td>
                                                <td><?php echo $s_item['next_month_target'];?></td>
                                                <td><?php echo $s_item['remarks_before_meeting'];?></td>
                                            <?php } else{?>
                                                <td><?php echo $s_item['division_name'];?></td>
                                                <input type="hidden" name="sitems[<?php echo $s_item['division_id']?>][division_id]" value="<?php echo $s_item['division_id'];?>"></td>
                                                <td><input type="text" name="sitems[<?php echo $s_item['division_id']?>][total_budget]" value="<?php echo $s_item['total_budget'];?>">
                                                <td><input type="text" name="sitems[<?php echo $s_item['division_id']?>][total_achievement]" value="<?php echo $s_item['total_achievement'];?>"></td>
                                                <td><input type="text" name="sitems[<?php echo $s_item['division_id']?>][current_month_target]" value="<?php echo $s_item['current_month_target'];?>"></td>
                                                <td><input type="text" name="sitems[<?php echo $s_item['division_id']?>][current_month_achievement]" value="<?php echo $s_item['current_month_achievement'];?>"></td>
                                                <td><input type="text" name="sitems[<?php echo $s_item['division_id']?>][next_month_target]" value="<?php echo $s_item['next_month_target'];?>"></td>
                                                <td><input type="text" name="sitems[<?php echo $s_item['division_id']?>][remarks_before_meeting]" value="<?php echo $s_item['remarks_before_meeting'];?>"></td>
                                            <?php } ?>
                                        </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="external" data-toggle="collapse" data-target="#collapse3" href="#">
                            Collection</a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="row show-grid">
                        <div class="col-xs-12" id="system_jqx_containers">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Total Budget</th>
                                        <th>Total Achievement</th>
                                        <th>Current Month Target</th>
                                        <th>Current Month Achievement</th>
                                        <th>Next Month Target</th>
                                        <th>Remarks Before Meeting</th>
                                    </tr>
                                    </thead>
                                    <?php foreach($citems as $c_item){?>
                                        <tbody>
                                        <tr>
                                            <?php if(isset($meeting_complete) && ($meeting_complete['meeting_status']==$this->config->item('system_status_hom_approval_approved'))){?>
                                                <td><?php echo $c_item['division_name'];?></td>
                                                <input type="hidden" name="collection_division_id[]" value="<?php echo $c_item['division_id'];?>">
                                                <td><?php echo $c_item['total_budget'];?></td>
                                                <td><?php echo $c_item['total_achievement'];?></td>
                                                <td><?php echo $c_item['current_month_target'];?></td>
                                                <td><?php echo $c_item['current_month_achievement'];?></td>
                                                <td><?php echo $c_item['next_month_target'];?></td>
                                                <td><?php echo $c_item['remarks_before_meeting'];?></td>
                                            <?php } else{?>
                                                <td><?php echo $c_item['division_name'];?></td>
                                                <input type="hidden" name="citems[<?php echo $c_item['division_id'];?>][division_id]" value="<?php echo $c_item['division_id'];?>">
                                                <td><input type="text" name="citems[<?php echo $c_item['division_id'];?>][total_budget]" value="<?php echo $c_item['total_budget'];?>"></td>
                                                <td><input type="text" name="citems[<?php echo $c_item['division_id'];?>][total_achievement]" value="<?php echo $c_item['total_achievement'];?>"></td>
                                                <td><input type="text" name="citems[<?php echo $c_item['division_id'];?>][current_month_target]" value="<?php echo $c_item['current_month_target'];?>"></td>
                                                <td><input type="text" name="citems[<?php echo $c_item['division_id'];?>][current_month_achievement]" value="<?php echo $c_item['current_month_achievement'];?>"></td>
                                                <td><input type="text" name="citems[<?php echo $c_item['division_id'];?>][next_month_target]" value="<?php echo $c_item['next_month_target'];?>"></td>
                                                <td><input type="text" name="citems[<?php echo $c_item['division_id'];?>][remarks_before_meeting]" value="<?php echo $c_item['remarks_before_meeting'];?>"></td>
                                            <?php } ?>
                                        </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</form>
<script type="text/javascript">

    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(".datepicker").datepicker({dateFormat : display_date_format});
        $(".dob").datepicker({dateFormat : display_date_format,changeMonth: true,changeYear: true,yearRange: "-100:+0"});
        $(":file").filestyle({input: false,buttonText: "<?php echo $CI->lang->line('UPLOAD');?>", buttonName: "btn-danger"});

    });
</script>
