<form
  method="get"
  accept-charset="utf-8"
  id="wgt-form-conact-search"
  action="ajax.php?c=Webfrap.Contact.search" ></form>

<div
  class="wgt-border-right"
  style="position:absolute;width:200px;top:0px;bottom:0px;left:0px;" >
  <div class="wgt-panel" ><button class="wgt-button wgtac_refresh" ><i class="icon-filter" ></i> Filter</button></div>
  <div id="wgt-tree-message-navigation" >
    <ul id="wgt-tree-message-navigation-tree" class="wgt-tree wgt-space" >
      <li><input
        type="checkbox"
        checked="checked"
        name="channel[inbox]"
        class="fparam-wgt-form-my_message-search" /> <a><strong>Inbox</strong></a> /
        <input
          type="checkbox"
          name="channel[outbox]"
          class="fparam-wgt-form-my_message-search" /> <a><strong>Outbox</strong></a>
        <ul>
          <li><input
            type="checkbox"
            checked="checked" /> All Posts
            <ul>
              <li><input
                type="checkbox"
                name="status[new]"
                class="fparam-wgt-form-my_message-search"  /> Only New Posts</li>
              <li><input
                type="checkbox"
                name="status[important]"
                class="fparam-wgt-form-my_message-search" /> Only Important Posts</li>
              <li><input
                type="checkbox"
                name="status[urgent]"
                class="fparam-wgt-form-my_message-search" /> Only Urgent Posts</li>
              <li><input
                type="checkbox"
                name="status[overdue]"
                class="fparam-wgt-form-my_message-search" /> Only Overdue Posts</li>
            </ul>
          </li>

          <li><input
            type="checkbox"
            name="type[message]"
            class="fparam-wgt-form-my_message-search" /> Messages</li>
          <li><input
            type="checkbox"
            name="type[notice]"
            class="fparam-wgt-form-my_message-search" /> Notices</li>
          <li><input
            type="checkbox"
            name="type[memo]"
            class="fparam-wgt-form-my_message-search" /> Memos</li>
          <li><input
            type="checkbox"
            name="type[appointment]"
            class="fparam-wgt-form-my_message-search" /> Appointments</li>
          <li><input
            type="checkbox"
            name="type[shared_doc]"
            class="fparam-wgt-form-my_message-search" /> Shared Docs</li>
          <li><input
            type="checkbox"
            name="type[task]"
            class="fparam-wgt-form-my_message-search" /> Tasks
            <ul>
              <li><input
                type="checkbox" /> Action Required</li>
              <li><input
                type="checkbox" /> Completed</li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="" ><strong>Drafts</strong></a></li>
      <li><a><strong>Templates</strong></a>
        <ul>
          <li><button class="wgt-button" ><i class="icon-plus-sign" ></i> Create Template</button></li>
        </ul>
      </li>
      <li><input
        type="checkbox"
        name="channel[archive]"
        class="fparam-wgt-form-my_message-search" /> <a><strong>Archiv</strong></a></li>
    </ul>
  </div>
</div>


<div id="wgt-message-list-message_list" style="position:absolute;top:0px;left:200px;right:0px;bottom:0px;" >
	<?php echo $ELEMENT->contactList; ?>
</div>

