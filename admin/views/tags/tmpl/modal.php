<?php
/*------------------------------------------------------------------------

# TZ Pinboard Extension

# ------------------------------------------------------------------------

# author    TuNguyenTemPlaza

# copyright Copyright (C) 2013 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/
 
// no direct access
defined('_JEXEC') or die;

if (JFactory::getApplication()->isSite()) {
	JRequest::checkToken('get') or die(JText::_('JINVALID_TOKEN'));
}
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('formbehavior.chosen', 'select');

$function	= JRequest::getCmd('function', 'jSelectTag');
$listOrder	= $this->order;
$listDirn	= $this->order_Dir;
?>

<form action="<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=tags&layout=modal&tmpl=component&function='.$function.'&'.JSession::getFormToken().'=1');?>"
      method="post" name="adminForm" id="adminForm" class="form-inline">
	<fieldset class="filter clearfix">
        <div class="btn-toolbar">
			<div class="btn-group pull-left">
				<label for="filter_search">
					<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>
				</label>
				<input type="text" name="filter_search" id="filter_search"
                       value="<?php echo $this -> state -> filter_search;?>"
                       size="30" title="<?php echo JText::_('COM_TZ_PINBOARD_TAGS_SEARCH_DESC'); ?>" />
			</div>
			<div class="btn-group pull-left">
				<button type="submit" class="btn hasTooltip"
                        data-placement="bottom" data-original-title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>">
					<i class="icon-search"></i></button>
				<button type="button" class="btn hasTooltip" data-placement="bottom"
                        data-original-title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"
                        onclick="document.id('filter_search').value='';this.form.submit();">
					<i class="icon-remove"></i></button>
			</div>
            <div class="btn-group pull-right">
                <select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->filter_state, true);?>
			</select>
            </div>
			<div class="clearfix"></div>
		</div>
        <hr class="hr-condensed" />
	</fieldset>

	<table class="table table-striped table-condensed">
		<thead>
			<tr>
                <th width="10">#</th>
                <th width="10" class="title">
                    <input type="checkbox" name="toggle"
                           value=""
                           onclick="checkAll(<?php echo count($this -> lists);?>);">
                </th>
                <th class="title">
                    <?php echo JHtml::_('grid.sort','Name','name',$this -> order_Dir,$this -> order);?>
                </th>
                <th nowrap="nowrap" width="1%">
                    <?php echo JHtml::_('grid.sort','ID','id',$this -> order_Dir,$this -> order);?>
                </th>
            </tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<?php if($this -> lists):?>
        <tbody>
            <?php $i=0;?>
            <?php foreach($this -> lists as $row):?>
                <tr class="row<?php echo $i%2;?>">
                    <td><?php echo $i+1;?></td>
                    <td>
                        <input type="checkbox" id="cb<?php echo $i;?>"
                               name="cid[]"
                               value="<?php echo $row -> id;?>"
                               onclick="isChecked(this.checked);">
                    </td>
                    <td>
                        <a style="cursor: pointer;" class="pointer hasTooltip"
                           data-placement="bottom"
                           data-original-title="<?php echo $row -> name;?>"
                           onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $row->id; ?>', '<?php echo $this->escape(addslashes($row->name)); ?>', '', null, 'index.php?option=com_tz_pinboard&view=tags&id=<?php echo $row -> id;?>');"
                        >
                            <?php echo $row -> name;?>
                        </a>
                    </td>
                    <td align="center"><?php echo $row -> id;?></td>
                </tr>
            <?php $i++;?>
            <?php endforeach;?>
        </tbody>
        <?php endif;?>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>