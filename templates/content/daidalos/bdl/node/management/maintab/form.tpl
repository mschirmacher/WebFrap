<?php 
$management = $VAR->node;
/*@var $management BdlManagement */
$formId = 'wgt-form-bdl_management-'.$management->getName();
$idPrefix = 'management-'.$management->getName();

$iconDel = Wgt::icon( 'control/delete.png', 'xsmall', 'Delete' );
$iconAdd = Wgt::icon( 'control/add.png', 'xsmall', 'Add' );

$labels       = $management->getLabels();
$descriptions = $management->getDescriptions();
$docus        = $management->getDocus();

$langs = $this->model->getLanguages();

$langCode = array( '{"i":"0","v":"Select a language"}' );

if( $langs )
{
  foreach( $langs as $lang )
  {
    $langCode[] = '{"i":"'.$lang['id'].'","v":'.json_encode($lang['value']).'}';
  }
}

$langCode = implode( ','.NL, $langCode  );

?>

<var id="select_src-management-lang" >
[
<?php echo $langCode; ?>
]
</var>

<form 
  id="<?php echo $formId ?>"
  action="ajax.php?c=Daidalos.BdlNode_Management.update&amp;key=<?php echo $VAR->key ?>&amp;bdl_file=<?php echo $VAR->bdlFile ?>"
  method="put"
></form>

<div id="<?php echo $this->tabId ?>" class="wcm wcm_ui_tab" >
  <div class="wgt_tab_body" >
    <!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->


  <!-- tab name:default -->
  <div
    class="wgt_tab <?php echo $this->tabId ?>"
    id="<?php echo $this->tabId ?>-tab-base_data"
    title="Base Data"
    
     >


<fieldset class="wgt-space bw61" >
  <legend>Management Data</legend>
  
  <div class="left bw3" >
    <?php 
    echo WgtForm::input
    ( 
      'Name', 
      'management-name', 
      $management->getName(), 
      array
      (
        'name'=>'management[name]'
      ), $formId 
    );  
    
    echo WgtForm::autocomplete
    ( 
      'Src', 
      'management-src', 
      $management->getSrc(), 
      'ajax.php?c=Bdl.Entity_Service.autocomplete',
      array
      (
        'name' => 'management[src]'
      ), 
      $formId 
    ); 
    
    echo WgtForm::autocomplete
    ( 
      'Module', 
      'management-module', 
      $management->getModule(), 
      'ajax.php?c=Bdl.Module_Service.autocomplete',
      array
      (
        'name' => 'management[module]'
      ), 
      $formId 
    ); 
    

    ?>
  </div>
  
  <div class="right bw3" >
    
  </div>
  
</fieldset>

<fieldset class="wgt-space bw61" >
  <legend>Labels</legend>
  
  <div id="wgt-i18n-list-management-label" class="wcm wcm_widget_i18n-input-list bw6" >

  <div class="left bw3" >
    <?php 
      echo WgtForm::input
      ( 
        'Label', 
        'management-new-label-text', 
        '',
        array
        ( 
          'name'  => 'label[text]',
          'class' => 'medium wgte-text'
        )  
      ); 
    ?>
    
    <?php 
      echo WgtForm::decorateInput
      ( 
        'Lang', 
        'wgt-select-management-new-label-lang', 
        <<<HTML
<select 
      id="wgt-select-management-new-label-lang" 
      name="label[lang]" 
      data_source="select_src-management-lang"
      class="wcm wcm_widget_selectbox wgte-lang"
        >
        <option>Select a language</option>
    </select>
HTML
      ); 
    ?>

    <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
  </div>
  
  <div class="right bw3" >
    <ul class="wgte-list"  >
    <?php 
      foreach( $labels as $lang => $label )
      {
        echo '<li class="lang-'.$lang.'" >'. WgtForm::input
        ( 
          'Lang '.Wgt::icon( 'flags/'.$lang.'.png', 'xsmall', array(), '' ), 
          'management-label-'.$lang, 
          $label, array
          (
            'name'  => 'management[label]['.$lang.']',
            'class' => 'medium lang-'.$lang
          ), 
          $formId,
          '<button class="wgt-button wgta-drop" wgt_lang="'.$lang.'" >'.$iconDel.'</button>'
        ).'</li>';
      }
    ?>
    </ul>
  </div>
  
  <var id="wgt-i18n-list-management-label-cfg-i18n-input-list" >
  {
    "key":"management-label",
    "inp_prefix":"management[label]",
    "form_id":"<?php echo $formId; ?>"
  }
  </var>
  
  </div>
  
</fieldset>

    <fieldset class="wgt-space bw61" >
      <legend>Concepts</legend>
    
      <div class="left bw3" >
    
      </div>
      
      <div class="right bw3" >
    
      </div>
      
    </fieldset>
    
    <div class="wgt-clear small" ></div>



    </div>
    

    
    <!-- tab name:access -->
    <div
      class="wgt_tab <?php echo $this->tabId ?>"
      id="<?php echo $this->tabId ?>-tab-access"
      title="Access"
      
       >

      <div class="wgt-clear small" ></div>
    
    </div><!-- END tab name:access -->
    
    <!-- tab name:ui -->
    <div
      class="wgt_tab <?php echo $this->tabId ?>"
      id="<?php echo $this->tabId ?>-tab-ui"
      title="UI"
       >
       
       <div class="wgt-panel title" >
           <h2>UI</h2>
       </div>

      <div class="wgt-clear small" ></div>
    
    </div><!-- END tab name:ui -->
    
    <!-- tab name:ui -->
    <div
      class="wgt_tab <?php echo $this->tabId ?>"
      id="<?php echo $this->tabId ?>-tab-description"
      title="Description"
       >
       
<div id="wgt-tab-<?php echo $idPrefix ?>_desc" class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border wgt-corner-top bw62"  >
  <div id="wgt-tab-<?php echo $idPrefix ?>_desc-head" class="wgt_tab_head wgt-corner-top" >

    <div class="wgt-container-controls">
      <div class="wgt-container-buttons" >
        <h2 style="width:120px;float:left;text-align:left;" >Description</h2>
      </div>
      <div class="tab_outer_container">
        <div class="tab_scroll" >
          <div class="tab_container"></div>
        </div>
     </div>
    </div>
  </div>
  <div id="wgt-tab-<?php echo $idPrefix ?>_desc-body" class="wgt_tab_body" >
    
    <?php foreach( $descriptions as $lang => $description ){ ?>
    <div id="wgt-tab-<?php echo $idPrefix ?>-desc-<?php echo $lang ?>"  title="<?php echo $lang ?>" wgt_icon="xsmall/flags/<?php echo $lang ?>.png"  class="wgt_tab wgt-tab-<?php echo $idPrefix ?>_desc">
      <fieldset id="wgt-fieldset-<?php echo $idPrefix ?>-desc-<?php echo $lang ?>"  class="wgt-space bw6 lang-<?php echo $lang ?>"  >
        <legend>Description <?php echo $lang ?></legend>
        
        <?php echo WgtForm::wysiwyg
        ( 
          'Description', 
          'management-description-'.$lang, 
          $description, 
          array
          ( 
            'name' => 'management[description]['.$lang.']',
            'style' => 'width:740px;'
          ), 
          $formId,
          null,
          true
        ); 
        ?>
      </fieldset>
    </div>
    <?php } ?>

  </div>
  
  <div class="wgt-panel" >
    <select 
      id="wgt-select-management-description-new-lang" 
      name="label[lang]" 
      data_source="select_src-management-lang"
      class="wcm wcm_widget_selectbox wgte-lang" >
      <option>Select a language</option>
    </select>
    
    <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
  </div>
  <div class="wgt-clear xxsmall" ></div>
  
  <var id="wgt-tab-<?php echo $idPrefix ?>_desc-cfg-i18n-input-tab" >
  {
    "key":"management-description",
    "inp_prefix":"management[description]",
    "form_id":"<?php echo $formId; ?>",
    "tab_id":"wgt-tab-<?php echo $idPrefix ?>_desc"
  }
  </var>
  
</div>

      <div class="wgt-clear small" ></div>
    
    </div><!-- END tab name:description -->
    
    <!-- tab name:docu -->
    <div
      class="wgt_tab <?php echo $this->tabId ?>"
      id="<?php echo $this->tabId ?>-tab-docu"
      title="Docu"
      
       >
    
        <div id="wgt-tab-<?php echo $idPrefix ?>_docu" class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border wgt-corner-top bw62"  >
          <div id="wgt-tab-<?php echo $idPrefix ?>_docu-head" class="wgt_tab_head wgt-corner-top" >
        
            <div class="wgt-container-controls">
              <div class="wgt-container-buttons" >
                <h2 style="width:120px;float:left;text-align:left;" >Docu</h2>
              </div>
              <div class="tab_outer_container">
                <div class="tab_scroll" >
                  <div class="tab_container"></div>
                </div>
             </div>
            </div>
          </div>
          
          <div id="wgt-tab-<?php echo $idPrefix ?>_docu-body" class="wgt_tab_body" >
            
            <?php foreach( $docus as $lang => $docu ){ ?>
            <div id="wgt-tab-<?php echo $idPrefix ?>-docu-<?php echo $lang ?>"  title="<?php echo $lang ?>" wgt_icon="xsmall/flags/<?php echo $lang ?>.png"  class="wgt_tab wgt-tab-<?php echo $idPrefix ?>_docu">
              <fieldset id="wgt-fieldset-<?php echo $idPrefix ?>-docu-<?php echo $lang ?>"  class="wgt-space bw6 lang-<?php echo $lang ?>"  >
                <legend>Docu <?php echo $lang ?></legend>
                
                <?php echo WgtForm::wysiwyg
                ( 
                  'Docu', 
                  'management-docu-'.$lang, 
                  $docu, 
                  array
                  ( 
                    'name' => 'management[docu]['.$lang.']'
                  ), 
                  $formId,
                  null,
                  true
                ); 
                ?>
              </fieldset>
            </div>
            <?php } ?>
        
          </div>
          
          <div class="wgt-panel" >
            <select 
              id="wgt-select-management-docu-new-lang" 
              name="label[lang]" 
              data_source="select_src-management-lang"
              class="wcm wcm_widget_selectbox wgte-lang" >
              <option>Select a language</option>
            </select>
            
            <button class="wgt-button wgta-append" ><?php echo $iconAdd ?> Add Language</button>
          </div>
          
          <div class="wgt-clear xxsmall" ></div>
          
          <var id="wgt-tab-<?php echo $idPrefix ?>_docu-cfg-i18n-input-tab" >
          {
            "key":"management-docu",
            "inp_prefix":"management[docu]",
            "form_id":"<?php echo $formId; ?>",
            "tab_id":"wgt-tab-<?php echo $idPrefix ?>_docu"
          }
          </var>
          
        </div>
        <div class="wgt-clear small" ></div>
    
    </div><!-- END tab name:docu -->

  </div>
</div>