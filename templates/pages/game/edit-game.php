<?php
// Ugly function inside rendered template, have to fix it with a real fom editor
function isChecked($content, $property, $value) {
  if (isset($content[$property]) && !empty($content[$property])) {
	$checked =  $content[$property] === $value ? 'checked' : '';
	return $checked;
  }
}
function isSelected($content, $property, $value) {
  if (isset($content[$property]) && !empty($content[$property])) {
	$selected = $content[$property] === $value ? 'selected' : '';
	return $selected;
  }
}
include_once(ROOT.'/templates/pages/game/_game-edit-form.html');