<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package oswFrame - Tools
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/*
 * TOOL - Start
 */

$log_dirs=osW_Tool_LogClear::getInstance()->listdir(root_path.osW_Tool::getInstance()->getFrameConfig('debug_path', 'string'));

$error=[];
$messages=[];

if (osW_Tool::getInstance()->getDoAction()=='doclear') {
	$i=0;

	if ((isset($_POST['dir']))||(count($cache_dirs)>0)) {
		foreach ($cache_dirs as $dir) {
			if ((isset($_POST['dir'][$dir]))&&($_POST['dir'][$dir]==1)) {
				osW_Tool::getInstance()->delTree(root_path.$dir);
			}
		}
	}

	if ((isset($_POST['dir']))||(count($log_dirs)>0)) {
		foreach ($log_dirs as $dir) {
			if ((isset($_POST['dir'][$dir]))&&($_POST['dir'][$dir]==1)) {
				$i++;
				osW_Tool::getInstance()->delTree(root_path.osW_Tool::getInstance()->getFrameConfig('debug_path', 'string').$dir);
			}
		}
	}

	if (count($error)==0) {
		if ($i==0) {
			$messages['info'][]='No directories were cleared.';
		} elseif ($i==1) {
			$messages['success'][]=$i.' directory was cleared.';
		} else {
			$messages['success'][]=$i.' directories were cleared.';
		}
		osW_Tool_Session::getInstance()->set('messages', $messages);
		osW_Tool::getInstance()->_direct('index.php?session='.osW_Tool_Session::getInstance()->getId().'&action=start');
	}
}

?>

<div class="container">

	<div class="btn-group" role="group" aria-label="...">
		<button id="select_all" type="button" class="btn btn-default">Select all</button>
		<button id="select_none" type="button" class="btn btn-default">Select none</button>
		<button id="select_invert" type="button" class="btn btn-default">Invert selection</button>
	</div>

	<br/><br/>

	<p>Please select your directories you want to clear and confirm your input by pressing the button "Clear selected directories from log".</p>

	<hr/>

	<?php

	osW_Tool_Template::getInstance()->outputB3Alerts();

	?>

	<form id="oswtools_logclear" method="post" action="index.php?session=<?php echo osW_Tool_Session::getInstance()->getId() ?>&action=start">

		<table id="logclear_main" class="table table-striped table-bordered">
			<thead>
			<tr>
				<th style="width:50px;" class="text-center">Clear</th>
				<th>Directory</th>
			</tr>
			</thead>
			<tbody>
			<?php if (count($log_dirs)>0): ?><?php $i=0;
				foreach ($log_dirs as $dir):$i++; ?>
					<tr>
						<td class="text-center"><input type="checkbox" name="dir[<?php echo $dir ?>]" value="1"/></td>
						<td><?php echo $dir ?></td>
					</tr>
				<?php endforeach ?><?php endif ?>
			</tbody>
		</table>


		<?php if (count($log_dirs)>0): ?>

			<hr/>

			<div class="form-group ">
				<button type="button" class="btn btn-primary btn-block" onclick="$('#oswtools_logclear').submit()" form="oswtools_logclear">Clear selected directories from log</button>
			</div>

			<input type="hidden" name="doaction" value="doclear"/>
		<?php endif ?>
	</form>

</div>
