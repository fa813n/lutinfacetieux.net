<?php
namespace Toolbox\Renderer;

class RenderForm {
  
  private string $formCode = '';
  
  public function addInput(string $type, string $name, array $attributes = [], ?string $label= null, ?string $value= null )/*:self*/ {
    $id = $attributes['id'] ?? $name;
    $valueString = $value ? ' value="'.$value.'"' : '';
    $inputString = '<input type="'.$type.'" name="'.$name.'"'.$valueString.' id="'.$id.'"';
    foreach ($attributes as $attribute => $val) {
      if ($val === true) {
        $inputString .= ' '.$attribute;
      }
      else if ($val === false){
        $inputString .= '';
      }
      else {
        $inputString .= ' '.$attribute.'="'.$val.'"';
      }
    }
    $inputString .= '>';
    if ($label) {
      $inputString .= '<legend for="'.$id.'">'.$label.'</legend>';
    }
    $this->formCode .= $inputString;
    //return $this;
    return $inputString;
  }
  public function setFieldset($content, $legend){
    $str = '<fieldset><legend>'.$legend.'<legend>'.$content.'<fieldset>';
    $this->formCode .= $str;
    //return $this;
    return $str;
  }
  public function setForm($content, $method, $action){
    $str = '<form method="'.$method.'" action="'.$action.'">'.$content.'</form>';
    $this->formCode .= $str;
    //return $this;
    return $str;
  }
  public function addFieldset($content, $legend) {
    
  }
  /**
   * 
   * @values array associatif valeur => legend
   */
  public function addRadio(string $name, array $radiovalues, ?string $value = null):self {
    foreach ($radiovalues as $radioValue => $label) {
      //$legend = 
      $id = $name.'-'.$radioValue;
      // $checked = $radioValue === $value ? 'checked' : '';
      $checked = $radioValue === $value ? true : false;
      $this->addInput('radio', $name, ['id' => $id, 'checked' => $checked], $value, $label);
    }
    return $this;
  }
  public function addSelect() {
    //to do
  }
  public function startForm(string $method, string $action) {
    $this->formCode .= '<form method="'.$method.'" action="'.$action.'">';
  }
  public function displayForm() {
    $this->formCode .= '</form>';
    return $this->formCode;
  }
}
