<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$action_data["action_save"]='#save_form';
$action_data["action_clear"]='#save_form';
$CI->load->view("action_buttons",$action_data);
?>
<input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $agenda_id; ?>" />
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
                <a class="external" data-toggle="collapse" data-target="#collapse4" href="#">
                    Select division</a>
            </h4>
        </div>
        <div id="collapse4" class="panel-collapse collapse">
            <div class="row show-grid">
                <div class="col-xs-12" id="system_jqx_containers">
                    <div style="" class="row show-grid">
                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DIVISION_NAME');?><span style="color:#FF0000">*</span></label>
                        </div>
                        <div class="col-sm-4 col-xs-8">
                            <select id="division_id" name="division_id" class="form-control">

                                <option value=""><?php echo $this->lang->line('SELECT');?></option>
                                <?php
                                foreach($divisions as $division)
                                {?>
                                    <option value="<?php echo $division['value']?>"><?php echo $division['text'];?></option>
                                <?php
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div style="<?php if($div_id==0){echo 'display:none';} ?>" class="row show-grid" id="target_container">

</div>

</div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">

    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(".datepicker").datepicker({dateFormat : display_date_format});
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(document).on("change","#division_id",function()
        {
            var division_id=$('#division_id').val();
            var agenda_id=$('#agenda_id').val();
            if(division_id>0)
            {
                $('#target_container').show();
                $.ajax({
                    url: base_url+"mm_agenda_di/get_zone/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{division_id:division_id, agenda_id:agenda_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
            else
            {
                $('#target_container').hide();
            }
        });
    });
</script>
