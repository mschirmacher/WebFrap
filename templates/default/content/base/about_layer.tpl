<div class="contentArea" >

  <%=$this->includeAll('about')%>
  <div class="wgt-clear medium">&nbsp;</div>

</div>

<div class="wgt-clear medium">&nbsp;</div>

<script type="text/javascript">
<% foreach( $this->jsItems as $jsItem ){ %>
  <%=$ITEM->$jsItem->jsCode%>
<% } %>
</script>