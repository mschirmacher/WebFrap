<div
  class="wgt-border-right"
  style="position:absolute;width:200px;top:0px;bottom:0px;left:0px;" >

  <div class="wgt-panel" >
    <div class="left" ><h2>Attachments</h2></div>
    <div class="right" ><button 
      class="wgt-button wgac_add_attachment" ><i class="icon-plus-sign" ></i></button></div>
  </div>
  <div class="content hr2_3x" >
    <ul 
      id="wgt-list-show-msg-attach-<?php echo $VAR->msgNode->msg_id; ?>"
      class="wgt-list" >
      
    </ul>
  </div>
  
  <div class="wgt-panel" >
    <div class="left" ><h2>References</h2></div>
    <div class="right" ><button 
      class="wgt-button wgac_add_reference" ><i class="icon-plus-sign" ></i></button></div>
  </div>
  <div class="content hr2_3x" >
    <ul 
      id="wgt-list-show-msg-ref-<?php echo $VAR->msgNode->msg_id; ?>"
      class="wgt-list" >
      
    </ul>
  </div>
  
</div>

<div
  style="position:absolute;top:0px;left:200px;right:0px;" class="wgt-panel hx2" >
  <label>Sender:</label> <span><?php echo $VAR->msgNode->sender_name; ?></span><br />
  <label>Priority:</label> <?php echo $VAR->msgNode->priority; ?><br />
  <label>Sended:</label> <?php echo $this->i18n->timestamp( $VAR->msgNode->m_time_created );  ?><br />
</div>

<div style="position:absolute;top:60px;left:200px;right:0px;bottom:0px;" >
  <iframe
    src="plain.php?c=Webfrap.Message.showMailContent&objid=<?php echo $VAR->msgNode->msg_id; ?>"
    style="width:100%;min-height:500px;padding:0px;margin:0px;border:0px;" ></iframe>
</div>
