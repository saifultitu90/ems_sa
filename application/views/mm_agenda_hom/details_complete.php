<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$CI->load->view("action_buttons",$action_data);
?>
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
                         Agenda Information</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="row show-grid">

                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_AGENDA');?><span>:</span></label>
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label"><?php echo System_helper::display_date($item['date']);?></label>
                        </div>
                    </div>
                    <div class="row show-grid">
                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_PURPOSE');?><span>:</span></label>
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label"><?php echo $item['purpose'];?></label>
                        </div>
                    </div>
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
                                        <th>Next Month Target Before Meeting</th>
                                        <th>Next Month Target In Meeting</th>
                                        <th>Remarks Before Meeting</th>
                                        <th>Remarks IN Meeting</th>
                                    </tr>
                                    </thead>
                                    <?php foreach($sales_items as $sales_item){?>
                                        <tbody>
                                        <tr>
                                            <td><?php echo $sales_item['division_name'];?></td>
                                            <input type="hidden" name="sales_items[<?php echo $sales_item['id_division']?>][id_division]" value="<?php echo $sales_item['id_division'];?>"></td>
                                            <td><?php echo $sales_item['budget_total'];?></td>
                                            <td><?php echo $sales_item['achievement_total'];?></td>
                                            <td><?php echo $sales_item['target_current_month'];?></td>
                                            <td><?php echo $sales_item['achievement_current_month'];?></td>
                                            <td><?php echo $sales_item['target_next_month'];?></td>
                                            <td><?php echo $sales_item['target_next_month_im'];?></td>
                                            <td><?php echo $sales_item['remarks_before_meeting'];?></td>
                                            <td><?php echo $sales_item['remarks_in_meeting'];?></td>
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
                                        <th>Next Month Target Before Meeting</th>
                                        <th>Next Month Target In Meeting</th>
                                        <th>Remarks Before Meeting</th>
                                        <th>Remarks IN Meeting</th>
                                    </tr>
                                    </thead>
                                    <?php foreach($collection_items as $collection_item){?>
                                        <tbody>
                                        <tr>
                                            <td><?php echo $collection_item['division_name'];?></td>
                                            <input type="hidden" name="collection_items[<?php echo $collection_item['id_division'];?>][id_division]" value="<?php echo $collection_item['id_division'];?>">
                                            <td><?php echo $collection_item['budget_total'];?></td>
                                            <td><?php echo $collection_item['achievement_total'];?></td>
                                            <td><?php echo $collection_item['target_current_month'];?></td>
                                            <td><?php echo $collection_item['achievement_current_month'];?></td>
                                            <td><?php echo $collection_item['target_next_month'];?></td>
                                            <td><?php echo $collection_item['target_next_month_im'];?></td>
                                            <td><?php echo $collection_item['remarks_before_meeting'];?></td>
                                            <td><?php echo $collection_item['remarks_in_meeting'];?></td>
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
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(".datepicker").datepicker({dateFormat : display_date_format});
    });
</script>
