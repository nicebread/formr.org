<?php

// notes are rendered at full width
class NoteIframe_Item extends Note_Item {

	public $type = 'note_iframe';
	public $mysql_field = null;
	public $input_attributes = array('type' => 'hidden', "value" => 1);
	public $save_in_results_table = false;

	public function needsDynamicLabel($survey = null) {
		$ocpu_vars = $survey->getUserDataInRun($this->label, $survey->name);
		$ocpu_session = opencpu_knit_iframe($this->label, $ocpu_vars, true, $survey->name);
		if ($ocpu_session && !$ocpu_session->hasError()) {
			$iframesrc = $ocpu_session->getFiles("knit.html")['knit.html'];
			$this->label_parsed = ''.
				'<div class="rmarkdown_iframe">
					<iframe src="' . $iframesrc . '">
					  <p>Your browser does not support iframes.</p>
					</iframe>
				</div>';
		}

		return false;
	}

}
